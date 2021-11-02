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
    public $departments = [],$subjects = [],$students = [];
    public $stages = [
        ['id' => 1,'name' => '1'],
        ['id' => 2,'name' => '2'],
        ['id' => 3,'name' => '3'],
        ['id' => 4,'name' => '4']
    ];
    public $classes =[
        ['id' => 'A','name' => 'A'],
        ['id' => 'B','name' => 'B'],
        ['id' => 'C','name' => 'C'],
        ['id' => 'D','name' => 'D'],
    ];
    public $times = [
        ['name' => 'Morning' ,'id' => 1],
        ['name' => 'Evening','id' => 2]
    ];
    public $search,$stage,$department,$subject,$class,$time,$today;

    public function mount(){
        $this->departments = departments::all();
    }
    public function updatedstage(){
        $this->subjects = subjects::where([['id_department',$this->department],['id_stage' , $this->stage]])->get();
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
            'id_subject' => $this->subject,
            'at' => $this->today ?? now()->format('Y-m-d'),
        ]);
    }
    public function removeLastAttendance($id_student){
        attendance::where([
            ['id_student' , $id_student],
            ['id_subject' , $this->subject],
            ['at' ,  $this->today ?? now()->format('Y-m-d')],
        ])->delete();
    }
    public function render()
    {
        $this->students = students::where([
            ['name' , 'LIKE' , '%'.$this->search.'%'],
            ['id_department',$this->department],
            ['id_stage' , $this->stage],
            ['id_class' , $this->class],
            ['id_time' , $this->time]
            ])->get();
        return view('welcome')->extends('layouts.app');
    }
}
