<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // morphed many to many relationship with votables pivot table
    // -----------------------------------------------------------

    use VotableTrait;

    // -------------------------------------------------------------

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'views',
        'bestAnswer'
    ];

    // to send vue file as json format
    // --------------------------------
    protected $appends = [
        'is_favorited',
        'favorites_count'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answer(){
        return $this->hasMany(Answer::class,'que_id','id');
    }

    // important for pivot table
    // --------------------------
    public function favorites(){
        return $this->belongsToMany(User::class,'favorites','que_id','user_id')->withTimestamps();
    }

    public function isFavorited(){
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }

}
