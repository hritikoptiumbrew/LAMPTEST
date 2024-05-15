@extends('admin.authentication.app')

@section('title')
    OB-Testimonial Login
@endsection

@section('content')

    <div class="login-card">
        <div>
            <div><a class="logo" href="#"><img class="img-fluid for-light" style="width: 300px;"
                                               src="{{asset('assets/images/logo/OptimumBrew.svg')}}"
                                               alt="looginpage"><img class="img-fluid for-dark" style="width: 300px;"
                                                                     src="{{asset('assets/images/logo/OptimumBrew.svg')}}"
                                                                     alt="looginpage"></a></div>
            <div class="login-main">

                <div style="background-color: #e44756;border-color: #e44756; display: none;"
                     class="alert alert-danger dark alert-dismissible fade show error-message" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-thumbs-down">
                        <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                    </svg>
                    <span class="error-message-text" style="margin-left: 5px;">  </span>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                            data-bs-original-title=""
                            title=""></button>
                </div>

                <form class="theme-form" id="login-form">
                    <h4>Sign in to account</h4>
                    <p>Enter your email & password to login</p>
                    <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="email" name="email_id" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <div class="form-input position-relative">
                            <input class="form-control" type="password" name="password" id="password" required="">
                            <div class="show-hide"><span class="show"></span></div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="text-end mt-3">
                            <button class="btn btn-primary btn-lg btn-block w-100 admin-login" type="submit"
                                    data-bs-toggle="tooltip" title="" data-bs-original-title="btn btn-primary btn-lg"
                                    data-original-title="btn btn-secondary btn-sm">Sign in
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('extra-script')

    <script type="text/javascript">

        let google2fa_url = localStorage.getItem("google2fa_url");
        if (google2fa_url) {
            let form = document.createElement("div");
            form.innerHTML = google2fa_url;

            swal({
                content: form,
            }).then(data => {
                localStorage.removeItem("google2fa_url");
            }).catch(err => {
                swal({text: err, icon: "error", timer: 2000});
            });
        }

        $('.show-hide').on('click', function () {
            $(this).toggleClass("show");
            let input = $("#password");
            console.log(input.attr);
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".admin-login").click(function (e) {
            e.preventDefault();
            let email_id = $("input[name=email_id]").val();
            let password = $("input[name=password]").val();

            if (email_id === '' || email_id === null) {
                document.getElementsByClassName('error-message')[0].style.display = 'block';
                document.getElementsByClassName('error-message-text')[0].innerHTML = 'Please enter email';
                setTimeout(function () {
                    document.getElementsByClassName('error-message')[0].style.display = 'none';
                }, 2000);
                return;
            } else if (password === '' || password === null) {
                document.getElementsByClassName('error-message')[0].style.display = 'block';
                document.getElementsByClassName('error-message-text')[0].innerHTML = 'Please enter password';
                setTimeout(function () {
                    document.getElementsByClassName('error-message')[0].style.display = 'none';
                }, 2000);
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{url('/api/doLoginForAdmin')}}',
                data: JSON.stringify({
                    email_id: email_id,
                    password: password
                }),
                success: function (data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {

                        let token = data.data.token;
                        let user_detail = data.data.user_detail;
                        user_detail.role_id = data.data.role_id;
                        if (token === '') {
                            swal({
                                text: 'Enter Verification Code',
                                content: "input",
                                button: {
                                    text: "OK",
                                    closeModal: false,
                                },
                            }).then(verify_code => {

                                if (verify_code === "") {
                                    swal({text: "Please enter verification code!", icon: "error", timer: 2000});
                                    //showAlertMessage(0, "Please enter verification code!");
                                    return false;
                                }

                                $.ajax({
                                    type: 'POST',
                                    data: JSON.stringify({
                                        verify_code: verify_code,
                                        google2fa_secret: user_detail.google2fa_secret,
                                        user_id: user_detail.id
                                    }),
                                    url: "{{url('api/verify2faOPT')}}",

                                    success: function (data) {
                                        let code = data.code;
                                        let message = data.message;
                                        if (code == 200) {
                                            if (data.data.token !== "") {
                                                window.localStorage.setItem('user_token', 'Bearer ' + data.data.token);
                                                window.localStorage.setItem('user_detail', JSON.stringify(user_detail));
                                                window.location = '{{route('admin.home')}}';
                                            } else {
                                                swal({text: message, icon: "warning", timer: 2000});
                                                //showAlertMessage(0, message);

                                            }
                                        } else {
                                            swal({text: message, icon: "error", timer: 2000});
                                            //showAlertMessage(0, message);
                                        }
                                    }

                                });

                            }).catch(err => {
                                swal({text: err, icon: "error", timer: 2000});
                                //showAlertMessage(0, err);

                            });
                        } else {
                            window.localStorage.setItem('user_token', 'Bearer ' + token);
                            window.localStorage.setItem('user_detail', JSON.stringify(user_detail));
                            window.location = '{{route('admin.home')}}';
                        }
                    } else {
                        swal({text: message, icon: "error", timer: 2000});
                        //showAlertMessage(0, err);
                    }
                },
                error: function (err) {
                    swal({text: err, icon: "error", timer: 2000});
                    //showAlertMessage(0, err);
                },
            });
        });

    </script>

@endsection
