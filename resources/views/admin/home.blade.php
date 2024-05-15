@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Dashboard
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xl-4 col-lg-4">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-users">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div class="media-body"><span class="m-0">Total Users</span>
                                <h4 class="mb-0 counter" id="total_users">N/A</h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-users icon-bg">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4 col-lg-4">
                <div class="card o-hidden">
                    <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-aperture">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                                    <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                                    <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                                    <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                                    <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                                    <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                                </svg>
                            </div>
                            <div class="media-body"><span class="m-0">Total Apps</span>
                                <h4 class="mb-0 counter" id="total_apps">N/A</h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-aperture icon-bg">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                                    <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                                    <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                                    <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                                    <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                                    <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4 col-lg-4">
                <div class="card o-hidden">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-hard-drive">
                                    <line x1="22" y1="12" x2="2" y2="12"></line>
                                    <path
                                        d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                    </path>
                                    <line x1="6" y1="16" x2="6" y2="16"></line>
                                    <line x1="10" y1="16" x2="10" y2="16"></line>
                                </svg>
                            </div>
                            <div class="media-body"><span class="m-0">Total Users Feedback</span>
                                <h4 class="mb-0 counter" id="total_users_feedback"></h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-hard-drive icon-bg">
                                    <line x1="22" y1="12" x2="2" y2="12"></line>
                                    <path
                                        d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                    </path>
                                    <line x1="6" y1="16" x2="6" y2="16"></line>
                                    <line x1="10" y1="16" x2="10" y2="16"></line>
                                </svg>
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
        $.ajax({
            type: "POST",
            url: '{{ url('api/getAllReportByAdmin') }}',
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", token);
            },
            success: function(data) {
                let code = data.code;
                let message = data.message;
                if (code == 200) {

                    let report = data.data;
                    $("#total_users").text(report.total_users);
                    $("#total_apps").text(report.total_apps);
                    $("#total_users_feedback").text(report.total_users_feedback);
                } else {
                    swal({
                        title: "Oops...",
                        text: message,
                        type: "error",
                        icon: "error",
                        timer: 2000
                    });
                }
            },
            error: function(err) {
                swal({
                    title: "Oops...",
                    text: err.responseJSON.message ? err.responseJSON.message : 'Bad request Call....',
                    type: "error",
                    icon: "error",
                    timer: 2000
                });
            },
        });
    </script>
@endsection
