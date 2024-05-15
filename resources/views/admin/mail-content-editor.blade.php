@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Mail Content Editor
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Mail Content Editor</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Mail Content Editor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Free</h5>
                        </div>
                        <div class="card-body">
                            <div class="form theme-form">
                                <input type="hidden" value="1" id="free-testimonial">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="subject">Subject</label>
                                            <input class="form-control" id="ft-subject" type="text"
                                                data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="ft-description" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center"><a class="btn btn-primary me-3"
                                                onclick="mailContent($('#free-testimonial').val(), $('#ft-subject').val(), $('#ft-description').val())"
                                                data-bs-original-title="" title="">Update</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Before verification</h5>
                        </div>
                        <div class="card-body">
                            <div class="form theme-form">
                                <input type="hidden" value="2" id="before-verification-testimonial">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label>Subject</label>
                                            <input class="form-control" type="text" id="bvt-subject"
                                                data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="bvt-description" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center"><a class="btn btn-primary me-3"
                                                onclick="mailContent($('#before-verification-testimonial').val(), $('#bvt-subject').val(), $('#bvt-description').val())"
                                                data-bs-original-title="" title="">Update</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>After verification</h5>
                        </div>
                        <div class="card-body">
                            <div class="form theme-form">
                                <input type="hidden" value="3" id="after-verification-testimonial">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label>Subject</label>
                                            <input class="form-control" type="text" id="avt-subject"
                                                data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea class="form-control" id="avt-description" name="description" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center"><a class="btn btn-primary me-3"
                                                onclick="mailContent($('#after-verification-testimonial').val(), $('#avt-subject').val(), $('#avt-description').val())"
                                                data-bs-original-title="" title="">Update</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="color: #898989;font-size: 13px;text-align: center;padding-bottom: 12px;">app_name is variable that convert with actual value</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        $(function() {
            $.ajax({
                type: "POST",
                url: '{{ url('api/getMailContent') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    let mail_data = data.data;
                    if (code == 200) {
                        $.each(mail_data, function(index, value) {
                            if (value.content_type == 1) {
                                $("#ft-subject").val(value.subject);
                                $("#ft-description").val(value.description);
                            } else if (value.content_type == 2) {
                                $("#bvt-subject").val(value.subject);
                                $("#bvt-description").val(value.description);
                            } else {
                                $("#avt-subject").val(value.subject);
                                $("#avt-description").val(value.description);
                            }
                        });

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
                        text: err.responseJSON.message ? err.responseJSON.message :
                            'Bad request Call....',
                        type: "error",
                        icon: "error",
                        timer: 2000
                    });
                },
            });
        })

        function mailContent(content_type, subject, description) {
            $.ajax({
                type: "POST",
                url: '{{ url('api/updateMailContent') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    content_type: content_type,
                    subject: subject,
                    description: description
                }),
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        swal("Updated!", message, "success");
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
                        text: err.responseJSON.message ? err.responseJSON.message :
                            'Bad request Call....',
                        type: "error",
                        icon: "error",
                        timer: 2000
                    });
                },
            });
        }
    </script>
@endsection
