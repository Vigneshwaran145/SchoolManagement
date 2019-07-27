<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use App\Standard;
use App\Section;
use App\Class_map;
use App\Subject;
use App\Teacher;
use App\MaterialClassMap;
use App\user_teacher;
use App\User;
use App\Student;
use App\Student_User;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!(auth()->check()))
        {
            return redirect('/login')->withErrors(['You are not logged in']);;
        }
        $students = Student::all();
        $materials = material::all();
        $material_classes = MaterialClassMap::all();
        $subjects = Subject::all();
        $userID = auth()->id();
        $user = User::find($userID);
        if($user->type=="STUDENT")
        {
            $student_user = Student_User::where('userID', '=', $userID)->get();
            $studentID = $student_user[0]->studentID;
            $student = Student::find($studentID);
            $classID = $student->classID;
            $materialsClass = MaterialClassMap::where('classID', '=', $classID)->get();
            $materialID = array();
            $i = 0;
            foreach($materialsClass as $key=>$material)
            {
                $materialID[$i] = $material->materialID;
                $i++;
            }
            $materials = material::find($materialID);
            
            return view('materials.show', compact('materials', 'material_classes', 'subjects'));
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
        
        
        return view('materials.show', compact('materials', 'material_classes', 'resultClasses', 'subjects'));
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
            return redirect('/login')->withErrors(['You are not logged in']);;
        }
        
        $subjects = Subject::all();
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
        // return auth()->user();
        // return $subjects;
        return view('materials.create', compact('resultClasses', 'subjects'));
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
            'material' => 'required|mimes:pdf,docx,doc,mp4,odt,3GP,WMV,AVI,HDV',
            'class' => 'required',
            'subject' => 'required'
        ]);
        if((auth()->user()->type == "ADMIN"))
        {
            $teacherID = 0;
        }
        else
        {
            $user_id = auth()->id();
            $teachers = Teacher::all();
            $teacherID = 0;
            
        }
        // return $request;
        $fileName = $request->file('material')->getClientOriginalName();
        $ext = $request->file('material')->getClientOriginalExtension();
        $file = $request->file('material')->storeAs('materials', $fileName);
        $material = material::create([
            'subjectID' => $request->input('subject'),
            'file' => $file,
            'fileName' => $fileName,
            'extension' => $ext,

        ]);
        MaterialClassMap::create([
            'classID' => $request->class,
            'materialID' => $material->materialID
        ]);
        return redirect('/materials');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
