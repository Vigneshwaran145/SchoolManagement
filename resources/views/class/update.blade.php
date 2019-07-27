@extends('layouts.app')
@section('content')
    <?php session_start(); ?>

    <center>
        <h2>Edit Class</h2>
        <form action="/classes/{{$classID}}" method="post" class="form-horizontal">
            @csrf()
            @method("PATCH")
            <input type="hidden" name="classID" value="{{$classID}}">
            <!-- <input type="hidden" name="sStd" value="{{$sstd}}">
            <input type="hidden" name="sSub" value="{{$ssub}}">
            <input type="hidden" name="sSec" value="{{$ssec}}">
            <input type="hidden" name="sTeacher" value="{{$steacher}}"> -->


            <div class="form-group">
                <label class="control-label col-sm-5">Standard</label>
                <div class="col-sm-2">
                    <select name="standard" class="form-control">
                        @foreach($standards as $key=>$val)
                            @if($sstd == $val->standard)
                                <option value="{{$val->standardID}}" selected>{{$val->standard}}</option>
                                <?php $_SESSION['stdID'] = $val['standardID']; ?>
                            @else
                                <option value="{{$val->standardID}}">{{$val->standard}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Section</label>
                <div class="col-sm-2">
                    <select name="section" class="form-control">
                        @foreach($sections as $key=>$val)
                            @if($ssec == $val->section)
                                <option selected value="{{$val->sectionID}}">{{$val->section}}</option>
                                <?php $_SESSION['secID'] = $val['sectionID']; ?>
                            @else
                                <option value="{{$val->sectionID}}">{{$val->section}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="table">
                <tr id="frstRow">
                    <th>Subjects</th>
                    <th>Teachers</th>
                </tr>
                
                
                <tr id="row">
                    
                    <td>
                        <select id="sub" name="subject" class="form-control">
                            @foreach ($subjects as $key => $value)
                                @if($value->subName == $ssub)
                                    <option value='{{$value->subjectID}}' selected>{{$value->subName}}</option>
                                    <?php $_SESSION['subID'] = $value['subjectID']; ?>
                                @else
                                    <option value='{{$value->subjectID}}'>{{$value->subName}}</option>
                                @endif
                            @endforeach
                            
                        </select>
                    </td>
                    <td>
                        <select id="teacher" name="teacher"class="form-control">
                            
                        </select>
                    </td>
                </tr>
                
                </table>    
				
                <div class="form-group">
                    <input type="submit" class="btn btn-info" value="Edit Class">&nbsp&nbsp&nbsp
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
        </form>
    </center>
    <script>
        $(document).ready(function(){
            var subID = $("#sub").children("option:selected").val();
            $.ajax({
                    url: "{!! URL::to('/fetchTeacher') !!}",
                    method: "get",
                    data:{
                        subjectID: subID
                    },
                    success:function(result)
                    {
                        console.log(result);
                        var teacherHTML = "";
                        var teacherCount = result.length;
                        for(var j=0; j < teacherCount; j++)
                        {
                            teacherHTML += "<option value='"+result[j]['teacherID']+"'>"+result[j]['teacherName']+"</option>";
                        }
                        if(result.length == 0)
                        {
                            teacherHTML = "<option value='0' disabled>No teacher found</option>";
                        }
                        $("#teacher").html(teacherHTML);
                    },
                    error:function(data)
                    {
                        console.log("failed");
                    }
                });
            


            $("#sub").change(function(){
                var subID = $(this).children("option:selected").val();
                $.ajax({
                    url: "{!! URL::to('/fetchTeacher') !!}",
                    method: "get",
                    data:{
                        subjectID: subID
                    },
                    success:function(result)
                    {
                        console.log(result);
                        var teacherHTML = "";
                        var teacherCount = result.length;
                        for(var j=0; j < teacherCount; j++)
                        {
                            teacherHTML += "<option value='"+result[j]['teacherID']+"'>"+result[j]['teacherName']+"</option>";
                        }
                        if(result.length == 0)
                        {
                            teacherHTML = "<option value='0' disabled>No teacher found</option>";
                        }
                        $("#teacher").html(teacherHTML);
                    },
                    error:function(data)
                    {
                        console.log("failed");
                    }
                });
            });
        });
    </script>
@endsection
