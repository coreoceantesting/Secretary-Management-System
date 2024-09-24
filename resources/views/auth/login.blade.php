<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-bs-theme="dark" data-body-image="img-1" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}">
    <script src="{{ asset('admin/js/layout.js') }}"></script>
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="auth-page-wrapper auth-bg-cover d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <img src="{{ asset('admin/images/secretarymanagementsystem.jpg') }}" alt="" width="100%" height="100%">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100 d-none">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="{{ asset('admin/images/logo-light.png') }}" alt="" style="width: 250px">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        @foreach ($quotes as $quote)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                <p class="fs-15 fst-italic">{!! $quote !!}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div class="text-center">
                                            <img  src="{{ asset('admin/images/login-logo.png') }}" height="50%" width="50%" alt="">
                                            <h5 class="text-white text-center pt-3">लॉगिन मध्ये आपले स्वागत आहे</h5>

                                        </div>

                                        <div class="mt-4">
                                            <form id="loginForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username (वापरकर्तानाव)</label>
                                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password (पासवर्ड)</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password" >
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember_me">
                                                    <label class="form-check-label" for="remember_me">Remember me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100" type="submit" id="loginForm_submit">Sign In</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Panvel. Crafted with <i class="mdi mdi-heart text-danger"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    {{-- <script src="{{ asset('admin/js/plugins.js') }}"></script> --}}
    <script src="{{ asset('admin/js/pages/password-addon.init.js') }}"></script>
</body>

<script>
    $("#loginForm").submit(function(e) {
        e.preventDefault();
        $("#loginForm_submit").prop('disabled', true);
        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('signin') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data) {
                if (!data.error && !data.error2) {
                        window.location.href = '{{ route('dashboard') }}';
                } else {
                    if (data.error2) {
                        swal("Error!", data.error2, "error");
                        $("#loginForm_submit").prop('disabled', false);
                    } else {
                        $("#loginForm_submit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(data.error);
                    }
                }
            },
            error: function(error) {
                $("#loginForm_submit").prop('disabled', false);
                swal("Error occured!", "Something went wrong please try again", "error");
            },
        });

        function resetErrors() {
            var form = document.getElementById('loginForm');
            var data = new FormData(form);
            for (var [key, value] of data) {
                console.log(key, value)
                $('.' + key + '_err').text('');
                $('#' + key).removeClass('is-invalid');
                $('#' + key).addClass('is-valid');
            }
        }

        function printErrMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
                $('#' + key).addClass('is-invalid');
            });
        }

    });
</script>


</html>
