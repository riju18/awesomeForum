<?php

namespace App\Http\Controllers;

use App\Question;
use http\Env\Response;
use Illuminate\Http\Request;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        $voteCount = auth()->user()->voteTheQuestion($question, $vote);
        if (request()->expectsJson()){
            return response()->json([
                'message'=> 'your vote is submitted',
                'votes' => $voteCount
            ]);
        }
        return back();
    }
}
