@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | User Testimonial
@endsection
@section('extra-css')
    <style>
        .swal-modal{
           margin-right: 22px !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Testimonial Details</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Testimonial-Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    @include('admin.layouts.message')
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <label class="form-label" for="reportrange">Date range</label>
                                        <div class="theme-form">
                                            <input class="form-control reportrange" id="reportrange">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <label class="form-label" for="app-list">App</label>
                                        <select class="form-select app-list" id="app-list" required="">
                                            <option selected="" value="0">All</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label class="form-label" for="platform-list">Platform</label>
                                        <select onchange="getAllAppByPlatformForAdmin(this.value)"
                                            class="form-select platform-list" id="platform-list" required="">
                                            <option selected="" value="0">All</option>
                                            <option value="1">Android</option>
                                            <option value="2">IOS</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <label class="form-label" for="app-status">App Status</label>
                                        <select class="form-select platform-list" id="app-status" required="">
                                            <option selected="" value="2">All</option>
                                            <option value="1">Paid</option>
                                            <option value="0">Free</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                        <label class="form-label" for="validationCustom">Filter</label>
                                        <button
                                            onclick="getTestimonialDetails($('#platform-list').val(), $('#reportrange').val(), $('#app-list').val(),$('#app-status').val())"
                                            class="btn btn-primary btn-primary form-control" type="button" title=""
                                            data-bs-original-title="btn btn-primary btn-primary"
                                            data-original-title="btn btn-primary btn-light">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="ajax-data-object_wrapper" class="dataTables_wrapper">
                                        <table class="display datatables dataTable" id="ajax-data-object" role="grid"
                                            aria-describedby="ajax-data-object_info" style="width: 1173px;">
                                            <thead>
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>Preview</th>
                                                    <th>User Name</th>
                                                    <th>App</th>
                                                    <th>Platform</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Status</th>
                                                    <th>Feedback Type</th>
                                                    <th>Send Mail</th>
                                                    <th>User Preview</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fadeIn" id="gift-detail-modal" tabindex="-1" aria-labelledby="gift-detail-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Gift Card Detail</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <form id="send-mail-gift-form">
                        <input type="hidden" name="email" id="email">
                        <input type="hidden" name="app_id" id="app_id">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="user_name" id="user_name">
                        <input type="hidden" name="user_feedback_id" id="user_feedback_id">
                        <div class="mb-3">
                            <label class="col-form-label" for="gift-id">Id:</label>
                            <input class="form-control" type="text" name="gift" id="gift-id" value=""
                                   data-bs-original-title="" title="">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="gift-code">Code:</label>
                            <input class="form-control" type="text" id="gift-code" name="code" value=""
                                   data-bs-original-title="" title="">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="expiry-date">Expiration Date:</label>
                            <input class="form-control" type="date" id="expiry-date" name="expiry-date" value=""
                                   data-bs-original-title="" title="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Close</button>
                    <button class="btn btn-primary" type="button" onclick="sendGift()" data-bs-original-title="" title="">Send Gift</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fadeIn" id="gift-option-modal" tabindex="-1" aria-labelledby="gift-option-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Take Action</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"  aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <p>First you select the option then send the gift.</p>
                </div>
                <div class="modal-footer">
                    <i class="fa fa-eye fa-2x" style="cursor: pointer;margin-right: auto"  type="button" onclick="fillUserData($('#user_feedback_id').val())" data-bs-toggle="modal" data-bs-target="#user-preview" ></i>
                    <button class="btn btn-danger " type="button" id="reject-gift" onclick="rejectGift()">Reject gift</button>
                    <a href="https://www.amazon.in/gift-card-store/b?ie=UTF8&node=3704982031" target="_blank" ><button class="btn btn-secondary" type="button" onclick="updateRewardStatus($('#user_feedback_id').val())" data-bs-original-title="" title="">Amazon</button></a>
                    <button class="btn btn-primary" type="button" id="custom-mail-send-gift" data-bs-toggle="modal" data-bs-target="#gift-detail-modal" data-bs-original-title="" title="">Custom</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg show"  id="user-preview" tabindex="-1" role="dialog" aria-labelledby="userPreview" style="padding-right: 17px; display: none;" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">User Preview</h4>
                    <a href="#" style="padding-left: 20px" id="qr-link"><i class="fa fa-external-link fa-2x" aria-hidden="true"></i></a>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title="" id="this-model-close-button"></button>
                </div>
                <div class="modal-body" id="body-user-preview">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="email-modal" tabindex="-1"  style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mail-modal-title">Custom Mail</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="mail-id" name="email" value="">
                        <div class="mb-3">
                            <label class="col-form-label" for="subject">Subject:</label>
                            <input class="form-control" type="text" value="" id="subject" name="subject">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Close</button>
                    <button class="btn btn-primary" type="button" onclick="notifyViaMAil($('#mail-id').val(), $('#subject').val(), $('#description').val())" >Send Mail</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-script')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        let tdate = new Date();
        let dd = tdate.getDate();
        let mm = tdate.getMonth() + 1;
        let yyyy = tdate.getFullYear();
        let global_data = [];
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        const currentDate = yyyy + "-" + mm + "-" + dd;
        const beforeSeventhDate = moment().subtract(6, 'days').format('YYYY-MM-DD');
        console.log($('#send-mail-gift-form').validate({
            rules: {
                gift_id: {
                    required: true,
                },
                gift_code: {
                    required: true,
                },
                expiry_date: {
                    required: true,
                }
            },
            messages: {
                gift_id: "Please enter gift id",
                gift_code: "Please enter gift code",
                expiry_date: "Please enter expiry date"
            },
        }));

        getAllAppByPlatformForAdmin(0);
        getTestimonialDetails("0", beforeSeventhDate + " - " + currentDate, "0", "2");

        function getAllAppByPlatformForAdmin(platform) {

            $.ajax({
                url: '{{ url('api/getAllAppByPlatformForAdmin') }}',
                type: "POST",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    platform: platform
                }),
                success: function (data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        $('#app-list').empty().append('<option value="0">All</option>');

                        for (let i = 0; i < data.data.app_data.length; i++) {
                            let element = data.data.app_data[i];

                            $("#app-list").append(
                                "<option value=" + element.app_id + ">" + element.name + " - " + element.platform +  "</option>"
                            );
                        }

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
                error: function (err) {
                    swal({
                        title: "Oops...",
                        text: err.responseJSON.message ? err.responseJSON.message :
                            'Bad request Call....',
                        type: "error",
                        icon: "error",
                        timer: 2000
                    });
                }
            });
        }

        function getTestimonialDetails(platform, date_range, app_id, app_status) {
            $.ajax({
                type: "POST",
                url: '{{ url('api/getTestimonialDetail') }}',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    platform: platform,
                    date_range: date_range,
                    app_id: app_id,
                    app_status: app_status
                }),
                //data: data,
                success: function (data) {

                    let code = data.code;
                    let message = data.message;
                    let tbl = $('#ajax-data-object');
                    if (code == 200) {
                        global_data = data.data;
                        $("#ajax-data-object").dataTable().fnDestroy();
                        table = $('#ajax-data-object').DataTable({
                            "pageLength": 50,
                            "deferRender": true,
                            data: data.data,
                            columns: [{
                                "data": null,
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                }
                            },
                                {
                                    "data": "video_thumbnail",
                                    render: (data, type, row) => {
                                        return '<a  data-bs-toggle="modal" onclick="fillUserData('+row.user_feedback_id+', true)" data-bs-target="#user-preview"><img src="' + data +
                                            '" style="max-width: 100px;max-height: 100px"/></a>'
                                    }
                                },
                                {
                                    "data": "user_name"
                                },
                                {
                                    "data": "app_name"
                                },
                                {
                                    "data": "platform",
                                    render: (data) => {
                                        if (data == 'Android') {
                                            return '<i class="fa fa-android fa-2x"></i>';
                                        } else {
                                            return '<i class="fa fa-apple fa-2x"></i>';
                                        }
                                    },
                                    "width": "5px",
                                },
                                {
                                    "data": "created_at",
                                    render: (data) => {
                                        return moment.utc(data).local().format('DD/MM/YYYY hh:mm A');
                                    }
                                },
                                {
                                    "data": "updated_at",
                                    render: (data) => {
                                        return moment.utc(data).local().format('DD/MM/YYYY hh:mm A');
                                    }
                                },
                                {
                                    "data": "is_paid",
                                    render: (data) => {
                                        if (data == 1) {
                                            return '<span class="badge" style="background-color: #52595D">Paid</span>';
                                        } else {
                                            return '<span class="badge" style="background-color: #CECECE">Free</span>';
                                        }
                                    },
                                },
                                {
                                    "data": "feedback_type",
                                    render: (data) => {
                                        if (data == 1) {
                                            return '<span class="badge badge-secondary" style="background-color: #6c757d !important;">Pending</span>';
                                        }else if(data == 2){
                                            return '<span class="badge badge-success">Verified</span>';
                                        }else if(data == 3){
                                            return '<span class="badge badge-danger">Rejected</span>';
                                        }else{
                                            return '<span class="badge badge-info">Already Given</span>';
                                        }
                                    },
                                },
                                {
                                    "data": "user_feedback_id",
                                    render: (data, type, row) => {
                                        return '<i class="fa fa-send fa-2x" style="cursor: pointer"  type="button" onclick="fillUserMailData('+data+')" data-bs-toggle="modal" data-bs-target="#email-modal"></i>';
                                    }
                                },
                                {
                                    "data": "user_feedback_id",
                                    render: (data, type, row) => {
                                        return '<i class="fa fa-eye fa-2x" style="cursor: pointer"  type="button" onclick="fillUserData('+data+')" data-bs-toggle="modal" data-bs-target="#user-preview"></i>';
                                    }
                                },
                                {
                                    "data": "user_id",
                                    render: (data, type, row) => {
                                        if (row.feedback_type == 1 && row.is_paid == 1) {
                                            return '<button class="btn btn-primary-gradien pre-send-gift" type="button" data-bs-toggle="modal" data-bs-target="#gift-option-modal"  data-value="' + row.app_id + '" data-remote="' +
                                                row.email + '" data-action="' + data +
                                                '" title="" data-attr="'+ row.user_name +'" data-field="'+row.user_feedback_id+'" data-bs-original-title="btn btn-primary-gradien" data-original-title="btn btn-success-gradien"><i class="fa fa-gift"></i></button>';
                                        } else if (row.is_paid == 0) {
                                            return '<i class="fa fa-times fa-2x" style="color: #cecece"></i>';
                                        } else {
                                            return '<button class="btn btn-primary-gradien disabled" type="button" title="" data-bs-original-title="btn btn-primary-gradien" data-original-title="btn btn-success-gradien"><i class="fa fa-times"></i></button>';
                                        }
                                    }
                                },
                            ],
                            'columnDefs': [{
                                "targets": 4,
                                "className": "text-center",
                            },
                                {
                                    "targets": 7,
                                    "className": "text-center",
                                },
                                {
                                    "targets": 8,
                                    "className": "text-center",
                                },
                                {
                                    "targets": 9,
                                    "className": "text-center",
                                },
                                {
                                    "targets": 10,
                                    "className": "text-center",
                                }
                            ]
                        });
                        tbl.on('click', '.pre-send-gift', function (e) {
                            e.preventDefault();
                            preSendGift(this);
                        })
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
                error: function (err) {
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

        function preSendGift(el) {
            $('#gift-id').val('');
            $('#gift-code').val('');
            $('#expiry-date').val('');
            $('#email').attr("value", $(el).data('remote'));
            $('#user_id').attr("value", $(el).data('action'));
            $('#app_id').attr("value", $(el).data('value'));
            $('#user_name').attr("value", $(el).data('attr'));
            $('#user_feedback_id').attr("value", $(el).data('field'));
        }

        $(function () {
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var minDate = year + '-' + month + '-' + day;
            $('#expiry-date').attr('min', minDate);
        });

        $("#gift-detail-modal").on('show.bs.modal', function () {
            $("#gift-option-modal").modal("hide");
        });

        $('.video-modal-class').on('hidden.bs.modal', function () {
            $("video").each(function() {
                $(this).get(0).pause();
            });
        });

        function sendGift() {
            swal({
                title: "Are you sure ??",
                text: 'You will not be able to recover this gift mail !.',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((isConfirm) => {
                    if (isConfirm) {
                        $.ajax({
                            url: '{{ url('api/sendGiftMail') }}',
                            type: 'POST',
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader("Authorization", token);
                            },
                            data:  JSON.stringify({
                                _method: 'POST',
                                email: $("input[name=email]").val(),
                                user_id: $("input[name=user_id]").val(),
                                user_feedback_id: $("input[name=user_feedback_id]").val(),
                                user_name: $("input[name=user_name]").val(),
                                app_id: $("input[name=app_id]").val(),
                                gift_id: $("input[name=gift]").val(),
                                gift_code: $("input[name=code]").val(),
                                expiry_date: $("input[name=expiry-date]").val(),
                            }),
                            dataType: 'json',
                            success: function (data) {
                                getTestimonialDetails("0", beforeSeventhDate + " - " + currentDate, "0", "2");
                                let code = data.code;
                                let message = data.message;
                                if (code == 200) {
                                    swal("Success!", message, "success").then(
                                        location.reload()
                                    );
                                } else {
                                    swal("Oops!!", message, "error");
                                }
                            },
                            error: function (err) {
                                swal("Oops!", err.responseJSON.message ? err.responseJSON.message :
                                    'Bad request Call....', "error");
                            }
                        });
                    } else {
                        swal("Oops!!", 'Your gift mail safe!', "error");
                    }
                });
        }

        function rejectGift() {
            $("#gift-detail-modal").modal("hide");
            $.ajax({
                type: "POST",
                url: '{{ url('api/rejectGift') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    user_feedback_id: $("input[name=user_feedback_id]").val(),
                }),
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        swal("Updated!", message, "success").then(
                            getTestimonialDetails("0", beforeSeventhDate + " - " + currentDate, "0", "2"),
                            $("#gift-option-modal").modal("hide")
                        );
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

        function updateRewardStatus() {
            $("#gift-detail-modal").modal("hide");
            $.ajax({
                type: "POST",
                url: '{{ url('api/updateRewardStatus') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    user_feedback_id: $("input[name=user_feedback_id]").val(),
                }),
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        location.reload()
                        console.log(data.message)
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

        const fillUserData = (data, is_video = false) => {
           let userData = global_data.find(y => y.user_feedback_id == data);
           let userInfo = JSON.parse(userData.user_info);
           let gift_id = (userData.gift_id != null) ? userData.gift_id : '-';
           let gift_code = (userData.gift_code != null) ? userData.gift_code : '-';
           let expired_date = (userData.expired_date != null) ? userData.expired_date : '-';
            $("#qr-link").hide();
            if (userData.reward_type == 1) {
                var reward_type = 'Amazon';
            } else if (userData.reward_type == 2) {
                var reward_type = 'Custom';
            } else {
                var reward_type = '-';
            }
            let htmlStr;
            if(is_video == false){
                htmlStr = `<div class="card-body">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Name</label>
                                        <input class="form-control" id="name" type="text" value="${userData.user_name}" title="${userData.user_name}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" id="email" type="text" value="${userData.email}" title="${userData.email}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row g-3">
                                      <div class="col-md-12">
                                        <label class="form-label" for="designation">Designation</label>
                                        <input class="form-control" id="designation" type="text" value="${userData.designation}" title="${userData.designation}" disabled>
                                    </div>
                                 </div>
                                 <br>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="country">Country</label>
                                        <input class="form-control" id="country" type="text" value="${userData.country}" title="${userData.country}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="app_name">App Name</label>
                                        <input class="form-control" id="app_name" type="text" value="${userData.app_name}" title="${userData.app_name}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="submitted_at">Submitted At</label>
                                        <input class="form-control" id="submitted_at" type="text" value="${moment.utc(userData.created_at).local().format('DD/MM/YYYY hh:mm A')}" title="${moment.utc(userData.created_at).local().format('DD/MM/YYYY hh:mm A')}" disabled>
                                    </div>
                                 </div>
                                 <br>
                                  <div class="modal-header">
                                         <h4 class="modal-title" id="myLargeModalLabel">Gift Preview</h4>
                                  </div>
                                  <br>
                                 <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="designation">Gift Id</label>
                                        <input class="form-control" id="designation" type="text" value="${gift_id}" title="${gift_id}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="country">Gift Code</label>
                                        <input class="form-control" id="country" type="text" value="${gift_code}" title="${gift_code}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="expiry_date">Expiry Date</label>
                                        <input class="form-control" id="expiry_date" type="text" value="${expired_date}" title="${expired_date}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="submitted_at">Reward Type</label>
                                        <input class="form-control" id="submitted_at" type="text" value="${reward_type}" title="${reward_type}" disabled>
                                    </div>
                                 </div>
                                 <br>
                                     <div class="modal-header" id="mh">
                                         <h4 class="modal-title" id="myLargeModalLabel">More Info</h4>
                                      </div>
                                      <div class="user-more-info">
                                      </div>
                                 <br>
                            </form>`;
            }else {
                htmlStr = `
                <div style="width: 100%;height: auto;text-align: center;">
                    <div id="feedback-video">
                    <video style="max-width: 100%;max-height: calc(100vh - 210px);" controls >
                        <source src="${userData.video}">
                        </video>
                    </div>
                    </div>

                `;
            }
            $("#body-user-preview").html(htmlStr);

            let appendBodyHtmlStr;
            let is_purchased;
            let is_login;
            let country_code;
            let platform;
            let device_name;
            let appendExtraUserInfo;

            if (userInfo != null) {
                appendExtraUserInfo = `<div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="device_platform">Device Platform</label>
                                        <input class="form-control" id="device_platform" type="text" value="${userInfo.device_platform}" title="${userInfo.device_platform}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="device_os_version">Device OS Version</label>
                                        <input class="form-control" id="device_os_version" type="text" value="${userInfo.device_os_version}" title="${userInfo.device_os_version}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="device_type">Device Type</label>
                                        <input class="form-control" id="device_type" type="text" value="${userInfo.device_type}" title="${userInfo.device_type}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="product_id">Product Id</label>
                                        <input class="form-control" id="product_id" type="text" value="${userInfo.url_d ? userInfo.url_d : '-'}" title="${userInfo.url_d ? userInfo.url_d : '-'}" disabled>
                                    </div>
                                `;
                if (userInfo.testimonial_come_from == 1) {
                    is_purchased = (userInfo.is_purchased == 1) ? 'Purchased' : 'Not Purchased';
                    is_login = (userInfo.is_login == 1) ? 'Logged in' : 'Not Logged in';
                    country_code = (userInfo.country_code) ? userInfo.country_code : '-';
                    device_name = (userInfo.device_name) ? userInfo.device_name : '-';
                    if (userInfo.platform == 1) {
                        platform = 'Android';
                    } else if (userInfo.platform == 2) {
                        platform = 'IOS';
                    } else {
                        platform = 'Web';
                    }
                    appendBodyHtmlStr = `<br><div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="browser_name">Testimonial Come From</label>
                                        <input class="form-control" id="browser_name" type="text" value="Mobile" title="Mobile" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="ip">Is Purchased</label>
                                        <input class="form-control" id="ip" type="text" value="${is_purchased}" title="${is_purchased}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="il">Is Login</label>
                                        <input class="form-control" id="il" type="text" value="${is_login}" title="${is_login}" disabled>
                                    </div>
                                </div>
                                 <br>
                                   <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="suid">Social User Id</label>
                                        <input class="form-control" id="suid" type="text" value="${userInfo.social_user_id}" title="${userInfo.social_user_id}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="cc">Country Code</label>
                                        <input class="form-control" id="cc" type="text" value="${country_code}" title="${country_code}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="platform">Platform</label>
                                        <input class="form-control" id="platform" type="text" value="${platform}" title="${platform}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="dn">Device Name</label>
                                        <input class="form-control" id="dn" type="text" value="${device_name}" title="${device_name}" disabled>
                                    </div>
                                </div>
                                <br>${appendExtraUserInfo}`;

                    $("#qr-link").show();
                    path = "{{url('user-qr-details')}}/";
                    url = path + userInfo.social_user_id;
                    document.getElementById("qr-link").setAttribute("href",url);

                } else {
                    uploadType = (userInfo.upload_type == 1) ? 'Capture Video' : 'Choose Video';

                    appendBodyHtmlStr = `<br><div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="tcf">Testimonial Come From</label>
                                        <input class="form-control" id="tcf" type="text" value="Web" title="Web" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="browser_name">Browser Name</label>
                                        <input class="form-control" id="browser_name" type="text" value="${userInfo.browser_name}" title="${userInfo.browser_name}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="app_name">Upload Type</label>
                                        <input class="form-control" id="app_name" type="text" value="${uploadType}" title="${uploadType}" disabled>
                                    </div>
                                </div><br>
                                </div>${appendExtraUserInfo}`;
                }
                $(".user-more-info").html(appendBodyHtmlStr);
            }else{
                $('#mh').hide();
            }
        }

        const fillUserMailData = (data) => {
            let userData = global_data.find(y => y.user_feedback_id == data);
            $("#subject").val('');
            $("#mail-id").val(userData.email);
            $("#description").val(userData.user_name);
        }

        const notifyViaMAil = (email,subject,description) =>{
            $.ajax({
                type: "POST",
                url: '{{ url('api/notifyUserViaMail') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    email: email,
                    subject: subject,
                    description: description
                }),
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        swal("Updated!", message, "success").then(
                            $("#email-modal").modal('hide')
                    );
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

        $('#user-preview').on('hidden.bs.modal', function () {
            $("#feedback-video").children().filter("video").each(function(){
                this.pause();
                delete(this);
                $(this).remove();
            });

            $("#feedback-video").html();

        });

        $('#this-model-close-button').on('click', function () {
            $("#feedback-video").children().filter("video").each(function(){
                this.pause();
                delete(this);
                $(this).remove();
            });

            $("#feedback-video").html();

        });
    </script>
@endsection
