<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke( Answer $answer)
    {
        $vote = (int) request()->vote;
        $voteCount = auth()->user()->voteTheAnswer($answer, $vote);
        if (request()->expectsJson()){
            return response()->json([
                'message'=> 'your vote is submitted',
                'votes' => $voteCount
            ]);
        }
        return back();
    }
}
