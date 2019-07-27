<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use App\Subject;
use App\Teacher_sub_mapping;
use Notification;
use App\Notifications\TeacherCreated;
use App\Mail\mailToTeacher;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\User;
use Auth;
use App\user_teacher;
use App\Http\Controllers\Auth\RegisterController;

class TeacherController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['index']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $teacherSubs = Teacher_sub_mapping::all();
        return view('teachers.show', compact('teachers', 'subjects', 'teacherSubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(auth()->check()){
        if(auth()->user()->type == "ADMIN")
        {
            $subjects = Subject::all();
            return view('teachers.createTeacher', compact('subjects'));    
        }
        else
        {
            return redirect('/teachers')->withErrors(['You are not authorized to create teacher']);
        }
        }
        
        return redirect('/login')->withErrors(['You are not logged in']);;
        
        
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
            'teacherName' => ['required', 'min:3'],
            'mail' => ['required','email'],
            'qualification' => ['required'],
            'dob' => ['required'],
            'address' => ['required', 'min:3'],
            'subjects' => ['required']
        ]);
        $mailID = $request->input('mail');
        $name = $request->input("teacherName");
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
        $password = substr( str_shuffle( $chars ), 0, 10 );
        $data = [
            'name' => $name,
            'email' => $mailID,
            'password' => $password,
            'type' => 'TEACHER'
        ];
        // $obj = new RegisterController();
        // $obj.create($data);
        $user = RegisterController::create($data);
        
        Mail::to($mailID)->send(new mailToTeacher($name, $password));
        // Notification::route('mail', $mailID)->notify(new TeacherCreated($mailID));
        $userID = $user->id;
        $teacher = Teacher::create([
            'teacherName' => $request->input('teacherName'),
            'teacher_mail' => $request->input('mail'),
            'qualification' => $request->input('qualification'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address')
        ]);
        $teacherID = $teacher->teacherID;
        user_teacher::create([
            'user_id' => $userID,
            'teacher_id' => $teacherID
        ]);
        foreach($request->input('subjects') as $key=>$val){
            $teacherSub = new Teacher_sub_mapping;
            $teacherSub->teacherID = $teacher->teacherID;
            $teacherSub->subjectID = $val;
            $teacherSub->save();
        }
        
        return redirect('/teachers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        if(auth()->check()){
            if(!(auth()->user()->type == "ADMIN"))
            {
                return redirect('/teachers')->withErrors(['You are not authorized to edit teacher']);
            }
            
        }
        else
        {
            return redirect('/login')->withErrors(['You are not logged in']);;
        
        }
        $teachers = Teacher::findOrFail($teacher);
        $teacherSubs = Teacher_sub_mapping::where('teacherID','=',$teacher->teacherID)->get();
        $subjects = Subject::all();
        return view('teachers.edit', compact('teachers', 'teacherSubs', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $t = Teacher::find($teacher->teacherID);
        $t->teacherName = $request->input('tName');
        $t->teacher_mail = $request->input('mail');
        $t->qualification = $request->input('qualification');
        $t->address = $request->input('address');
        $t->dob = $request->input('dob');
        Teacher_sub_mapping::where('teacherID', '=', $teacher->teacherID)->delete();
        foreach($request->input('subjects') as $key=>$val){
            $teacherSub = new Teacher_sub_mapping;
            $teacherSub->teacherID = $teacher->teacherID;
            $teacherSub->subjectID = $val;
            $teacherSub->save();
        }
        $t->save();
        return redirect('/teachers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        
    }
}
