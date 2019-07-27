@extends('layouts.app')
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mail</th>
                <th>Qualification</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Subjects</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $key => $teacher)
                <tr>
                    <td>{{$teacher["teacherName"]}}</td>
                    <td>{{$teacher['teacher_mail']}}</td>
                    <td>{{$teacher["qualification"]}}</td>
                    <td>{{$teacher["dob"]}}</td>
                    <td>{{$teacher["address"]}}</td>
                    <td>
                    @foreach($teacherSubs as $tsID => $teacherSub)
                        @foreach($subjects as $sID => $subject)
                            @if(($teacherSub['subjectID'] == $subject['subjectID']) && ($teacherSub['teacherID'] == $teacher['teacherID']))
                                {{$subject['subName']}}
                            @endif
                        @endforeach
                    @endforeach
                    </td>
                    <td>
                        <a href="/teachers/{{$teacher->teacherID}}/edit">
                            <button type="button" class="btn btn-default btn-sm">
                               <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                        </a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
@endsection