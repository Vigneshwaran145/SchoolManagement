<?php

namespace App\Http\Controllers;

use App\MaterialClassMap;
use Illuminate\Http\Request;
use App\Student;
class MaterialClassMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'materialID' => 'required'
        ]);
        $students = Student::all();
        $classID = 0;
        $studID = $request->input("studID");
        foreach($students as $key=>$student)
        {
            if($student->studentID == $studID)
            {
                $classID = $student->classID;
            }
        }
        $material = MaterialClassMap::where('materialID', '=', $request->input('materialID'))
            ->where('classID', '=', $classID)
            ->where('studentID', '=', $studID)->get();
        
        if(!count($material)>0){
            MaterialClassMap::create([
                'materialID' => $request->input("materialID"),
                'classID' => $classID,
                'studentID' => $studID
            ]);
            return redirect("/students");    
        }
        return redirect("/students")->withErrors(['Already assigned']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialClassMap  $materialClassMap
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialClassMap $materialClassMap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialClassMap  $materialClassMap
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialClassMap $materialClassMap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialClassMap  $materialClassMap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialClassMap $materialClassMap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialClassMap  $materialClassMap
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialClassMap $materialClassMap)
    {
        //
    }
}
