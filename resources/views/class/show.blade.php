@extends('layouts.app')
@section('content')
<?php
    // print_r($results);
    // echo "<br>";
    // print_r($results[0]);
    // echo "<br>";
    $class = array();//_keys($results[0][0]);
    $subject = array();
    $teacher = array();
    $classID = array();
    foreach($results as $index => $val)
    {
        $class[$index] = array_keys($val[0]);
        $subject[$index] = array_keys($val[1]);
        $teacher[$index] = array_keys($val[2]);
        $classID[$index] = array_keys($val);
    }
    
?>
    @if($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Standard</th>
                <th>Section</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Edit</th>
            </tr>
        </thead>
        <?php
            foreach($results as $index => $val)
            {
                echo "<tr>";
                    echo "<td>".$class[$index][0]."</td>";
                    echo "<td>".$class[$index][1]."</td>";
                    echo "<td>".$subject[$index][0]."</td>";
                    echo "<td>".$teacher[$index][0]."</td>";
                    foreach($resClass as $clsID => $cls)
                    {
                        $c = array_keys($cls);
                        if($c[0] == $class[$index][0] && $c[1] == $class[$index][1])
                        {
                            $tmpClassID = $clsID;
                        }
                    }
                    ?>
                    <td>
                    <a href="/classes/{{$tmpClassID}}/edit?clsID={{$tmpClassID}}&std={{$class[$index][0]}}&sec={{$class[$index][1]}}&sub={{$subject[$index][0]}}&teacher={{$teacher[$index][0]}}">
								<button type="button" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-edit"></span> Edit
								</button>
                            </a>
                    </td>
                <?php
                echo "</tr>";
            }
        ?>
    </table>
@endsection