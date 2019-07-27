@extends('layouts.app')
@section('content')
    <center>
        <h2>Upload material</h2>
        <form action="/materials"method="post" enctype="multipart/form-data" class="form-horizontal">
            @csrf()
            <br>
            <div class="form-group">
                <label class="control-label col-sm-5">Class</label>
                <div class="col-sm-3">
                    <select id="class" class="form-control" name="class">
 
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Subject</label>
                <div class="col-sm-3">
                    <select id="sub" name="subject" class="form-control">

                    </select>
                </div>
            </div>
                        
            <div class="form-group">
                <label class="control-label col-sm-5">Material</label>
                <span class="col-sm-3">
                    <input type="file" name="material">
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Upload material">&nbsp&nbsp&nbsp
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

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                url: "{!! URL::to('/fetchTeachersClass') !!}",
                method: "get",
                success: function(data){
                    clsHTML = "<option value=''>Select class</option>";
                    for(var cls in data)
                    {
                        clsHTML += "<option value='"+cls+"'>"+data[cls]+"</option>";
                    }
                    console.log(data);
                    $("#class").append(clsHTML);
                }
            });

            
            $.ajax({
                url: "{!! URL::to('/fetchSubByClass') !!}",
                method: "get",
                success: function(data)
                {
                    var subHTML = "<option value=''>Choose Subject</option>";
                    for(var sub in data)
                    {
                        subHTML += "<option value='"+data[sub]['subjectID']+"'>"+data[sub]['subName']+"</option>";
                    }
                    $("#sub").append(subHTML);
                }
            });
        
        });

    </script>
@endsection