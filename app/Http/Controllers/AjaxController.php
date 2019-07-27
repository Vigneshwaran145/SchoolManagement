<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\Subject;
use App\user_teacher;
use App\Standard;
use App\Section;
use App\Class_map;
use App\Class_Sub_mapping;
use App\User;
use App\Teacher_sub_mapping;
use App\Material;

class AjaxController extends Controller
{
    public function fetchSubject(Request $request)
    {
        $subjects = Subject::all();
        if(isset($request->rowLength) && isset($request->subjects))
        {
            $filteredSubs = array();
            $i = 0;
            $subjectIDs = $request->subjects;
            foreach($subjects as $key=>$subject)
            {
                if(!in_array($subject->subjectID, $subjectIDs))
                {
                    $filteredSubs[$i] = $subject;
                    $i += 1;
                }
            }
            return $filteredSubs;
        }
        
        return $subjects;
    }
    public function fetchTeacher(Request $request)
    {
        if(isset($request->subjectID)){
            $subID = $request->subjectID;
            
            $teacher_subs = Teacher_sub_mapping::all();
            $teachers = Teacher::all();
            $resTeachers = array();
            $i = 0;
            foreach($teacher_subs as $key=>$teacher_sub)
            {
                foreach($teachers as $tkey => $teacher)
                {
                    if($teacher->teacherID == $teacher_sub->teacherID && $teacher_sub->subjectID == $subID)
                    { 
                        $resTeachers[$i] = $teacher;
                        $i+=1;
                    }
                }
            }
            
            // $teachers = Teacher::find($teacher->teacherID);
            
            return $resTeachers;
        }
        
    }
    public function fetchSubForAssigning(Request $request)
    {
        $user_id = auth()->id();
        $teachers = Teacher::all();
        $user_teachers = user_teacher::all();
        $teacherID = 0;
        foreach($teachers as $key=>$teacher)
        {  
            foreach($user_teachers as $k => $user_teacher)
            {
                if($user_teacher->teacherID == $teacher->teacherID && $user_teacher->userID == $user_id)
                {
                    $teacherID = $teacher->teacherID;
                }
            }
        }
        $subjects = Subject::all();
        if($teacherID == 0)
        {
            return $subjects;            
        }
        $materials = Material::all();
        $results = array();
        $i = 0;
        $subByTeachers = array();
        $teacher_sub_mappings = Teacher_sub_mapping::all();
        foreach($teacher_sub_mappings as $key=>$teacher_sub_mapping)
        {
            foreach($materials as $mkey => $material)
            {
                if($material->teacherID == $teacherID && $teacher_sub_mapping->subjectID == $material->subjectID && $teacher_sub_mapping->teacherID == $teacherID )
                {
                    $subByTeachers[$i] = $teacher_sub_mapping;
                    $i++;
                }   
            }
        }
        $i=0;
        foreach($subjects as $key=>$subject)
        {
            foreach($subByTeachers as $stid=>$subByTeacher)
            {
                if($subByTeacher->subjectID == $subject->subjectID)
                {
                    $results[$i] = $subject;
                    $i++;       
                }
            }
        }

        return $results;
    }
    public function fetchMaterials(Request $request)
    {
        $subID = $request->subID;
        $materials = Material::all();
        $results = array();
        $i = 0;
        foreach($materials as $key=>$material)
        {
            if($material->subjectID == $subID)
            {
                $results[$i] = $material;
                $i++;
            }
        }
        return $results;
    }
    public function fetchSubForMaterial(Request $request)
    {
        $user_id = auth()->id();
        $teachers = Teacher::all();
        $user_teachers = user_teacher::all();
        $teacherID = 0;
        foreach($teachers as $key=>$teacher)
        {  
            foreach($user_teachers as $k => $user_teacher)
            {
                if($user_teacher->teacherID == $teacher->teacherID && $user_teacher->userID == $user_id)
                {
                    $teacherID = $teacher->teacherID;
                }
            }
        }
        $results = array();
        $subjects = Subject::all();
        if($teacherID == 0)
        {
            return $subjects;
        }
        $teacher_sub_mappings = Teacher_sub_mapping::all();
        $i = 0;
        foreach($subjects as $key=>$subject)
        {
            foreach($teacher_sub_mappings as $tskey => $teacher_sub_mapping)
            {
                if($subject->subjectID == $teacher_sub_mapping->subjectID && $teacher_sub_mapping->teacherID == $teacherID)
                {
                    $results[$i] = $subject;
                    $i++;
                }
            }
        }
        return $results;
    }
    
    public function fetchSection(Request $request)
    {
        $stdID = $request->stdID;
        $sections = Section::all();
        $class_maps = Class_map::all();
        foreach($sections as $key=>$section)
        {
            $flag = TRUE;
            foreach($class_maps as $ckey=>$class_map)
            {                
                if($class_map->sectionID == $section->sectionID && $class_map->standardID == $stdID)
                {
                    $flag = FALSE;
                }
            }
            if($flag)
            {
                $results[$section->sectionID] = $section->section;
            
            }
        }
        return $results;
    }
    public function fetchTeachersClass(Request $request)
    {
        $user_teachers = user_teacher::all();
        $teachers = Teacher::all();
        $teacherID = 0;
        $userID = auth()->id();
        $user = User::find($userID);
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
        
        if($user->type == "ADMIN"){
            return $resultClasses;
        }
        foreach($teachers as $teacherKey=>$teacher)
        {   
            foreach($user_teachers as $key=>$user_teacher)
            {
                if($user_teacher->teacher_id == $teacher->teacherID && auth()->id() == $user_teacher->user_id)
                {
                    $teacherID = $teacher->teacherID;
                }
            }
        }
        $class_subs = Class_Sub_mapping::all();
        $classes = array();
        foreach($class_subs as $key=>$class_sub)
        {
            if($class_sub->teacherID == $teacherID){
                $classes[$class_sub->classID] = $resultClasses[$class_sub->classID];
            }
        }
        return $classes;
        
    }

    public function fetchSubByClass(Request $request)
    {
        $classID = $request->classID;
        $userID = auth()->id();
        $user = User::find($userID);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $user_teachers = user_teacher::all();
        $teacher_subs = Teacher_sub_mapping::all();
        if($user->type == "ADMIN")
        {
            return $subjects;
        }
        $teacherID = 0;
        foreach($teachers as $teacherKey=>$teacher)
        {   
            foreach($user_teachers as $key=>$user_teacher)
            {
                if($user_teacher->teacher_id == $teacher->teacherID && auth()->id() == $user_teacher->user_id)
                {
                    $teacherID = $teacher->teacherID;
                }
            }
        }
        $results = [];
        $i=0;
        foreach($teacher_subs as $key=>$teacher_sub)
        {
            if($teacher_sub->teacherID == $teacherID)
            {
                $results[$i] = $teacher_sub;
                $i++;
            }
        }
        $subjs = [];
        $i = 0;
        foreach($subjects as $key=>$subject)
        {
            foreach($results as $result)
            {
                if($result->subjectID == $subject->subjectID)
                {
                    $subjs[$i] = $subject;
                    $i++;
                }
            }
        }
        return $subjs;
    }
}
