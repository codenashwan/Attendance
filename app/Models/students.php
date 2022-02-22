<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\attendance;
use Carbon\Carbon;
class students extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mark(){
        return $this->hasOne('App\Models\marks' , 'id_student','id');
    }
    public function attendances($id_subject,$type=null){
        return $this->hasMany('App\Models\attendance' ,'id_student','id')->where([['id_subject' , $id_subject],['type' ,$type]]);
    }
    public function nowattendance($id_subject, $today , $type=null){
        return $this->hasOne('App\Models\attendance' ,'id_student','id')->where([['id_subject' , $id_subject],['at' , $today], ['type' , $type ]])->exists();
    }
 
    public function ShowAllAttendances($id_subject,$type=null){
        $arr = [];
        $attendances = attendance::where([['id_student' , $this->id] , ['id_subject'  , $id_subject],['type' ,$type]])->get();
        foreach ($attendances as $attendance){
            $arr[] = $attendance->at->format('Y-M-d');
            continue;
        }
        return implode(" , " ,  $arr);
    }

    public function emoji(){
        if($this->first_term_mark_20 >= 18){
            return " 🎉 ";
        }
    }
  
}
