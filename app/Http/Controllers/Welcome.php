<?php

namespace App\Http\Controllers;

use Livewire\Component;
use App\Models\departments;
use App\Models\subjects;
use App\Models\students;
use App\Models\marks;
use App\Models\attendance;
use DB;
class Welcome extends Component
{
    public $stages = [1,2,3,4] , $departments = [],$subjects = [],$classes = ['A','B','C','D'],$times = [['name' => 'Morning' ,'id' => 1] , ['name' => 'Evening','id' => 2]],$students = [];
    public $stage,$department,$subject,$class,$time;

    protected $listeners = ['stageChanged'];
    public function mount(){
        $this->departments = departments::all();
    }
    public function updatedstage(){
        $this->subjects = subjects::where([['id_department',$this->department],['id_stage' , $this->stage]])->get();
    }
    public function submit(){
        $this->students = students::where([
            ['id_department',$this->department],
            ['id_stage' , $this->stage],
            ['id_class' , $this->class],
            ['id_time' , $this->time]
            ])->get();
    }
    public function mark($id_student,$currentValue , $up){
        marks::updateOrcreate([
            'id_student' => $id_student,
            'id_subject' =>$this->subject,
        ],[
            'value'=> $currentValue + ($up ? 1 : -1),
        ]);
    }
    public function attendance($id_student){
        attendance::create([
            'id_student' => $id_student,
            'id_subject' => 1,
            'at' => now(),
        ]);
    }
    public function removeLastAttendance($id_student){
        attendance::where([
            ['id_student' , $id_student],
            ['id_subject' , 1],
            ['at' , '<' , now()->subMinute()],
        ])->delete();
    }
    public function render()
    {
        $this->students = students::get();
        return view('welcome')->extends('layouts.app');
    }
}
