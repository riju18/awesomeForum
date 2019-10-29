<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // this is for vue because vue receives data as json. so we can't send 'avatar' attribute directly
    protected $appends = ['avatar'];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function question(){
        return $this->hasMany(Question::class);
    }


    public function answer(){
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute(){
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    // relationship with favorite pivot table
    // ---------------------------------------

    public function favorites(){
        return $this->belongsToMany(Question::class,'favorites','user_id','que_id')->withTimestamps();
    }

    // relationship with votables pivot table (morphed many to many)
    // -------------------------------------------------------------

    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable')->withTimestamps();
    }

    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable')->withTimestamps();
    }

    public function voteTheQuestion(Question $question, $vote){
        // hold the relationship
        // ------------------------
        $voteQue = $this->voteQuestions();
        return $this->_vote($voteQue, $question, $vote);
//        // check the question is already voted or not, if voted then update it otherwise assign it
//        // -------------------------------------------------------------------------------------------
//        if ($voteQue->where('votable_id',$question->id)->exists()){
//            $voteQue->updateExistingPivot($question, ['vote'=>$vote]);
//        }else{
//            $voteQue->attach($question,['vote'=>$vote]);
//        }
//
//        $question->load('votes');
//        $downVotes =  (int) $question->downVotes()->sum('vote');
//        $upVotes = (int) $question->upVotes()->sum('vote');
//        $question->votes_count = $downVotes + $upVotes;
//        $question->save();

    }

    public function voteTheAnswer(Answer $answer, $vote){
        // hold the relationship
        // ------------------------
        $voteAns = $this->voteAnswers();
        return $this->_vote($voteAns, $answer, $vote);
    }

    private function _vote($relation, $model, $vote){

        if ($relation->where('votable_id',$model->id)->exists()){
            $relation->updateExistingPivot($model, ['vote'=>$vote]);
        }else{
            $relation->attach($model,['vote'=>$vote]);
        }

        $model->load('votes');
        $downVotes =  (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');
        $model->votes_count = $downVotes + $upVotes;
        $model->save();
        return $model->votes_count;
    }

}
