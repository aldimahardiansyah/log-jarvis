@extends('layouts.master')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-danger">Project Data</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="project">Project Name</label>
                <input type="text" class="form-control" id="project" name="project">
            </div>
            <button type="submit" class="btn btn-danger col-md-12">Save</button>
        </form>
    </div>
    @endsection