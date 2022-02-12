@extends('layouts.user')
@section('content')
@php
date_default_timezone_set('Asia/Jakarta');
$hari = date("l");
$tanggal = date("Y-m-d");

$month_num = date("m");
$month_name = date("F", mktime(0, 0, 0, $month_num, 10));
@endphp

<div class="d-flex mb-4">
    <div>
        <img src="/images/undraw_profile.svg" width="65px" class="rounded-circle" alt="user photo">
    </div>
    <div class="text-light me-auto mx-2 d-flex flex-column justify-content-center">
        <h4 class="fw-300">Welcome!</h4>
        <h6 class="fw-bold">{{ Auth::user()->name }}</h6>
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="h1 text-decoration-none p-2 rounded-circle bg-dark text-light fas fa-power-off"></a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<div class="card border border-1 shadow" style="border-radius: 15px;">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col text-end">
                <small>{{ $hari }}, {{ $tanggal }}</small>
                <small class="d-block" id="waktu">00:00:00</small>
            </div>
        </div>
        <hr>
        <div>
            <h5 class="text-center">Attendance</h5>
            <div class="d-flex justify-content-evenly my-3">
                <div>
                    <small class="fw-bold d-block fw-bold">HADIR</small>
                    <small>0 hari</small>
                    <div class="undershape"></div>
                </div>
                <div class="vertical-line"></div>
                <div>
                    <small class="fw-bold d-block fw-bold">IZIN</small>
                    <small>0 hari</small>
                    <div class="undershape"></div>
                </div>
                <div class="vertical-line"></div>
                <div>
                    <small class="fw-bold d-block fw-bold">SISA CUTI</small>
                    <small>0 hari</small>
                    <div class="undershape"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mt-4">Absen Bulan {{ $month_name }}</h4>
<div class="card border border-1 shadow" style="margin-bottom: 100px; border-radius: 15px;">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col" class="fw-300">Date</th>
                        <th scope="col" class="fw-300">Day</th>
                        <th scope="col" class="fw-300">Activity</th>
                        <th scope="col" class="fw-300">Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $item)
                        <tr>
                            <td class="fw-300">{{ $item->date_in }}</td>
                            <td class="fw-300">{{ $item->day_in }}</td>
                            <td class="fw-300">{{ $item->activity }}</td>
                            <td class="fw-300">{{ $item->site_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    setInterval(showTime, 1000);

    function showTime() {
        let time = new Date();
        let hr = time.getHours();
        let min = time.getMinutes();
        let sec = time.getSeconds();
        AMPM = 'AM';

        if (hr > 12) {
            hr -= 12;
            AMPM = "PM";
        }
        if (hr == 0) {
            hr = 12;
            AMPM = "AM";
        }

        hr = hr < 10 ? "0" + hr : hr;
        min = min < 10 ? "0" + min : min;
        sec = sec < 10 ? "0" + sec : sec;

        let curentTime = hr + ":" + min + ":" + sec + " " + AMPM;

        document.getElementById('waktu').innerHTML = curentTime;

    }
    showTime();
</script>
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>
@endsection