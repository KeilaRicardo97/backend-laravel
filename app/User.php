<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    const user_verificado = '1';
    const user_no_verificado = '0';
    const img_user = 'null';
    const user_admin = 'super';
    const user_teacher = 'teacher';
    const user_student = 'student';
    protected  $table = 'users';
    protected $dates = ['deleted_at'];
    
    
    protected $hidden = [
        'password', 
        'remember_token',
        // 'verification_token'
    ];
    
    protected $fillable = [
        'name', 
        'lastname', 
        'Biography', 
        'Facebook', 
        'Twitter', 
        'Linkedin', 
        'Paypal_client_id', 
        'Paypal_secret_key', 
        'Stripe_public_key', 
        'Stripe_secret_key', 
        'email', 
        'password', 
        'verified', 
        'verification_token', 
        'role', 
        'img', 
        
    ];

    public function isVerifiend() {
        return $this->verified == User::user_verificado;
    }
    public function isAdmin() {
        return $this->role == User::user_admin;
    }
    public function isTeacher() {
        return $this->role == User::user_teacher;
    }   
    public function isStudent() {
        return $this->role == User::user_student;
    }
    public static function GenerateToken() {
        return str_random(40);
    }

    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }
    public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }
    public function getNameAttribute($value){
        return ucwords($value);
    }
    public static function generatePassword(){
     $newPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    return $newPass;
}
}
