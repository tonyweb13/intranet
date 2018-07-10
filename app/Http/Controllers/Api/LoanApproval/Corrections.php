<?php

namespace App\Http\Controllers\Api\LoanApproval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LoanApproval\Corrections as CorrectionsItems;
use App\Models\Vps\ {
    Users,
    UsersGroups
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LoanApproval\Application;
use App\Models\LoanApproval\ApplicationProcess;
use App\Models\LoanApproval\Corrections as CorrectionModel;

class Corrections extends Controller
{
    public function getCorrections(Request $request)
    {
        $application = CorrectionsItems::with('correctionItems')->whereNull('parent_correction_id');

        return $application->get()->toJson();
    }

    public function appToCorrection(Request $request)
    {
        $response['msg'] = '';
        $response['errors'] = 0;
        try {
            /* Update Application Status to Pending */
            $apps= Application::find($request->id);
            $apps->status         = 4;
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->update();

            /* Add Application Process Status to Pending */
            $corrections = CorrectionModel::whereIN('id', $request->corrections['checklist']);
            $corrections_data['correction_text'] = $corrections->get(['correction_name', 'code'])->toArray();
            $corrections_data['correction_request'] = $request->corrections;


            ApplicationProcess::addApplicationProcess('correction', $request->id, 4, Auth::id(), json_encode($corrections_data));

            $response['msg'] = 'Application successfully return for correction';

        } catch (Exception $e) {
            $response['msg'] = 'Caught exception: '. $e->getMessage();
            $response['errors'] = 1;
        }

        return [
            'msg' => $response['msg'],
            'error' => $response['errors']
        ];

    }
}
