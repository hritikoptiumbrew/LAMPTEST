@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Settings
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Settings</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="user-profile">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="profile-img-style">
                                <div class="row">
                                    @include('admin.layouts.message')
                                    <div class="col-sm-8">
                                        <div class="media">
                                            <div class="media-body align-self-center">
                                                <h5 class="mt-0 user-name">Change Password</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <form id="reset-password-from">
                                    <div class="mb-3 m-form__group">
                                        <div class="input-group"><span class="input-group-text">Current :</span>
                                            <input name="current-password" class="form-control" type="password"
                                                placeholder="Enter current password">
                                        </div>
                                    </div>
                                    <div class="mb-3 m-form__group">
                                        <div class="input-group"><span class="input-group-text">New :</span>
                                            <input name="new-password" class="form-control" type="password"
                                                placeholder="Enter new password">
                                        </div>
                                    </div>
                                    <div class="mb-3 m-form__group">
                                        <div class="input-group"><span class="input-group-text">Repeat :</span>
                                            <input name="confirm-new-password" class="form-control" type="password"
                                                placeholder="Re-enter new password">
                                        </div>
                                    </div>
                                    <button class="btn btn-square btn-primary change-password" type="submit" title=""
                                        data-bs-original-title="btn btn-square btn-primary"
                                        data-original-title="btn btn-square btn-light">Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="profile-img-style">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="media">
                                            <div class="media-body align-self-center">
                                                <h5 class="mt-0 user-name">Two-Factor Authentication</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <form>
                                    <div class="mb-3 m-form__group">
                                        <div class="input-group">
                                            <div class="media-body text-end icon-state">
                                                <label class="switch">
                                                    <input id="switch-2fa" class="switch-2fa" type="checkbox"
                                                        data-bs-original-title="" title="" onchange="switchToggle()"
                                                        checked>
                                                    <span class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        if (google2fa_enable == 0) {
            //document.getElementById("switch-2fa").removeAttribute("checked");
            document.getElementById("switch-2fa").checked = false;
        }

        $(".change-password").click(function(e) {

            e.preventDefault();
            let current_password = $("input[name=current-password]").val();
            let new_password = $("input[name=new-password]").val();
            let confirm_new_password = $("input[name=confirm-new-password]").val();

            if (new_password !== confirm_new_password) {
                let message = 'New password & repeat new password doesn\'t match.';
                showAlertMessage(0, message);
                //swal({text: message, icon: "error", timer: 2000});
                return;
            } else if (new_password.length < 8) {
                let message = 'New password should have at-least 8 character';
                showAlertMessage(0, message);
                //swal({text: message, icon: "error", timer: 2000});
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ url('/api/changePassword') }}',
                beforeSend: function(xhr) {
                    //Include the bearer token in header
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    current_password: current_password,
                    new_password: new_password
                }),
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {

                        let token = data.data.token;
                        window.localStorage.setItem('user_token', 'Bearer ' + token);
                        //swal({text: message, icon: "success", timer: 2000});
                        showAlertMessage(1, message);
                        document.getElementById("reset-password-from").reset();

                    } else {
                        //swal({text: message, icon: "error", timer: 2000});
                        showAlertMessage(0, message);
                    }
                }
            });
        });

        function switchToggle() {
            let is_checked = $("#switch-2fa").is(":checked");

            if (is_checked === true) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/api/enable2faByAdmin') }}',
                    beforeSend: function(xhr) {
                        //Include the bearer token in header
                        xhr.setRequestHeader("Authorization", token);
                    },
                    success: function(data) {
                        let code = data.code;
                        let message = data.message;
                        if (code == 200) {
                            console.log(data);
                            localStorage.clear();
                            window.localStorage.setItem('google2fa_url', data.data.google2fa_url);
                            window.location = '{{ route('admin.login') }}';

                        } else {
                            document.getElementById("switch-2fa").checked = false;
                            swal({
                                text: message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(error) {
                        document.getElementById("switch-2fa").checked = false;
                        swal({
                            text: error,
                            icon: "error"
                        });
                    }
                });

            } else {

                swal({
                    text: 'Enter Verification Code',
                    content: "input",
                    button: {
                        text: "OK",
                        closeModal: false,
                    },
                }).then(verify_code => {

                    if (verify_code === "") {
                        document.getElementById("switch-2fa").checked = true;
                        swal({
                            text: "Please enter verification code!",
                            icon: "error",
                            timer: 2000
                        });
                        //showAlertMessage(0, "Please enter verification code!");
                        return false;
                    }

                    $.ajax({
                        type: 'POST',
                        data: JSON.stringify({
                            verify_code: verify_code,
                            google2fa_secret: google2fa_secret,
                            user_id: user_id
                        }),
                        url: "{{ url('api/verify2faOPT') }}",

                        success: function(data) {
                            let code = data.code;
                            let message = data.message;
                            if (code == 200) {
                                if (data.data.token !== "") {
                                    let user_detail = data.data.user_detail;
                                    window.localStorage.setItem('google2fa_secret', user_detail
                                        .google2fa_secret);
                                    window.localStorage.setItem('google2fa_enable', user_detail
                                        .google2fa_enable);
                                    window.localStorage.setItem('user_id', user_detail.id);
                                    window.localStorage.setItem('user_token', 'Bearer ' + data.data
                                        .token);

                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url('/api/disable2faByAdmin') }}',
                                        beforeSend: function(xhr) {
                                            xhr.setRequestHeader("Authorization",
                                                'Bearer ' + data.data.token);
                                        },
                                        data: JSON.stringify({
                                            verify_code: verify_code,
                                            google2fa_secret: user_detail
                                                .google2fa_secret
                                        }),
                                        success: function(data) {
                                            let code = data.code;
                                            let message = data.message;
                                            if (code == 200) {

                                                let user_detail = data.data.user_detail;
                                                window.localStorage.setItem(
                                                    'google2fa_secret', user_detail
                                                    .google2fa_secret);
                                                window.localStorage.setItem(
                                                    'google2fa_enable', user_detail
                                                    .google2fa_enable);
                                                window.localStorage.setItem('user_id',
                                                    user_detail.id);
                                                window.localStorage.setItem('user_token',
                                                    'Bearer ' + data.data.token);
                                                window.location =
                                                    '{{ route('admin.settings') }}';

                                            } else {
                                                document.getElementById("switch-2fa")
                                                    .checked = true;
                                                swal({
                                                    text: message,
                                                    icon: "error",
                                                    timer: 2000
                                                });
                                            }
                                        },
                                        error: function(error) {
                                            document.getElementById("switch-2fa").checked =
                                                true;
                                            swal({
                                                text: error,
                                                icon: "error",
                                                timer: 2000
                                            });
                                        }
                                    });

                                } else {
                                    document.getElementById("switch-2fa").checked = true;
                                    swal({
                                        text: message,
                                        icon: "warning",
                                        timer: 2000
                                    });
                                    //showAlertMessage(0, message);

                                }
                            } else {
                                document.getElementById("switch-2fa").checked = true;
                                swal({
                                    text: message,
                                    icon: "error",
                                    timer: 2000
                                });
                                //showAlertMessage(0, message);
                            }
                        },
                        error: function(error) {
                            document.getElementById("switch-2fa").checked = true;
                            swal({
                                text: error,
                                icon: "error"
                            });
                        }

                    });

                }).catch(err => {
                    document.getElementById("switch-2fa").checked = true;
                    swal({
                        text: err,
                        icon: "error",
                        timer: 2000
                    });
                    //showAlertMessage(0, err);

                });
            }
        }
    </script>
@endsection
