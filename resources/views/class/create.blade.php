@extends('layouts.app')
@section('content')
    <center>
        <h2>Add Class</h2>
        <form action="/classes" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5">Standard</label>
                <div class="col-sm-2">
                    <select id="standard" name="standard" class="form-control">
                        <option value=''>Select Class</option>
                        @foreach($standards as $key=>$val)
                            <option value="{{$val->standardID}}">{{$val->standard}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Section</label>
                <div class="col-sm-2">
                    <select name="section" id="section" class="form-control">
                        <option value="">--NONE--</option>
                        
                    </select>
                </div>
            </div>
            <table id="table">
                <tr id="frstRow">
                    <!-- <th>Select</th> -->
                    <th>Subjects</th>
                    <th>Teachers</th>
                    <th></th>
                </tr>
                <tr id="row">
                    <!-- <td><input type="checkbox" name="sel"></td> -->
                    <td>
                        <select id="sub" name="subjects[]" class="form-control subjects1">
                            
                        </select>
                    </td>
                    <td>
                        <select id="teacher" name="teachers[]"class="form-control teachers1">
                            <option>--None--</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">
                            <span class="glyphicon glyphicon-plus" ></span>Add
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeThisRow(this)">
                            <span class="glyphicon glyphicon-trash"></span>Remove
                        </button>
                    </td>
                </tr>
                
                </table>    
				
                <br><br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Add Class">
                </div>
                {{ csrf_field() }}
        </form>
    </center>
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <ul>
                    <li>{{ $error }}</li>
                </ul>
            @endforeach
        </div>
    @endif

    <script type="text/javascript">
        var subjects = [];
        var rowLength = 1;
		$(document).ready(function(){
            
            $.ajax({
                url: "{!! URL::to('/fetchSubject') !!}",
                method: "get",
                success:function(result)
                {
                    var subHTML = "<option value=''>Select Subject</option>";
                    var subLength = result.length;
                    for(var i=0; i<subLength; i++)
                    {
                        subHTML += "<option value='"+result[i]['subjectID']+"'>"+result[i]['subName']+"</option>";
                    }
                    $(".subjects1").html(subHTML);
                }
            });

            $("#standard").change(function(){
                var stdID = $("#standard").children("option:selected").val();
                console.log(stdID);
                $.ajax({
                    url: "{!! URL::to('fetchSection') !!}",
                    type: "get",
                    data:{
                        stdID: stdID
                    },
                    success:function(data){
                        console.log(data);
                        sectionHTML = "<option value=''>Choose Section</option>";
                        $.each(data, function(sectionID, section)
                        {
                            sectionHTML += "<option value='"+sectionID+"'>"+section+"</option>";
                        });
                        $("#section").html(sectionHTML);
                    }
                });
            });

            $("#addRow").click(function(){
				if(rowLength == 1)
                {
                    subjects.push($("select.subjects1").children("option:selected").val());
                }
                else
                {
                    for(var i = 1; i <= rowLength; i++)
                    {
                        var s = $("select.subjects"+i).children("option:selected").val();
                        subjects.push(s);
                    }
                }
                rowLength += 1;
                if(rowLength <= 7){
                    $.ajax({
                        url: "{!! URL::to('/fetchSubject') !!}",
                        method: "get",
                        data:{
                            rowLength: rowLength,
                            subjects: subjects
                        },
                        success:function(result){
                            var subHTML = "<option value=''>Select Subject</option>";
                            var subLength = result.length;
                            for(var i=0; i<subLength; i++)
                            {
                                subHTML += "<option value='"+result[i]['subjectID']+"'>"+result[i]['subName']+"</option>";
                            }
                            var insertRow = "<tr><td><select name='subjects[]' onchange='getTeacherBySub(this)' class='form-control subjects"+rowLength+"'>"+subHTML+"</select></td><td><select name='teachers[]' class='form-control teachers"+rowLength+"'><option value=''>--None--</option></select></td><td><button onclick='addTRow()' type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span>Add</button><button type='button' class='btn btn-danger btn-sm' onclick='removeThisRow(this)'><span class='glyphicon glyphicon-trash'></span>Remove</button></td></tr>";
                            $("table tbody").append(insertRow);
                        }
                    });
                }
                else
                {
                    alert("You have reached the limit");
                }
			});
			
        
            $("select.subjects1").change(function(){
                var subID = $(this).children("option:selected").val();
                $.ajax({
                    url: "{!! URL::to('/fetchTeacher') !!}",
                    method: "get",
                    data:{
                        subjectID: subID
                    },
                    success:function(result)
                    {
                        var teacherHTML = "<option value=''>Choose teacher</option>";
                        var teacherCount = result.length;
                        for(var j=0; j < teacherCount; j++)
                        {
                            teacherHTML += "<option value='"+result[j]['teacherID']+"'>"+result[j]['teacherName']+"</option>";
                        }
                        if(result.length == 0)
                        {
                            teacherHTML = "<option value='0' disabled>No teacher found</option>";
                        }
                        $(".teachers1").html(teacherHTML);
                    },
                    error:function(data)
                    {
                        console.log("failed");
                    }
                });
            });

		});
        
        function getTeacherBySub(obj)
        {
            var subID = $(obj).children("option:selected").val();
            $.ajax({
                url: "{!! URL::to('/fetchTeacher') !!}",
                method: "get",
                data:{
                    subjectID: subID
                },
                success:function(result)
                {
                    console.log(result);
                    var teacherHTML = "<select name='teachers[]' class='form-control'><option value=''>Choose teacher</option>";
                    var teacherCount = result.length;
                    for(var j=0; j < teacherCount; j++)
                    {
                        teacherHTML += "<option value='"+result[j]['teacherID']+"'>"+result[j]['teacherName']+"</option>";
                    }
                    if(result.length == 0)
                    {
                        teacherHTML += "<option value='' disabled>No teacher found</option>";
                    }
                    teacherHTML += "</select>";
                    $(obj).parent().next().html(teacherHTML);
                },
                error:function(data)
                {
                    console.log("failed");
                }
            });
        }

        function removeThisRow(obj)
        {
            console.log(rowLength);
            if(!(rowLength == 1))
            {
                $(obj).parent().parent().remove();
                rowLength -= 1;
                console.log(rowLength);
            }
        }
        
        function addTRow()
        {
            if(rowLength == 1)
            {
                subjects.push($("select.subjects1").children("option:selected").val());
            }
            else
            {
                for(var i = 1; i <= rowLength; i++)
                {
                    var s = $("select.subjects"+i).children("option:selected").val();
                    subjects.push(s);
                }
            }
            rowLength += 1;
            if(rowLength <= 7){
                $.ajax({
                    url: "{!! URL::to('/fetchSubject') !!}",
                    method: "get",
                    data:{
                        rowLength: rowLength,
                        subjects: subjects
                    },
                    success:function(result){
                        var subHTML = "<option value=''>Select Subject</option>";
                        var subLength = result.length;
                        for(var i=0; i<subLength; i++)
                        {
                            subHTML += "<option value='"+result[i]['subjectID']+"'>"+result[i]['subName']+"</option>";
                        }
                        var insertRow = "<tr><td><select name='subjects[]' onchange='getTeacherBySub(this)' class='form-control subjects"+rowLength+"'>"+subHTML+"</select></td><td><select name='teachers[]' class='form-control teachers"+rowLength+"'><option value=''>--None--</option></select></td><td><button function='addRow()' type='button' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span>Add</button><button type='button' class='btn btn-danger btn-sm' onclick='removeThisRow(this)'><span class='glyphicon glyphicon-trash'></span>Remove</button></td></tr>";
                        $("table tbody").append(insertRow);
                    }
                });
            }
            else
            {
                alert("You have reached the limit");
            }
        }

	</script>
@endsection
