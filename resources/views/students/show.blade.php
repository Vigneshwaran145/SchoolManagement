@extends('layouts.app')
@section('content')
	@if($errors->any())
		<div class="alert alert-danger">
			{{$errors->first()}}
		</div>
	@endif

	<label style="text-align:right;" class="control-label col-sm-5">Standard</label>
    <span class="col-sm-2">
		<select name="class" class="form-control" onchange="filterByClass(this)">	
			<?php
				if(isset($_GET['cid']))
				{
					echo '<option value="0">All</option>';
					foreach($resultClasses as $k => $class)
					{
						if($_GET['cid'] == $k)
						{
							echo "<option selected value='$k'>$class</option>";
						}
						else
						{
							echo "<option value='$k'>$class</option>";
						}
					}
				}
				else
				{
					echo '<option value="0">All</option>';
					foreach($resultClasses as $k => $class)
					{
						echo "<option value='$k'>$class</option>";
					}
				}
			?>
		</select><br><br>
	</span>
	
		<?php
			if(!isset($_GET['cid']))
			{
		?>
			<table id="table" class="table table-hover">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Student Mail</th>
						<th>Student Code</th>
						<th>Date of Birth</th>
						<th>Class</th>
						<th>Assign Materials</th>
						<th>Edit</th>
					</tr>
				</thead>
			@foreach($students as $key=>$student)
				
				<tr>
					<td>{{$student->studentName}}</td>
					<td>{{$student->stud_mail}}</td>
					<td>{{$student->studentCode}}</td>
					<td>{{$student->dob}}</td>
					<?php
						foreach($resultClasses as $k=>$class){
							if($student->classID == $k){
								echo "<td>".$class."</td>";
							}
						}
					?>
					<td><button class="btn btn-default btn-sm" data-target="#assignMaterialModel" data-toggle="modal" data-id="{{$student->studentID}}">Assign</button></td>
					<td>
                        <a href="/students/{{$student->studentID}}/edit">
                            <button type="button" class="btn btn-default btn-sm">
                               <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                        </a>
                    </td>
				</tr>	
			@endforeach
		</tbody>	
		<?php 
			}
			else
			{
				if($_GET['cid'] == 0)
				{
		?>
			<table id="table" class="table table-hover">
			<thead>
				<tr>
					<th>Student Name</th>
					<th>Student Mail</th>
					<th>Student Code</th>
					<th>Date of Birth</th>
					<th>Class</th>
					<th>Assign Materials</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
			@foreach($students as $key=>$student)
				<tr>
					<td>{{$student->studentName}}</td>
					<td>{{$student->stud_mail}}</td>
					<td>{{$student->studentCode}}</td>
					<td>{{$student->dob}}</td>
					<?php
						foreach($resultClasses as $k=>$class){
							if($student->classID == $k){
								echo "<td>".$class."</td>";
							}
						}
					?>
					<td><button class="btn btn-default btn-sm" data-target="#assignMaterialModel" data-toggle="modal" data-id="{{$student->studentID}}">Assign</button></td>
					<td>
                        <a href="/students/{{$student->studentID}}/edit">
                            <button type="button" class="btn btn-default btn-sm">
                               <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                        </a>
                    </td>
				</tr>	
			@endforeach
		</tbody>	
		<?php
			}
			$flag = TRUE;	
		?>
		
			@foreach($students as $key=>$student)
			@if($student->classID == $_GET['cid'] || $_GET['cid'] == 0)
			<?php $flag=FALSE; ?>
			@endif
			@endforeach
			@if($flag == FALSE)
				@if(!$_GET['cid'] == 0)
				<table id="table" class="table table-hover">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Student Mail</th>
						<th>Student Code</th>
						<th>Date of Birth</th>
						<th>Class</th>
						<th>Assign Materials</th>
						<th>Edit</th>
					</tr>
				</thead>
				@endif
				@foreach($students as $key=>$student)
					@if($student->classID == $_GET['cid'])
					<tbody>
					<tr>
						<td>{{$student->studentName}}</td>
						<td>{{$student->stud_mail}}</td>
						<td>{{$student->studentCode}}</td>
						<td>{{$student->dob}}</td>
						<?php
							foreach($resultClasses as $k=>$class){
								if($student->classID == $k){
									echo "<td>".$class."</td>";
								}
							}
						?>
						<td><button class="btn btn-default btn-sm" data-target="#assignMaterialModel" data-toggle="modal" data-id="{{$student->studentID}}">Assign</button></td>
						<td>
							<a href="/students/{{$student->studentID}}/edit">
								<button type="button" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-edit"></span> Edit
								</button>
							</a>
						</td>
					</tr>	
					@endif
					
				@endforeach
				</tbody>
					</table>
			@else
				<br>
				<div class="col-sm-7">No students found</div>
			@endif
			
		<?php
			}
		?>
	</table>

	<div class="modal fade" id="assignMaterialModel" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4 class="moadl-title">Assign material</h4>
				</div>
				<div class="modal-body">
					<form action="/materialClass" method="post" id="submit_form">	
						@csrf()
						<div class="form-group">
							<label for="subject">Subject</label>
							<select id="subjects" name="subjectID" class="form-control">
								
							</select>
						</div>
						<div class="form-group">
							<label for="material">Material</label>
							<select id="materials" class="form-control" name="materialID">
								<option value=''>No material found</option>
							</select>
						</div>
						<div id="studentID">

						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="submit" onclick="form_submit()" class="btn btn-primary" value="Assign"></button>
					<button class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('[data-toggle="modal"]').click(function(){
				var studID = $(this).data("id");
				$("#studentID").html("<input name='studID' type='hidden' value='"+studID+"'>");
				$.ajax({
					url: "{!! URL::to('/fetchSubForAssigning') !!}",
					type: "get",
					data: {
						studID :  studID
					},
					success:function(data)
					{
						var subHTML = "<option value=''>Choose Subject</option>";
						for(var i=0; i < data.length; i++)
						{
							subHTML += "<option value='"+data[i]['subjectID']+"'>"+data[i]['subName']+"</option>";
						}
						if(data.length == 0)
						{
							subHTML = "<option value=''>No materials uploaded by you</option>";
						}
						$("#subjects").html(subHTML);
					}
				});
			})
			$("#subjects").change(function(){
				var subID = $("#subjects").children("option:selected").val();
				
				$.ajax({
					url: "{!! URL::to('/fetchMaterials') !!}",
					type: "get",
					data:{
						subID: subID
					},
					success:function(data){
						var materialLength = data.length;
						var materialsHTML = "";
						for(var i=0;i<materialLength; i++)
						{
							materialsHTML += "<option value='"+data[i]['materialID']+"'>"+data[i]['fileName']+"</option>";
						}
						if(materialLength != 0)
						{
							$("#materials").html(materialsHTML);
						}
					}

				});
			});
			$(".modal").on("hidden.bs.modal", function(){
				$("#materials").html("<option value=''>No material found</option>");
			});

		});
		function filterByClass(object){
			window.location = 'students?cid='+object.value;
		}
		function form_submit() {
			$("#submit_form").submit();
		}
	</script>
@endsection
