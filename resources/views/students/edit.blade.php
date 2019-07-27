@extends('layouts.app')
@section('content')
    <center>
    <h3 class="title">Edit Student</h3><br>
        <form action="/students/{{$student->studentID}}" method="post" class="form-horizontal">
            @csrf()
            @method('PATCH')
            <div class="form-group">
                <label class="control-label col-sm-5">Student Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="sName" value="{{$student->studentName}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Student Mail</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" name="mail" value="{{$student->stud_mail}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Student Name</label>
                <div class="col-sm-3">
                    <select class="form-control" name="class">
                        @foreach($resultClasses as $key=>$value)
                            @if($student->classID == $key)
                                <option selected value="{{$key}}">{{$value}}</option>
                            @else
                                <option value="{{$key}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Date of Birth</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="dob" max="2000-01-01" value="{{$student->dob}}">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Edit Student">&nbsp&nbsp&nbsp
                <input type="reset" class="btn btn-danger" value="Reset">
            </div>

        
@endsection