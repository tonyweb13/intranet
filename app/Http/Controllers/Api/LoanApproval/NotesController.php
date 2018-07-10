<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\Notes;
use App\Models\LoanApproval\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime, DateTimeZone,Validator;

class NotesController extends Controller
{

    public function index()
    {
        $notes = Notes::all();
        
        return response()->json($notes);
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);

        $data =  $string ? implode(', ', $string) . ' ago' : 'just now'; 

        return response()->json($data);
        
    }

    public function toDateInterval($seconds) {
        return date_create('@' . (($now = time()) + $seconds))->diff(date_create('@' . $now));
    }

    public function create(request $request)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'required'
        ]);

        if ($validator->fails()) {

            $return['errors'] = 'Notes is required!';
            $return['message'] = '';

            return $return;
        } else { 
            $notes = new Notes;
            $notes->created_by = Auth::user()->first_name .' '. Auth::user()->last_name;
            $notes->application_id = $request->application_id;
            $notes->loan_no = $request->loan_no;
            $notes->status = $request->status;
            $notes->notes = $request->notes;
            $notes->save();

            $return['errors'] = '';
            $return['message'] = 'Notes successfully added!';
            return $return;
        }
    }

    public function show(int $id, Request $request)
    {
        $notes = Notes::find($id);
        return $notes->toJson(JSON_PRETTY_PRINT);
    }

    public function edit(int $id)
    {
       $notes = Notes::all()->where('id', $id)->first();

       return $notes;
    }

    public function destroy(int $id)
    {
        $notes = Notes::findOrFail($id)->delete();

        return $notes;
    }

    public function status(int $statusid, string $loan_id)
    {
        $notes= Application::where('status',$statusid)
                            ->where('loan_no', '=',  $loan_id)
                            ->with('notes')->first();
        $secs = [];
        
        foreach ($notes->notes as $key => $val) {
       
            $secs[$key] = $this->time_elapsed_string($val->created_at, true);
        }

        return response()->json([
            'notes'=>$notes->notes,
            'diff' =>$secs
        ]);
    }

}
