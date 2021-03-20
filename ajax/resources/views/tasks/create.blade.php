@extends('layouts.main')

@section('content')

<h1>Create Task</h1>
<form action="{{route('tasks.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Description</label>
        <br>
        <input type="text" class="form-control" name="description" id="description" aria-describedby="helpId" placeholder="">
        <br>
        <button type="submit" class="btn btn-primary" >Create</button>
    </div>
</form>   
@endsection