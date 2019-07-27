<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Standard;
use App\Section;
use App\Teacher;
use App\Class_Sub_mapping;
use App\Class_map;

class ClassMapController extends Controller
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
        
        return view('class.show', compact('results', 'resClass'));
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

                $standards = Standard::all();
                $sections = Section::all();
                $subjects = Subject::all();
                $teachers = Teacher::all();
                return view('class.create', compact('standards', 'sections', 'subjects', 'teachers'));
            }
            else
            {
                return redirect('/classes')->withErrors(['You are not authorized to create class']);
            }
        }
        return redirect('/login')->withErrors(['You are not logged in']);
        
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
            'standard' => 'required',
            'section' => 'required',
        ]);
        $len = count($request->input('subjects'));
        
        $classID = Class_map::where('standardID', '=', $request->input('standard'))
                            ->where('sectionID', '=', $request->input('section'))
                            ->get();
        
        if(isset($classID[0]->classID))
        {
            $len = $request->input('subjects');
            for($i=0;$i<count($len);$i++)
            {
                Class_Sub_mapping::create([
                    'teacherID' => $request->input('teachers')[$i],
                    'subjectID' => $request->input('subjects')[$i],
                    'classID' => $classID[0]->classID
                ]);
            }
            return redirect('/classes');
        }
        else
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
            return redirect('/classes');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Class_map  $class_map
     * @return \Illuminate\Http\Response
     */
    public function show(Class_map $class_map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Class_map  $class_map
     * @return \Illuminate\Http\Response
     */
    public function edit(Class_map $class_map)
    {
        if(auth()->check()){
            if(auth()->user()->type == "ADMIN")
            {
                $sstd = $_GET['std'];
                $ssec = $_GET['sec'];
                $ssub = $_GET['sub'];
                $steacher = $_GET['teacher'];
                $classID = $_GET['clsID'];
                $standards = Standard::all();
                $sections = Section::all();
                $subjects = Subject::all();
                $teachers = Teacher::all();

                $class_map = Class_map::findOrFail($classID);
                return view('class.update', compact('classID','class_map', 'standards', 'sections', 'subjects', 'teachers', 'sstd', 'ssec', 'ssub', 'steacher'));
            }
            else
            {
                return redirect('/classes')->withErrors(['You are not authorized to edit classes']);
            }
        }
        else
        {
            return redirect('/login')->withErrors(['You are not logged in']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Class_map  $class_map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Class_map $class_map)
    {
        $class_map = Class_map::findOrFail($request->input('classID'));
        
        session_start();
        $stdID = $_SESSION['stdID'];
        $secID = $_SESSION['secID'];
        $subID = $_SESSION['subID'];
        $teacherID = $_SESSION['teacherID'];
        
        // return $class_map;
        if($class_map->standardID == $request->input('standard') && $class_map->sectionID == $request->input('section'))
        {
            $cls = Class_Sub_mapping::where('classID','=',$request->input('classID'))
            ->where('teacherID', '=', $request->input('teacher'))
            ->where('subjectID', '=', $request->input('subject'))
            ->get();
            if(count($cls) > 0)
            {
                return redirect('/classes')->withErrors(['Already exists!']);
            }


            Class_Sub_mapping::where('classID','=',$request->input('classID'))
            ->where('subjectID', '=', $subID)
            ->where('teacherID', '=', $teacherID)
            ->update([
                'teacherID' => $request->input('teacher'),
                'subjectID' => $request->input('subject')
            ]);
            // $c->save();
            return redirect('/classes');
        }
        else
        {
            
            $class = Class_map::where('standardID', '=', $request->input('standard'))->where('sectionID', '=', $request->input('section'))->get();
            //return $classID;
            if(!count($class)==0)
            {
                
                Class_Sub_mapping::find($class[0]->classID)
                ->where('subjectID', '=', $subID)
                ->where('teacherID', '=', $teacherID)
                ->update([
                    'classID' => $class[0]->classID,
                    'teacherID' => $request->input('teacher'),
                    'subjectID' => $request->input('subject')
                ]);
                return redirect('/classes');


            }
            else
            {
                $class= Class_map::create([
                    'standardID' => $request->input('standard'),
                    'sectionID' => $request->input('section')
                ]); 
                Class_Sub_mapping::create([
                    'teacherID' => $request->input('teacher'),
                    'subjectID' => $request->input('subject'),
                    'classID' => $class->classID
                ]);
            
                return redirect('/classes');
                
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Class_map  $class_map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Class_map $class_map)
    {
        //
    }
}
