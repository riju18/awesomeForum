<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {
        $allQues = Question::latest()->paginate(5);
        return view('questions.index', compact('allQues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    public function store(AskQuestionRequest $request)
    {
        $queData = Question::create([
                'title' => $request['title'],
                'body' => $request['body'],
                'user_id' => Auth::user()->id
            ]
        );
        if ($queData){
            return redirect('/questions')->with('success', 'question is submitted successfully');
        }
        return redirect()->back()->withInput()->with('error', 'question is not submitted');
    }

    public function show(Question $question)
    {
        $parQue = Question::findOrFail($question->id);
        $question->increment('views');
        return view('questions.show', compact('parQue'));
    }


    public function edit(Question $question)
    {
        if (Gate::allows('update', $question)){
            $editQue = Question::findOrFail($question->id);
            return view('questions.edit', compact('editQue'));
        }
        abort(403, 'access denied');
    }


    public function update(AskQuestionRequest $request, Question $question)
    {

        $updateQue =  $question->update($request->only('title','body'));
        if ($updateQue){
            return redirect('/questions')->with('success', 'question is updated successfully');
        }
        return redirect()->back()->withInput()->with('error','question is not updated');

    }

    public function destroy(Question $question)
    {
        if (Gate::allows('delete', $question)){
            $delteQue = $question->delete();
            if ($delteQue){
                return redirect('/questions')->with('success', 'question is deleted successfully');
            }
            return redirect()->back()->withInput()->with('error','question is not deleted');
        }
        abort(403,'access denied');
    }
}
