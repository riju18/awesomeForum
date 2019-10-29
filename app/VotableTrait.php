<?php
namespace App;

trait VotableTrait{

    // morphed many to many relationship with votables pivot table
    // -----------------------------------------------------------

    public function votes(){
        return $this->morphToMany(User::class,'votable')->withTimestamps();
    }

    public function downVotes(){
        return $this->votes()->wherePivot('vote', -1);
    }

    public function upVotes(){
        return $this->votes()->wherePivot('vote', 1);
    }

}

