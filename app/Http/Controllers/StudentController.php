<?php

namespace App\Http\Controllers;

use App\Student;
use App\Standard;
use App\Section;
use App\Class_map;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Notifications\StudentCreated;
use App\Mail\mailToStudent;
use App\Http\Controllers\Auth\RegisterController;
use App\Student_User;
class StudentController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        
        $standards = Standard::all();
        $sections = Section::all();
        $classes = Class_map::all();
        $resultClasses = array();
        foreach($classes as $key=>$value)
        {
            foreach($sections as $secid => $section)
            {
                foreach($standards as $stdid => $standard)
                {
                    if($standard->standardID == $value->standardID && $section->sectionID == $value->sectionID)
                    {
                        $resultClasses[$value->classID] = $standard->standard." - ".$section->section;
                    }
                }
            }
        }
        $students = Student::all();
        return view('students.show', compact('resultClasses', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!(auth()->check()))
        {
            return redirect('/login')->withErrors(['You are not logged in']);
        }
        $standards = Standard::all();
        $sections = Section::all();
        $classes = Class_map::all();
        $resultClasses = array();
        foreach($classes as $key=>$value)
        {
            foreach($sections as $secid => $section)
            {
                foreach($standards as $stdid => $standard)
                {
                    if($standard->standardID == $value->standardID && $section->sectionID == $value->sectionID)
                    {
                        $resultClasses[$value->classID] = $standard->standard." - ".$section->section;
                    }
                }
            }
        }
        
        return view('students.create', compact('resultClasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'studentName' => ['required'],
            'mail' => ['required','email'],
            'dob' => ['required']
            
        ]);
    
        $mailID = $request->input('mail');
        $name = $request->input('studentName');
        // Notification::route('mail', $mailID)->notify(new StudentCreated($mailID));
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
        $password = substr( str_shuffle( $chars ), 0, 10 );
        $data = [
            'name' => $name,
            'email' => $mailID,
            'password' => $password,
            'type' => 'STUDENT'
        ];
        $user = RegisterController::create($data);
        $userID = $user->id;
        Mail::to($mailID)->send(new mailToStudent($name, $password));
        $student = Student::create([
            'studentName' => $request->input('studentName'),
            'stud_mail' => $mailID,
            'classID' => $request->input('class'),
            'dob' => $request->input('dob'),
            'studentCode' =>  rand(1000,9999)
        ]);
        $studentID = $student->studentID;
        Student_User::create([
            'studentID' => $studentID,
            'userID' => $userID
        ]);
        
        return redirect('/students');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        if(!(auth()->check()))
        {
            return redirect('/login')->withErrors(['You are not logged in']);
        }
        $standards = Standard::all();
        $sections = Section::all();
        $classes = Class_map::all();
        $resultClasses = array();
        foreach($classes as $key=>$value)
        {
            foreach($sections as $secid => $section)
            {
                foreach($standards as $stdid => $standard)
                {
                    if($standard->standardID == $value->standardID && $section->sectionID == $value->sectionID)
                    {
                        $resultClasses[$value->classID] = $standard->standard." - ".$section->section;
                    }
                }
            }
        }
        
        return view('students.edit', compact('student', 'resultClasses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $stud = Student::findOrFail($student->studentID);
        $stud->studentName = $request->input('sName');
        $stud->stud_mail = $request->input('mail');
        $stud->dob = $request->input('dob');
        $stud->classID = $request->input('class');
        $stud->save();
        return (redirect('/students'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
