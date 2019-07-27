@extends('layouts.app')
@section('content')
<center>
    
        <h3 class="title">Edit Teacher</h3><br>
        <form action="/teachers/{{$teachers[0]['teacherID']}}" method="post" class="form-horizontal">
            @csrf()
            @method('PATCH')
            <div class="form-group">
                <label class="control-label col-sm-4">Teacher Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tName" value="{{$teachers[0]['teacherName']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Teacher Mail</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="mail" value="{{$teachers[0]['teacher_mail']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Qualification</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="qualification" value="{{$teachers[0]['qualification']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Date of Birth</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="dob" max='1999-01-01' value="{{$teachers[0]['dob']}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Address</label>
                <div class="col-sm-4">
                    <textarea class="form-control textarea" name="address">{{$teachers[0]['address']}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Subjects</label>
                <div class="col-sm-4">
                    @foreach($subjects as $subject)
                        <div class="checkbox-inline">
                        <input type="checkbox" value="{{ $subject['subjectID'] }}" name="subjects[]"
                            <?php
                                foreach($teacherSubs as $key=>$val){
                                    if($val['subjectID'] == $subject['subjectID']){
                                        echo "checked='true'";
                                    }
                                }
                            ?>
                        >{{$subject['subName']}}
                        </div>
                    
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Edit Teacher">&nbsp&nbsp&nbsp
                <input type="reset" class="btn btn-danger" value="Reset">
            </div>

        </form>

    </center>
@endsection
