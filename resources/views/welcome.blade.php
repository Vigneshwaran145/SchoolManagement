@extends('layouts.app')
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    Welcome to our page
@endsection