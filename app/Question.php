<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }    

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    //Method to assign the answer as the best answer
    public function acceptBestAnswer($answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }


    //Eloquent table relation
    public function favorites(){
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
    }

    // Returns true if the question being shown is tagged as a favorite by the user
    public function isFavorited(){
        return $this->favorites()->where('user_id',auth()->id())->count() > 0;
        // return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    // Returns true if the question being shown is tagged as a favorite by the user
    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    // Returns count of how many users tagged the question as their favorite
    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
}
