<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

use App\Answer;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $answer->bestAnswer = 'yes';
        $answer->save();

        if (request()->expectsJson()){
            return response()->json([
                'message'=>'you marked this answer as best'
            ]);
        }

        return back();
    }
}
