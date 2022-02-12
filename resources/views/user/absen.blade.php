@extends('layouts.user')
@section('content')
@php
date_default_timezone_set('Asia/Jakarta');
$hari = date("l");
$tanggal = date("Y-m-d");

$month_num = date("m");
$month_name = date("F", mktime(0, 0, 0, $month_num, 10));
@endphp
<style>
    .form-select {
        border: 0;
    }

    .form-control {
        border: 0;
    }
</style>
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

<div class="card border border-1 shadow mb-5" style="border-radius: 15px;">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col text-end">
                <small>{{ $hari }}, {{ $tanggal }}</small>
                <small class="d-block" id="waktu">00:00:00</small>
            </div>
        </div>
        <hr>
        <div>
            <form action="{{route('absen.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Nama</label>
                        <input type="text" class="form-control border bg-light text-muted" style="border-radius:18px;" id="formGroupExampleInput"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="d-grid gap-2 col-12 mx-auto">
    @if ($keterangan and ($keterangan['activity'] === null))
        <button class="btn p-0 my-2" type="submit" disabled>
            <div class="card d-flex flex-row align-items-center shadow">
                <span class="fa fa-sign-in-alt fs-1 mx-3"></span>
                <div class="card-body text-start" style="line-height: 5px;">
                    <h6>Time In</h6>
                    <small class="fw-300">Time in is blablabla</small>
                </div>
            </div>
        </button>

        <button class="btn p-0 my-2" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <div class="card d-flex flex-row align-items-center shadow">
                <span class="fa fa-sign-out-alt fs-1 mx-3"></span>
                <div class="card-body text-start" style="line-height: 5px;">
                    <h6>Time Out</h6>
                    <small class="fw-300">Time in is blablabla</small>
                </div>
            </div>
        </button>

        <button class="btn p-0 my-2" type="button" disabled>
            <div class="card d-flex flex-row align-items-center shadow">
                <span class="fa fa-ban fs-1 mx-3"></span>
                <div class="card-body text-start" style="line-height: 5px;">
                    <h6>Izin</h6>
                    <small class="fw-300">Time in is blablabla</small>
                </div>
            </div>
        </button>
    @else
            <button class="btn p-0 my-2" type="submit">
                <div class="card d-flex flex-row align-items-center shadow">
                    <span class="fa fa-sign-in-alt fs-1 mx-3"></span>
                    <div class="card-body text-start" style="line-height: 5px;">
                        <h6>Time In</h6>
                        <small class="fw-300">Time in is blablabla</small>
                    </div>
                </div>
            </button>
    
            <button class="btn p-0 my-2" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" disabled>
                <div class="card d-flex flex-row align-items-center shadow">
                    <span class="fa fa-sign-out-alt fs-1 mx-3"></span>
                    <div class="card-body text-start" style="line-height: 5px;">
                        <h6>Time Out</h6>
                        <small class="fw-300">Time in is blablabla</small>
                    </div>
                </div>
            </button>
    
            <button class="btn p-0 my-2" type="button" onclick="this.href='/sakit/'+ document.getElementById('project').value">
                <div class="card d-flex flex-row align-items-center shadow">
                    <span class="fa fa-ban fs-1 mx-3"></span>
                    <div class="card-body text-start" style="line-height: 5px;">
                        <h6>Izin</h6>
                        <small class="fw-300">Time in is blablabla</small>
                    </div>
                </div>
            </button>
    @endif
</div>
        </form>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Absen Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($keterangan !== null)
            <form action="{{route('absen.update', ['absen' => $keterangan->id])}}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama">Name</label>
                                    <input required type="text" class="form-control border-bottom" id="nama"
                                        value="{{Auth::user()->name}}" readonly>
                                    <input required type="text" value="{{Auth::user()->id}}" name="name" readonly
                                        hidden>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tanggal">Date In</label>
                                    @if ($keterangan == null)
                                    <input required type="date" class="tanggal form-control border-bottom"
                                        id="tanggal_in" name="date_in" readonly>
                                    @else
                                    <input required type="date" value="{{$keterangan->date_in}}"
                                        class="tanggal form-control border-bottom" id="tanggal_in" name="date_in"
                                        readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hari">Day In</label>
                                    <input required type="text" class="form-control border-bottom" id="hari_in"
                                        name="day_in" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="time-in">Time In</label>
                                    @if ($keterangan == null)
                                    <input required type="time" class="form-control border-bottom" id="time-in"
                                        name="time_in" readonly>
                                    @else
                                    <input required type="time" value="{{$keterangan->time_in}}"
                                        class="form-control border-bottom" id="time-in" name="time_in" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tanggal">Date Out</label>
                                    <input required type="date" class="tanggal form-control border-bottom"
                                        id="tanggal_out" name="date_out" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hari">Day Out</label>
                                    <input required type="text" class="form-control border-bottom" id="hari_out"
                                        name="day_out" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="time-out">Time Out</label>
                                    <input required type="time" class="form-control border-bottom" id="time_out"
                                        name="time_out" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="total">Total Hours</label>
                                    <input required type="text" class="form-control border-bottom" id="total"
                                        name="total_hours" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="site">Site Name</label>
                                    <input required type="text" class="form-control border-bottom border-2" id="site"
                                        name="site_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="activity">Activity</label>
                                    <textarea required type="text" class="form-control border border-2" id="activity"
                                        name="activity"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success text-white">Absen Keluar</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

<script src="https://momentjs.com/downloads/moment.js"></script>
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

    Date.prototype.toJSONLocal = (function () {
        function addZ(n) {
            return (n < 10 ? '0' : '') + n;
        }
        return function () {
            return this.getFullYear() + '-' +
                addZ(this.getMonth() + 1) + '-' +
                addZ(this.getDate());
        };
    }())

    function ubahTanggal() {
        let mydate = new Date;
        // let jakarta = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
        // let mydate = new Date(jakarta);
        console.log(mydate);
        // let tanggalJakarta = mydate.toString();
        // console.log(tanggalJakarta)
        let dateNow = document.querySelector('#tanggal_in').value;
        // document.querySelector('#tanggal_out').value = weekDayName;
        let date = mydate.toJSONLocal().slice(0, 10);
        console.log(date);
        let nDate = date.slice(0, 4) + '-' +
            date.slice(5, 7) + '-' +
            date.slice(8, 10);
        console.log(nDate);
        let weekDayName = moment(dateNow).format('dddd');
        let minutes = mydate.getMinutes();
        minutes = minutes > 9 ? minutes : '0' + minutes;
        let hours = mydate.getHours();
        hours = hours > 9 ? hours : '0' + hours;
        let timeNow = hours + ":" + minutes;
        document.querySelector('#time_out').value = timeNow;
        console.log(timeNow);
        document.querySelector('#tanggal_out').value = nDate;
        document.querySelector('#hari_in').value = weekDayName;
        let weekDayNameOut = moment(mydate).format('dddd');
        document.querySelector('#hari_out').value = weekDayNameOut;
    }

    ubahTanggal();

    function totalJam() {
        let mydate = new Date;
        let dateIn = document.querySelector('#tanggal_in').value;
        let dateOut = document.querySelector('#tanggal_out').value;
        console.log(dateIn);
        console.log(dateOut);
        var date = mydate.toJSON().slice(0, 10);
        var nDate = date.slice(0, 4) + '-' +
            date.slice(5, 7) + '-' +
            date.slice(8, 10);
        let jamAwal = document.querySelector("#time-in").value;
        let jamAkhir = document.querySelector("#time_out").value;
        // let tanggal = document.querySelector("#tanggal").value;
        // console.log(nDate == tanggal);
        // console.log(tanggal);

        if (dateIn != dateOut) {
            let batas1 = "23:59";
            let batas2 = "00:00";
            let hours1 = batas1.split(':')[0] - jamAwal.split(':')[0];
            let minutes1 = batas1.split(':')[1] - jamAwal.split(':')[1];

            let hours2 = jamAkhir.split(':')[0] - batas2.split(':')[0];
            let minutes2 = jamAkhir.split(':')[1] - batas2.split(':')[1];

            let totalHours = hours1 + hours2;
            let totalMinutes = minutes1 + minutes2;

            totalMinutes = totalMinutes.toString().length < 2 ? '0' + totalMinutes : totalMinutes;

            if (totalMinutes > 59) {
                totalHours++;
                totalMinutes = totalMinutes - 60;
            }

            totalHours = totalHours.toString().length < 2 ? '0' + totalHours : totalHours;

            document.querySelector('#total').value = totalHours + ':' + totalMinutes;

        } else {

            let hours = jamAkhir.split(':')[0] - jamAwal.split(':')[0];
            let minutes = jamAkhir.split(':')[1] - jamAwal.split(':')[1];

            minutes = minutes.toString().length < 2 ? '0' + minutes : minutes;
            if (minutes < 0) {
                hours--;
                minutes = 60 + minutes;
            }
            hours = hours.toString().length < 2 ? '0' + hours : hours;
            document.querySelector('#total').value = hours + ':' + minutes;
        }
    }

    totalJam();
</script>
@endsection