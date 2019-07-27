<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Standard;
use App\Section;
use App\Teacher;
use App\Class_Sub_mapping;
use App\Class_map;

use DB;
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classSubs = Class_Sub_mapping::all();
        $standards = Standard::all();
        $sections = Section::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $results = array();
        $classes = Class_map::all();
        $resClass = array();
        
        
        foreach($classes as $key => $class)
        {
            foreach($standards as $stdKey => $standard)
            {
                if($class->standardID == $standard->standardID){
                    $stdName = $standard->standard;
                }
            }
            foreach($sections as $secKey => $section){
                if($class->sectionID == $section->sectionID){
                    $secName = $section->section;
                }
            }
            $resClass[$class->classID] = array($stdName => $class->standardID , $secName => $class->sectionID);
        }
    //    return $resClass;

        foreach($classSubs as $key => $classSub)
        {
            foreach($resClass as $clsKey=> $class)
            {
                if($classSub->classID == $clsKey)
                {
                    $tmpClass = $class;
                }
            }
            foreach($subjects as $sKey => $subject)
            {
                if($subject->subjectID == $classSub->subjectID)
                {
                    $tmpSubject = array($subject->subName => $subject->subjectID);
                }
            }
            foreach($teachers as $tKey => $teacher)
            {
                if($classSub->teacherID == $teacher->teacherID){
                    $tmpTeacher = array($teacher->teacherName => $teacher->teacherID);
                }
            }
            $results[$key] = array($tmpClass, $tmpSubject, $tmpTeacher);
        }
        
        return view('subjects.show', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $standards = Standard::all();
        $sections = Section::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('subjects.create', compact('standards', 'sections', 'subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $class= Class_map::create([
            'standardID' => $request->input('standard'),
            'sectionID' => $request->input('section')
        ]); 
        $len = $request->input('subjects');
        for($i=0;$i<count($len);$i++)
        {
            Class_Sub_mapping::create([
                'teacherID' => $request->input('teachers')[$i],
                'subjectID' => $request->input('subjects')[$i],
                'classID' => $class->classID
            ]);
        }
        
        return redirect('teachers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
