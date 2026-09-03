<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Check In Berhasil | DC Visitor</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>

        body{

            font-family:'Poppins',sans-serif;

            background:#f5f7fb;

        }

        .success-card{

            max-width:650px;

            border:none;

            border-radius:20px;

        }

        .success-icon{

            width:110px;

            height:110px;

            background:#198754;

            color:white;

            border-radius:50%;

            display:flex;

            justify-content:center;

            align-items:center;

            margin:auto;

            font-size:55px;

        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow success-card">

                <div class="card-body text-center p-5">

                    <div class="success-icon mb-4">

                        <i class="bi bi-check-lg"></i>

                    </div>

                    <h2 class="fw-bold text-success">

                        Check In Berhasil

                    </h2>

                    <p class="text-muted mt-3">

                        Terima kasih.

                        Data visitor berhasil disimpan ke sistem Data Center.

                    </p>

                    <hr>

                    <div class="row text-start">

                        <div class="col-6 mb-3">

                            <small class="text-muted">

                                Status

                            </small>

                            <h6 class="mb-0">

                                <span class="badge bg-success">

                                    Berhasil

                                </span>

                            </h6>

                        </div>

                        <div class="col-6 mb-3">

                            <small class="text-muted">

                                Waktu Check In

                            </small>

                            <h6 class="mb-0">

                                {{ now()->format('d M Y H:i') }}

                            </h6>

                        </div>

                    </div>

                    <div class="d-grid mt-4">

                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">

                            <i class="bi bi-house-door-fill me-2"></i>

                            Kembali ke Home

                        </a>

                    </div>

                    <p class="text-muted mt-4 mb-0">

                        Halaman akan kembali otomatis dalam

                        <span id="timer" class="fw-bold text-primary">

                            5

                        </span>

                        detik.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let time = 5;

const timer = document.getElementById("timer");

const countdown = setInterval(function(){

    time--;

    timer.innerHTML = time;

    if(time <= 0){

        clearInterval(countdown);

        window.location.href = "{{ route('home') }}";

    }

},1000);

</script>

</body>
</html>