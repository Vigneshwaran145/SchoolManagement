@extends('layouts.app')
@section('content')
    
    
    <span class="form-group">
        <label for="class" class="col-sm-2 control-label"> Class </label>
        <div class="col-sm-2" >
            <select class="form-control" id="class" onchange="filterByClassSub()">
                <option value="0">All</option>
                @foreach($resultClasses as $key=>$val)
                    @if(isset($_GET['classid']))
                        @if($_GET['classid'] == $key)
                            <option value="{{$key}}" selected>{{$val}}</option>
                        @else
                            <option value="{{$key}}">{{$val}}</option>
                        @endif
                    @else
                        <option value="{{$key}}">{{$val}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </span>
    <span class="form-group">
        <label for="subject" class="col-sm-2 control-label"> Subject </label>
        <div class="col-sm-2" >
            <select class="form-control" id="subject" onchange="filterByClassSub()">
                <option value="0">All</option>
                @foreach($subjects as $key=>$val)
                @if(isset($_GET['subID']))
                        @if($_GET['subID'] == $val->subjectID)
                            <option value="{{$val->subjectID}}" selected>{{$val->subName}}</option>
                        @else
                            <option value="{{$val->subjectID}}">{{$val->subName}}</option>
                        @endif
                    @else
                        <option value="{{$val->subjectID}}">{{$val->subName}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </span>
    <br><br>
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
                    
                    @if((isset($_GET['classid'])) && (isset($_GET['subID'])))
                        @if($_GET['classid'] == 0 && $_GET['subID'] == 0)
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
                        @else
                            @if($_GET['classid'] == 0 && $_GET['subID'] != 0)
                                <?php $flag = TRUE; ?>
                                @foreach($materials as $key=>$material)
                                    @if($material->subjectID == $_GET['subID'])
                                        <?php $flag = FALSE; ?>
                                        @if(strcasecmp($material->extension,"docx") == 0 || strcasecmp($material->extension,"pdf")==0 || strcasecmp($material->extension,"doc") == 0 || strcasecmp($material->extension, "odt") == 0)
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
                                                <td>{{$material->created_at}}</td>
                                            </tr>
                                        @endif
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
                            @elseif($_GET['subID'] == 0 && $_GET['classid'] != 0)
                                <?php $flag = TRUE; ?>
                                @for($i=0; $i < count($materials); $i++)
                                    @if($material_classes[$i]->classID == $_GET['classid'])
                                        <?php $flag = FALSE; ?>
                                        @if($materials[$i]->extension == "docx" || $materials[$i]->extension == "pdf" || $materials[$i]->extension == "doc" || $materials[$i]->extension == "odt")
                                            <tr>
                                                <td>
                                                    <a href="{{asset('storage/'.$materials[$i]->file)}}" download="{{$materials[$i]->fileName}}">{{$materials[$i]->fileName}}</a>
                                                </td>
                                                @foreach($subjects as $k=>$subject)
                                                    @if($subject->subjectID == $materials[$i]->subjectID)
                                                        <td>{{$subject->subName}}</td>   
                                                    @endif
                                                @endforeach
                                                <td>{{$materials[$i]->created_at}}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <video width="500px"controls>
                                                        <source src="{{asset('storage/'.$materials[$i]->file)}}">
                                                    </video>
                                                </td>
                                                @foreach($subjects as $k=>$subject)
                                                    @if($subject->subjectID == $materials[$i]->subjectID)
                                                        <td>{{$subject->subName}}</td>   
                                                    @endif
                                                @endforeach
                                                <td>{{$materials[$i]->created_at}}</td>
                                            </tr>
                                        @endif
                                    @endif
                                @endfor
                                @if($flag)
                                    <?php
                                        echo '<script>
                                            document.getElementById("materialTable").style.display = "none";
                                            </script>
                                            ';
                                        echo "No materials found";
                                    ?>
                                @endif
                            @else
                                <?php $flag = TRUE; ?>
                                @for($i=0; $i < count($materials); $i++)
                                    @if($material_classes[$i]->classID == $_GET['classid'] && $materials[$i]->subjectID == $_GET['subID'])
                                        <?php $flag = FALSE; ?>
                                        @if(strcasecmp($material->extension,"docx") == 0 || strcasecmp($material->extension,"pdf")==0 || strcasecmp($material->extension,"doc") == 0 || strcasecmp($material->extension, "odt") == 0)
                                            <?php $flag=FALSE; ?>
                                            <tr>
                                                <td>
                                                    <a href="{{asset('storage/'.$materials[$i]->file)}}" download="{{$materials[$i]->fileName}}">{{$materials[$i]->fileName}}</a>
                                                </td>
                                                @foreach($subjects as $k=>$subject)
                                                    @if($subject->subjectID == $materials[$i]->subjectID)
                                                        <td>{{$subject->subName}}</td>   
                                                    @endif
                                                @endforeach
                                                <td>{{$materials[$i]->created_at}}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <video width="500px"controls>
                                                        <source src="{{asset('storage/'.$materials[$i]->file)}}">
                                                    </video>
                                                </td>
                                                @foreach($subjects as $k=>$subject)
                                                    @if($subject->subjectID == $materials[$i]->subjectID)
                                                        <td>{{$subject->subName}}</td>   
                                                    @endif
                                                @endforeach
                                                <td>{{$materials[$i]->created_at}}</td>
                                            </tr>
                                        @endif
                                    @endif
                                @endfor
                                @if($flag)
                                    <?php
                                        echo '<script>
                                            document.getElementById("materialTable").style.display = "none";
                                            </script>
                                            ';
                                        echo "No materials found";
                                    ?>
                                @endif
                            @endif
                            
                        @endif
                        
                    @else
                        <?php $flag = TRUE; ?>
                        @foreach($materials as $key=>$material)
                            <?php $flag = FALSE; ?>
                            @if(strcasecmp($material->extension,"docx") == 0 || strcasecmp($material->extension,"pdf")==0 || strcasecmp($material->extension,"doc") == 0 || strcasecmp($material->extension, "odt") == 0)
                            <tr>
                                <td>
                                    <a href="/storage/{{$material->file}}" download="/storage/{{$material->file}}">{{$material->fileName}}</a>
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
                                        <video width="500px"controls >
                                            <!-- <source src="{{asset('storage'.$material->file)}}"> -->
                                            <source src="/storage/{{$material->file}}">
                                        </video>
                                    </td>
                                    @foreach($subjects as $k=>$subject)
                                        @if($subject->subjectID == $material->subjectID)
                                            <td>{{$subject->subName}}</td>   
                                        @endif
                                    @endforeach
                                    <td>{{$material->created_at}}</td>
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function filterByClassSub()
        {
            var classID = document.getElementById('class').value;
            var subID = document.getElementById('subject').value;
            window.location = '/materials?classid='+classID+'&subID='+subID;
        }
    </script>
@endsection