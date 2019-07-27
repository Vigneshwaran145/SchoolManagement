@extends('layouts.app')
@section('content')
<!--     
    
    <span class="form-group">
        <label for="class" class="col-sm-2 control-label"> Class </label>
        <div class="col-sm-2" >
            <select class="form-control" id="class" onchange="filterByClassSub()">
                <option value="0">All</option>
                
            </select>
        </div>
    </span>
    <span class="form-group">
        <label for="subject" class="col-sm-2 control-label"> Subject </label>
        <div class="col-sm-2" >
            <select class="form-control" id="subject" onchange="filterByClassSub()">
                <option value="0">All</option>
                @foreach($subjects as $key=>$val)            
                    <option value="{{$val->subjectID}}">{{$val->subName}}</option>
                @endforeach
            </select>
        </div>
    </span> -->
    <br>
    <div class="wrapper" >
        <section class="panel panel-primary">
            <div class="panel-heading">Materials</div>
        </section>
        <div class="panel-body">
            <table id="materialTable" class="table table-bordered">
                <thead>
                    <th>File Name</th>
                    <th>Subject</th>
                    <th>Uploaded Date</th>
                </thead>
                <tbody>
                    <?php $flag = TRUE; ?>
                    @foreach($materials as $key=>$material)   
                        @if(strcasecmp($material->extension,"docx") == 0 || strcasecmp($material->extension,"pdf")==0 || strcasecmp($material->extension,"doc") == 0 || strcasecmp($material->extension, "odt") == 0)
                        <?php $flag = FALSE; ?>
                        <tr>
                            <td>
                                <a href="{{asset('storage/'.$material->file)}}" download="{{$material->fileName}}">{{$material->fileName}}</a>
                            </td>
                            @foreach($subjects as $k=>$subject)
                            @if($subject->subjectID == $material->subjectID)
                                <td>{{$subject->subName}}</td>   
                            @endif
                            @endforeach
                            <td>{{$material->created_at}}</td>
                        </tr>
                        
                        @else
                            <tr>
                                <td>
                                    <video width="500px"controls>
                                        <source src="{{asset('storage/'.$material->file)}}">
                                    </video>
                                </td>
                                @foreach($subjects as $k=>$subject)
                                    @if($subject->subjectID == $material->subjectID)
                                        <td>{{$subject->subName}}</td>   
                                    @endif
                                @endforeach
                                <td>{{$material->created_at}}
                            </tr>
                        @endif
                    @endforeach
                    @if($flag)
                            <?php
                                echo '<script>
                                    document.getElementById("materialTable").style.display = "none";
                                    </script>
                                    ';
                                echo "No materials found";
                            ?>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
