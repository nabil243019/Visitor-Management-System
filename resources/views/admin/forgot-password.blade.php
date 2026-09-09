<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Lupa Password | ASNET Visitor</title>


    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <!-- Global CSS -->

    <link rel="stylesheet"
          href="{{ asset('assets/css/global.css') }}">


    <!-- Login CSS (dipakai ulang, style-nya sama) -->

    <link rel="stylesheet"
          href="{{ asset('assets/css/admin/login.css') }}">


</head>


<body>


<section class="login-page">


    <div class="container">


        <div class="row justify-content-center align-items-center min-vh-100">


            <div class="col-lg-5 col-md-7">


                <div class="login-card">



                    <!-- Logo -->


                    <div class="login-logo">


                        <i class="bi bi-key-fill"></i>


                    </div>




                    <!-- Heading -->


                    <div class="text-center mb-4">


                        <h2>

                            Lupa Password

                        </h2>


                        <p>

                            Masukkan email admin kamu,
                            link reset akan dikirim ke email tersebut.

                        </p>


                    </div>





                    <!-- Success Message -->


                    @if(session('success'))

                    <div class="alert alert-success">


                        <i class="bi bi-check-circle-fill"></i>


                        {{ session('success') }}


                    </div>


                    @endif




                    <!-- Error Message -->


                    @if($errors->any())

                    <div class="alert alert-danger">


                        <i class="bi bi-exclamation-circle-fill"></i>


                        {{ $errors->first() }}


                    </div>


                    @endif






                    <!-- Forgot Password Form -->


                    <form
                        action="{{ route('password.email') }}"
                        method="POST">

                        @csrf

                        <!-- Email -->


                        <div class="mb-4">


                            <label
                                class="form-label">


                                Email


                            </label>



                            <input

                                type="email"

                                name="email"

                                class="form-control"

                                placeholder="Masukkan email"

                                value="{{ old('email') }}"

                                required

                                autofocus>


                        </div>







                        <!-- Submit Button -->


                        <div class="d-grid mb-4">



                            <button

                                type="submit"

                                class="btn btn-primary btn-lg">


                                <i class="bi bi-send-fill"></i>


                                Kirim Link Reset



                            </button>



                        </div>


                        <div class="text-center">

                            <a href="{{ route('login') }}">

                                <i class="bi bi-arrow-left"></i>
                                Kembali ke Login

                            </a>

                        </div>



                    </form>








                    <!-- Footer -->


                    <div class="login-footer text-center">


                        <small>


                            © 2026 ASNET Visitor


                            <br>


                            Visitor Management System



                        </small>


                    </div>




                </div>


            </div>


        </div>


    </div>


</section>


<!-- Bootstrap JS -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
