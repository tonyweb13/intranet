<?php

namespace App\Http\Controllers\Api\Action;

use App\Http\Controllers\Controller;
use App\Models\Action\SurveyResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SurveyResultController extends Controller
{
    public function index()
    {
        $survey = SurveyResult::all();
        
        return $survey;
    }

    public function create(Request $request)
    {
        $survey = new SurveyResult();
        $survey->employee_no = Auth::user()->employee_no;
        $survey->survey_id = $request->survey_id;
        $survey->name = Auth::user()->first_name .' '. Auth::user()->last_name;
        $survey->question_id = serialize($request->question_id);
        $survey->user_question = $request->user_question;
        $survey->user_answers = serialize($request->user_answers);
        $survey->status = 1;
        $survey->save();

        return $survey;
    }

    public function show(int $id, Request $request)
    {
        $survey = SurveyResult::updateOrCreate(['id' => $id], $request->all());

        return $survey;
    }

    public function edit(int $id)
    {
        $survey = SurveyResult::all()->where('id', $id)->first();

        return $survey;
    }

    public function destroy(int $id)
    {
        $survey = SurveyResult::findOrFail($id)->delete();

        return response()->json($survey);
    }

}
