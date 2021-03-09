<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
    	'name',
    	'description',
    	'company_id',
    	'user_id',
    	'days'
    ];

    //A project belongs to many users
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    //A project has one company
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}