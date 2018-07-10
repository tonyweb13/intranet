<?php

namespace App\Http\Controllers\Api\Action;

use App\Http\Controllers\Controller;
use App\Models\Action\Question;
use App\Models\Action\Vote;
use App\Models\Action\QuestionImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator, Input, Image, Carbon\Carbon, File, Storage;


class QuestionController extends Controller
{
    public function index()
    {
        $question = Question::all();

        return response()->json($question);
    }

    public function create(Request $request)
    {
        $question = new Question();
        $question->survey_id = $request->survey_id;
        $question->survey_type = $request->survey_type;
        $question->question = $request->question;
        $question->answers = serialize($request->answers);
        $question->image = $request->image;
        $question->created_by = Auth::user()->first_name .' '. Auth::user()->last_name;
        $question->save();

        return $question;
    }

    public function show(int $id, Request $request)
    {
        $survey = Question::updateOrCreate(['id' => $id], $request->all());

        return $survey;
    }

    public function edit(int $id)
    {
        $survey = Question::all()->where('id', $id)->first();

        return $survey;
    }

    public function destroy(int $id)
    {
        $survey = Question::findOrFail($id)->delete();

        return response()->json($survey);
    }

    public function getQuestion(int $id)
    {
        $questions = Question::where('survey_id', $id)->with('votes')->get();
        $new_question = $questions->map(function($question) {
            return [
                'id'=> $question->id,
                'survey_id' => $question->survey_id,
                'survey_type' => $question->survey_type,
                'question' => $question->question,
                'answers' => $question->answers,
                'image' => $question->image,
                'votes' => $question->votes->count(),
                'voted' => $question->votes->where('employee_no', Auth::user()->employee_no)->pluck('question_id')->first()
            ];
        });

        return response()->json($new_question);
    }

    public function imageUpload(request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            
            return response()->json(['errors' =>$validator->errors()]);
        } else {
            $imageData = $request->get('image');
            $exploded = explode(',', $imageData);
            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jpeg')) {
                $extension ='jpg';
            } else {
                $extension ='png';
            }

            $fileName = str_random(). '.' . $extension;
            $img = Image::make($decoded);
            $img->stream();

            $store = Storage::put('/vps/images/survey_form/' .$fileName, $img->__toString(), 'public');            
    
            return  $fileName;
            
        }
    }    
    
    public function castVote(Request $request)
    {
        if (Vote::where('employee_no', Auth::user()->employee_no)->exists()) {

            return response()->json(['errors' => 'You already Cast your vote.']);
        } else {

            $vote = new Vote();
            $vote->employee_no = Auth::user()->employee_no;
            $vote->survey_id = $request->survey_id;
            $vote->question_id = $request->question_id;
            $vote->name = $request->name;
            $vote->status = 1;
            $vote->save();

            return response()->json(['success' => 'Thank you for voting.']);
        }
    }

    public function voteCount(int $id)
    {
        $voted = Vote::where(['employee_no', Auth::user()->employee_no, 'status', 1])->get();

        return $count;
    }
    
}