@extends("layouts.app")
@section("content")
<center>
        <h3 class="title">Add Student</h3><br>
        <form action="/students" method="post" class="form-horizontal">
            @csrf()
            <div class="form-group">
                <label class="control-label col-sm-5">Student Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="studentName"  value="{{old('studentName')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Student Mail</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="mail" value="{{old('mail')}}">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-5">Class</label>
                <div class="col-sm-3">
                    <select class="form-control" name="class">
                        @foreach($resultClasses as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Date of Birth</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" name="dob" max="2000-01-01"  value="{{old('dob')}}">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Student">&nbsp&nbsp&nbsp
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