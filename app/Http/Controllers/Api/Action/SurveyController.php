<?php

namespace App\Http\Controllers\Api\Action;

use App\Http\Controllers\Controller;
use App\Models\Action\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('questions')->get();
        $new_surveys = $surveys->map(function($survey) {
            return [
                'id'=> $survey->id,
                'survey_name' => $survey->survey_name,
                'introduction' => $survey->introduction,
                'conclusion' => $survey->conclusion,
                'created_by' => $survey->created_by,
                'questions' => $survey->questions->count()
            ];
        });
        
        return $new_surveys;
    }

    public function create(Request $request)
    {
        $survey = new Survey();
        $survey->survey_name = $request->survey_name;
        $survey->introduction = $request->introduction;
        $survey->conclusion = $request->conclusion;
        $survey->created_by = Auth::user()->first_name .' '. Auth::user()->last_name;
        $survey->save();

        return $survey;
    }

    public function show(int $id, Request $request)
    {
        $survey = Survey::updateOrCreate(['id' => $id], $request->all());

        return $survey;
    }

    public function edit(int $id)
    {
        $survey = Survey::all()->where('id', $id)->first();

        return $survey;
    }

    public function destroy(int $id)
    {
        $survey = Survey::findOrFail($id)->delete();

        return response()->json($survey);
    }

    public function getSurvey(int $id)
    {
        $survey = Survey::where('id', $id)->get();

        return response()->json($survey);
    }

}
