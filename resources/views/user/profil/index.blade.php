@extends('layouts.user')

@section('content')

<style>
    .form-control {
        border: 0;
    }
</style>
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        @if (!empty($datas->photo))
        <img src="{{ asset('images/'. $datas->photo ) }}" class="rounded-circle mx-auto d-block"
            alt="foto profil" style="width: 200px">
        @else
        <img src="{{ asset('images/undraw_profile.svg') }}" class="rounded-circle mx-auto d-block" alt=""
            style="width: 200px">
        @endif
        <div class="my-4" style="line-height: 2px;">
            <h5>{{ Auth::User()->name }}</h5>
            <span class="fw-300">Manager</span>
        </div>
    </div>
</div>

<div class="card border border-1 shadow" style="margin-bottom:100px;">
    <div class="card-body">
        <form method="POST" action="{{route('profil.update', ['profil' => $datas->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mt-3">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control border border-dark" style="border-radius: 18px;" value="{{ $datas->name }}" name="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control border border-dark" style="border-radius: 18px;" value="{{ $datas->email }}" name="email">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Password</label>
                    <input type="password" class="form-control border border-dark" style="border-radius: 18px;" id="formGroupExampleInput2"
                        placeholder="Password" name="password">
                </div>
                <div class="mb-3">
                    <label for="division" class="form-label">Division</label>
                    <select class="form-control border border-dark" style="border-radius: 18px;" name="division" id="division">
                        <option value="">- Choose Division -</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <button type="submit" class="d-flex align-items-center btn text-decoration-none px-2 py-1 text-light fw-300 mx-2" style="border-radius: 16px; background-color: #6e851b;">
                        <span class="mx-1 fas fa-edit"> </span> Edit Profile
                    </button>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn d-flex align-items-center btn text-decoration-none px-2 py-1 text-light fw-300" style="border-radius: 16px; background-color: #6e851b;">
                        <span class="mx-1 fas fa-power-off"> </span> Log Out
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection