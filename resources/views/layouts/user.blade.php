<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('user/style.css') }}">

    <title>Durian Traveler - Portal Absen</title>
    <style>
        .navbar{
            background-color: #e8ffbe; 
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }
        .active{
            background-color: #f3e28d;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }
    </style>
</head>

<body>
    <nav class="p-0 navbar navbar-expand narbar-dark text-dark fixed-bottom">
        <ul class="navbar-nav nav-justified mx-auto" style="width: 600px;">
            <li class="nav-item {{ ($title=='Home')?'active':'' }}">
                <a href="/" class="nav-link fw-bold text text-dark">
                    
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 32 32" width="1.5em" height="1.5em">
                        <path d="M 16 2.59375 L 15.28125 3.28125 L 2.28125 16.28125 L 3.71875 17.71875 L 5 16.4375 L 5 28 L 14 28 L 14 18 L 18 18 L 18 28 L 27 28 L 27 16.4375 L 28.28125 17.71875 L 29.71875 16.28125 L 16.71875 3.28125 Z M 16 5.4375 L 25 14.4375 L 25 26 L 20 26 L 20 16 L 12 16 L 12 26 L 7 26 L 7 14.4375 Z"/>
                    </svg>
                    <span class="small d-block fw-300">Home</span>
                </a>
            </li>
            <li class="nav-item {{ ($title=='Input Absent')?'active':'' }}">
                <a href="{{ route('absen.index') }}" class="nav-link fw-bold text-dark">
                    <span class="far fa-edit" style="font-size:1.5em;"></span>
                    <span class="small d-block fw-300">Absent</span>
                </a>
            </li>
            <li class="nav-item {{ ($title=='History')?'active':'' }}">
                <a href="{{route('data_user.index')}}" class="nav-link fw-bold text-dark">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="30" height="30" fill="url(#pattern0)"/>
                        <defs>
                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_0_97" transform="scale(0.00195312)"/>
                        </pattern>
                        <image id="image0_0_97" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                        </defs>
                        </svg>
                        
                    <span class="small d-block fw-300">History</span>
                </a>
            </li>
            <li class="nav-item {{ ($title=='Profile')?'active':'' }}">
                <a href="{{ route('profil.index') }}" class="nav-link fw-bold text-dark">
                    <span class="far fa-user" style="font-size:1.5em;"></span>
                    <span class="small d-block fw-300">Account</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- <nav class="navbar navbar-light" style="background-color: #91bcee;"> -->
    <!-- <div class="container mx-auto"> -->
    <!-- <a class="navbar-brand" href="#"> -->
    <!-- <img src="cropped-logo-jarvis-samping.png" alt="" width="150"> -->
    <!-- </a> -->
    <!-- </div> -->
    <!-- </nav> -->

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    @stack('javascript')
    @include('sweetalert::alert')
</body>

</html>