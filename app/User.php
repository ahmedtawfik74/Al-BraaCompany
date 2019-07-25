<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['image_path'];

    //Accessors and Mutators
    public function getFirstNameAttribute($value){
        return ucfirst($value);
    }//end of first name to make first later capital of first word
    public function getLastNameAttribute($value){
        return ucfirst($value);
    }//end of first name to make first later capital of second word

    public function getImagePathAttribute(){
        return asset('uploads/users_images/'.$this->image);
    }
}//end of model
