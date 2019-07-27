@extends('layouts.app')
@section('content')
    <center>
        <h3 class="title">Add Teacher</h3><br>
        <form action="/teachers" method="post" class="form-horizontal">
            @csrf()
            <div class="form-group">
                <label class="control-label col-sm-4">Teacher Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="teacherName" value="{{old('teacherName')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Teacher Mail</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="mail" value="{{old('mail')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Qualification</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="qualification" value="{{old('qualification')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Date of Birth</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="dob" max='1999-01-01' value="{{old('dob')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Address</label>
                <div class="col-sm-4">
                    <textarea class="form-control textarea" name="address" value="{{old('address')}}"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Subjects</label>
                <div class="col-sm-4">
                    @foreach($subjects as $subject)
                    <div class="checkbox-inline">
                        @if(old('subjects') == $subject['subjectID'])
                            <input checked="true" type="checkbox" value="{{ $subject['subjectID'] }}" name="subjects[]" >{{$subject['subName']}}
                        @else
                            <input type="checkbox" value="{{ $subject['subjectID'] }}" name="subjects[]" >{{$subject['subName']}}
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Teacher">&nbsp&nbsp&nbsp
                <input type="reset" class="btn btn-danger" value="Reset">
            </div>
        </form>

    </center>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
