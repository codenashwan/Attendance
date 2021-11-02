<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mark(){
        return $this->hasOne('App\Models\marks' , 'id_student','id');
    }
    public function attendances($id_subject){
        return $this->hasMany('App\Models\attendance' ,'id_student','id')->where('id_subject' , $id_subject);
    }
    public function nowattendance($id_subject, $today){
        return $this->hasOne('App\Models\attendance' ,'id_student','id')->where([['id_subject' , $id_subject],['at' , $today]])->exists();
    }
}
