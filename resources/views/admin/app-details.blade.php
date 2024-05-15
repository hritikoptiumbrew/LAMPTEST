@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | App Details
@endsection
@section('dropzone-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/dropzone.css') }}">
@endsection
@section('extra-css')
    <style>
        /*.modal-body {*/
        /*    max-height: calc(100vh - 200px);*/
        /*    overflow-y: auto;*/
        /*}*/
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/testimonial/style.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap" rel="stylesheet">
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>App Details</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">App-Details</li>
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
                                <!-- Using the grid modal-->
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target=".bd-example-modal-lg" data-bs-original-title="" title=""
                                    style="float: right;">Add Application
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="ajax-data-object_wrapper" class="dataTables_wrapper">
                                        <table class="display datatables dataTable" id="ajax-data-object" role="grid"
                                            aria-describedby="ajax-data-object_info" style="width: 1173px;">
                                            <thead>
                                                <tr role="row">
                                                    <th>App Id</th>
                                                    <th>Name</th>
                                                    <th>Original Image</th>
                                                    <th>Package Name</th>
                                                    <th>Platform</th>
                                                    <th>Is Paid</th>
                                                    <th>Play Store Url</th>
                                                    <th>App Store Url</th>
                                                    <th>Youtube Url</th>
                                                    <th>Is Active</th>
                                                    <th>Slug</th>
                                                    <th>Price</th>
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
    <div id="AppModel" class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Add New App</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                        data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body" style="padding: 0px">
                            <form id="app_form">
                                <div class="card-body" style="padding: 0px">
                                    <div class="row">
                                        <div class="col-xl-7 col-md-12">
                                            <div class="mb-3 row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-6" style="display: flex;justify-content: center">
                                                    <img src="#" alt="show"
                                                        style="max-height:200px; max-width:200px;display: none"
                                                        id="logo_id">
                                                </div>
                                                <div class="col-sm-3"></div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="app_logo">App logo</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="file" alt="app_logo"
                                                        name="app_logo" id="app_logo" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="app_name">App name</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="app_name"
                                                        id="app_name" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="platform">Platform</label>
                                                <div class="col-sm-10">
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="android" type="radio"
                                                            name="platform" value="1">
                                                        <label class="form-check-label mb-0"
                                                            for="android">Android</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="ios" type="radio"
                                                            name="platform" value="2">
                                                        <label class="form-check-label mb-0"
                                                            for="ios">IOS</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="web" type="radio"
                                                               name="platform" value="3">
                                                        <label class="form-check-label mb-0"
                                                               for="web">Web</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="package">Package</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="package"
                                                        id="package" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="play_store_url">Play Store URL</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="url" name="play_store_url"
                                                        id="play_store_url" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="app_store_url">App Store URL</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="url" name="app_store_url"
                                                           id="app_store_url" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="you_tube_url">Youtube URL</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="url" name="you_tube_url"
                                                           id="you_tube_url" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="slug">Slug</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="slug"
                                                        id="slug" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="price">Price</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" name="price"
                                                        id="price" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="main_question">Main
                                                    Question</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="main_question"
                                                        id="main_question" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-2 col-form-label" for="custom_message">Custom
                                                    Message</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="custom_message"
                                                        id="custom_message" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row" id="question-section">
                                                <label class="col-sm-2 col-form-label" for="question">Questions</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-3" id="question-input">
                                                        <input type="text" class="form-control" id="question"
                                                            name="question_name[]" placeholder="Enter Question" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary ms-3 add-question-btn"
                                                                id="add-question" type="button"><i
                                                                    class="icon-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="dynamic_field">
                                            </div>
                                            <div class="mb-3 row">
                                                <input class="form-control" type="hidden" name="app_id" id="app_id"
                                                    required>
                                            </div>
                                            <div class="card-footer text-end">
                                                <div class="col-sm-9 offset-sm-3">
                                                    <button class="btn btn-primary" type="button" id="sendAppData"
                                                            onclick="addApp()">Add
                                                    </button>
                                                    <input onclick="resetFrom()" class="btn btn-secondary" type="reset"
                                                           value="Reset">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-md-12">
                                            <div class="disp-preview-container" style="overflow:hidden;margin-left: auto;margin-right: auto;max-width: 375px;max-height: 695px;border: 1px solid gray;border-radius: 10px">
                                                <div>
                                                    <header>
                                                        <div class="hurryup d-flex">
                                                            <div class="gift-section">
                                                                <img src="{{asset('assets/images/testimonial/hurryup.svg')}}" alt="">
                                                            </div>
                                                            <div class="gift-writting">
                                                                <h2 class="main-heading">Hurry up!</h2>
                                                                <h3 class="main-sub-heading">Give a Review, Get $10.</h3>
                                                                <p class="side-text">T&C Apply</p>
                                                            </div>
                                                        </div>
                                                    </header>
                                                    <main>
                                                        <div class="d-flex justify-content-center">
                                                            <img class="w-100 pt-5 px-3" src="{{asset('assets/images/testimonial/video.jpg')}}" alt="">
                                                        </div>
                                                        <p class="video-text" id="pre-main-question">
                                                        </p>
                                                        <!-- ........ -->
                                                        <div style="padding-bottom: 65px;">
                                                            <h4 class="border-type" id="pre-custom-message">Hints of Shoutout</h4>
                                                            <ul class="point-hints">
                                                                <li>Who are you / what are you working on?</li>
                                                                <li>What is it like before using Flyer Maker?</li>
                                                                <li>What impact Flyer Maker bring to your business?</li>
                                                                <li>How would you recommend Flyer Maker to your peers?</li>
                                                            </ul>
                                                        </div>
                                                    </main>
                                                </div>
                                                <footer style="position: sticky; bottom: 0;">
                                                    <div style="padding: 8px 15px 10px;background-color: #ffffff;position: absolute;bottom: 0;width: 100%;">
                                                        <button class="recorder-btn">
                                                            <img class="recorderimg" src="{{asset('assets/images/testimonial/recorder.svg')}}" alt="">
                                                            Record a video
                                                            <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
                                                        </button>
                                                    </div>
                                                </footer>
                                            </div>
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
@endsection
@section('dropzone-js')
    <script src="{{ asset('assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone/dropzone-script.js') }}"></script>
@endsection

@section('extra-script')
    <script type="text/javascript">
        app_logo.onchange = evt => {
            const [file] = app_logo.files;
            if (file) {
                logo_id.style = "max-height:200px; max-width:200px;";
                logo_id.src = URL.createObjectURL(file);
            }
        };
        $("#add-question").hide();
        $("#question").keyup(function() {
            if ($(this).val()) {
                $("#add-question").show();
            } else {
                $("#add-question").hide();
            }
        });

        var i = 1;

        $('#add-question').click(function() {
            i++;
            $('#dynamic_field').append('<div class="mb-3 row" id="row' + i + '">' +
                '<label class="col-sm-2 col-form-label"></label>' +
                '<div class="col-sm-10">' +
                '<div class="input-group mb-3">' +
                '<input type="text" class="form-control" id="' + i +
                '" name="question_name[]" placeholder="Enter Question" required>' +
                '<div class="input-group-append">' +
                '<button class="btn btn-danger ms-3 remove-question" id="' + i +
                '" type="button"><i class="icon-trash"></i></button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>');
        });

        $(document).on('click', '.remove-question', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        function addApp() {
            let app_name = $("input[name=app_name]").val();
            let platform = $("input[name=platform]:checked").val();
            let category = $("select[name=category]").val();
            let package_name = $("input[name=package]").val();
            let play_store_url = $("input[name=play_store_url]").val();
            let app_store_url = $("input[name=app_store_url]").val();
            let you_tube_url = $("input[name=you_tube_url]").val();
            let slug = $("input[name=slug]").val();
            let price = $("input[name=price]").val();
            let main_question = $("input[name=main_question]").val();
            let custom_message = $("input[name=custom_message]").val();
            var question_name = $("input[name='question_name[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            let tags = {
                name: app_name,
                platform: platform,
                category_id: category,
                package_name: package_name,
                play_store_url: play_store_url,
                app_store_url: app_store_url,
                you_tube_url: you_tube_url,
                slug: slug,
                price: price,
                main_question: main_question,
                custom_message: custom_message,
                question_name: question_name
            };
            let form_Data = new FormData();
            form_Data.append('request_data', JSON.stringify(tags));
            form_Data.append('file', $('input[type=file]')[0].files[0]);

            $.ajax({
                type: "POST",
                url: '{{ url('api/addApp') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: form_Data,
                contentType: false,
                processData: false,
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        window.location = '{{ route('admin.app-details') }}';

                    } else {
                        swal({
                            title: "Oops...",
                            text: message,
                            type: "error",
                            icon: "error",
                            timer: 2000
                        });
                        //showAlertMessage(0, err);
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
                    //showAlertMessage(0, err);
                },
            });

        }

        function updateApp() {
            let app_name = $("input[name=app_name]").val();
            let platform = $("input[name=platform]:checked").val();
            let category = $("select[name=category]").val();
            let package_name = $("input[name=package]").val();
            let play_store_url = $("input[name=play_store_url]").val();
            let app_store_url = $("input[name=app_store_url]").val();
            let you_tube_url = $("input[name=you_tube_url]").val();
            let app_id = $("input[name=app_id]").val();
            let slug = $("input[name=slug]").val();
            let price = $("input[name=price]").val();
            let main_question = $("input[name=main_question]").val();
            let custom_message = $("input[name=custom_message]").val();
            var question_name = $("input[name='question_name[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            let tags = {
                app_id: app_id,
                name: app_name,
                platform: platform,
                category_id: category,
                package_name: package_name,
                play_store_url: play_store_url,
                app_store_url: app_store_url,
                you_tube_url: you_tube_url,
                slug: slug,
                price: price,
                main_question: main_question,
                custom_message: custom_message,
                question_name: question_name
            };
            let form_Data = new FormData();
            form_Data.append('request_data', JSON.stringify(tags));
            if (typeof $('input[type=file]')[0].files[0] !== 'undefined') {
                form_Data.append('file', $('input[type=file]')[0].files[0]);
            }

            $.ajax({
                type: "POST",
                url: '{{ url('api/updateApp') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: form_Data,
                contentType: false,
                processData: false,
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        window.location = '{{ route('admin.app-details') }}';

                    } else {
                        swal({
                            title: "Oops...",
                            text: message,
                            type: "error",
                            icon: "error",
                            timer: 2000
                        });
                        //showAlertMessage(0, err);
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
                    //showAlertMessage(0, err);
                },
            });

        }

        getAllAppByPlatformForAdmin(0);
        let modelData = [];
        let question_data = [];

        function getAllAppByPlatformForAdmin(platform) {

            $.ajax({
                url: '{{ url('api/getAllAppByPlatformForAdmin') }}',
                type: "POST",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                data: JSON.stringify({
                    platform: platform
                }),
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        modelData = data.data.app_data;
                        question_data = data.data.questions;

                        $("#ajax-data-object").dataTable().fnDestroy();
                        let table = $('#ajax-data-object').DataTable({
                            "order": [
                                [0, 'desc']
                            ],
                            data: data.data.app_data,
                            columns: [{
                                    "data": "app_id",
                                },
                                {
                                    "data": "name"
                                },
                                {
                                    "render": function(data, type, row) {
                                        return '<a href="' + row.compressed_image +
                                            '" target="_blank"><img src="' + row
                                            .webp_thumbnail_image +
                                            '" style="max-height:80px; max-width:80px" /></a>';
                                    }
                                },
                                {
                                    "data": "package_name",
                                    "width": "5px"
                                },
                                {
                                    "data": "platform",
                                    render: (data) => {
                                        if (data == 'Android') {
                                            return '<i class="fa fa-android fa-2x"></i>';
                                        } else if (data == 'iOS') {
                                            return '<i class="fa fa-apple fa-2x"></i>';
                                        }else{
                                            return '<i class="fa fa-globe fa-2x"></i>';
                                        }
                                    },
                                    "width": "5px",
                                },
                                {
                                    "data": "app_id",
                                    "render": function(data, type, row) {
                                        if (row.is_paid == 1) {
                                            return '<div class="media-body text-end icon-state">' +
                                                '<label class="switch">' +
                                                '<input id="is_paid' + data +
                                                '" class="toggle-class" type="checkbox" data-bs-original-title="" title="" onchange="switchToggleIsPaid(' +
                                                data +
                                                ')" checked><span class="switch-state"></span>' +
                                                '</label>' +
                                                '</div>';

                                        } else {
                                            return '<div class="media-body text-end icon-state">' +
                                                '<label class="switch">' +
                                                '<input id="is_paid' + data +
                                                '" class="toggle-class" type="checkbox" data-bs-original-title="" title="" onchange="switchToggleIsPaid(' +
                                                data +
                                                ')"><span class="switch-state"></span>' +
                                                '</label>' +
                                                '</div>';
                                        }
                                    }
                                },
                                {
                                    "data": "play_store_url",
                                    "width": "10px"
                                },
                                {
                                    "data": "app_store_url",
                                    "width": "10px"
                                },
                                {
                                    "data": "youtube_url",
                                    "width": "10px"
                                },
                                {
                                    "data": "app_id",
                                    "render": function(data, type, row) {
                                        if (row.is_active == 1) {
                                            // $(`#is_active${data}`).attr("checked", "checked");
                                            return '<div class="media-body text-end icon-state">' +
                                                '<label class="switch">' +
                                                '<input id="is_active' + data +
                                                '" class="toggle-class" type="checkbox" data-bs-original-title="" title="" onchange="switchToggleIsActive(' +
                                                data +
                                                ')" checked><span class="switch-state"></span>' +
                                                '</label>' +
                                                '</div>';
                                        } else {
                                            return '<div class="media-body text-end icon-state">' +
                                                '<label class="switch">' +
                                                '<input id="is_active' + data +
                                                '" class="toggle-class" type="checkbox" data-bs-original-title="" title="" onchange="switchToggleIsActive(' +
                                                data +
                                                ')"><span class="switch-state"></span>' +
                                                '</label>' +
                                                '</div>';
                                        }
                                    }
                                },
                                {
                                    "render": function(data, type, row) {
                                        return '<a href="' + row.slug_url +
                                            '" target="_blank">' + row.slug + '</a>';
                                    }
                                },
                                {
                                    "data": "price",
                                    "width": "10px"
                                },
                                {
                                    "data": "app_id",
                                    "render": function(data, type, row) {

                                        return '<div style="display: flex">' +
                                            '<button class="btn btn-secondary btn-xs" type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" data-original-title="btn btn-danger btn-xs" title="edit" data-bs-original-title="" onclick="setValueForEditModal(' +
                                            data + ')" style="border-radius: 10px">' +
                                            '<i class="fa fa-pencil"></i>' +
                                            '</button> &nbsp ' +

                                            '<button class="btn btn-danger btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="delete" data-bs-original-title="" onclick="deleteApp(' +
                                            data + ')" style="border-radius: 10px">' +
                                            '<i class="fa fa-trash-o"></i>' +
                                            '</button>' +
                                            '</div>';
                                    }
                                },
                            ],
                            'columnDefs': [{
                                "targets": 5,
                                "className": "text-center",
                            }]
                        });
                    } else {
                        swal({
                            title: "Oops...",
                            text: message,
                            type: "error",
                            icon: "error",
                            timer: 2000
                        });
                        //showAlertMessage(0, err);
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
                    //showAlertMessage(0, err);
                }
            });
        }

        function verify2fa(app_id) {

            swal({
                text: 'Enter Verification Code',
                content: "input",
                button: {
                    text: "OK",
                    closeModal: false,
                },
            }).then(verify_code => {

                if (verify_code === "") {
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
                                window.localStorage.setItem('user_token', 'Bearer ' + data.data.token);

                                is_swal_stop = 0;
                                deleteApp(app_id);

                            } else {
                                swal({
                                    text: message,
                                    icon: "warning",
                                    timer: 2000
                                });
                                //showAlertMessage(0, message);
                            }

                        } else {
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

        let is_swal_stop = 1;

        function deleteApp(app_id) {

            if (google2fa_enable == 1 && is_swal_stop == 1) {
                verify2fa(app_id);
                return;
            }
            is_swal_stop = 1;

            swal({
                title: "Delete confirmation",
                text: "Are you sure you want to delete this app?",
                type: "warning",
                buttons: [true, "Delete"],

            }).then(isConfirm => {

                if (isConfirm) {

                    $.ajax({
                        type: "POST",
                        url: '{{ url('api/deleteApp') }}',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader("Authorization", token);
                        },
                        data: JSON.stringify({
                            app_id: app_id
                        }),
                        success: function(data) {
                            let code = data.code;
                            let message = data.message;
                            if (code == 200) {
                                window.location = '{{ route('admin.app-details') }}';
                            } else {
                                swal({
                                    title: "Oops...",
                                    text: message,
                                    type: "error",
                                    icon: "error",
                                    timer: 2000
                                });
                                //showAlertMessage(0, err);
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
                            //showAlertMessage(0, err);
                        },
                    });

                }

            }).catch(err => {
                swal({
                    text: err,
                    icon: "error",
                    timer: 2000
                });
                //showAlertMessage(0, err);

            });
        }

        function setValueForEditModal(value) {

            let modelPassData = modelData.find((elem) => elem.app_id == value);
            let platform;
            if (modelPassData.platform == 'Android'){
                platform = 1;
            }else if (modelPassData.platform == 'iOS'){
                platform = 2;
            }else {
                platform = 3;
            }

            $("#myLargeModalLabel").text("Edit App");
            $("#app_name").attr("value", modelPassData.name);
            $("input[name=platform][value=" + platform + "]").prop("checked",true);
            $('#category option[value=' + modelPassData.category_id + ']').attr("selected", "selected");
            $("#package").attr("value", modelPassData.package_name);
            $("#play_store_url").attr("value", modelPassData.play_store_url);
            $("#app_store_url").attr("value", modelPassData.app_store_url);
            $("#you_tube_url").attr("value", modelPassData.youtube_url);
            $("#slug").attr("value", modelPassData.slug);
            $("#price").attr("value", modelPassData.price);
            $("#main_question").attr("value", modelPassData.main_question);
            $("#custom_message").attr("value", modelPassData.custom_message);
            $("#app_id").attr("value", value);
            $("#logo_id").attr({
                style: "max-height:200px; max-width:200px;",
                src: modelPassData.webp_thumbnail_image
            });
            $("#sendAppData").attr("onclick", "updateApp()").text("Edit");

            $("#pre-main-question").text(modelPassData.main_question);
            $("#pre-custom-message").text(modelPassData.custom_message);

            let questions = question_data.filter((elem) => elem.app_id == modelPassData.app_id);
            $("#question").val("");
            $("#add-question").hide();
            if (questions.length > 0) {

                for (var i = 0; i < questions.length; i++) {
                    if (i == 0) {
                        $("#question").val(`${questions[i].app_questions}`);
                        $("#add-question").show();
                    } else {
                        $('#dynamic_field').append('<div class="mb-3 row" id="row' + i + '">' +
                            '<label class="col-sm-2 col-form-label"></label>' +
                            '<div class="col-sm-10">' +
                            '<div class="input-group mb-3">' +
                            '<input type="text" class="form-control" id="' + i +
                            '" name="question_name[]" placeholder="Enter Question" value="' + questions[i]
                            .app_questions + '" required>' +
                            '<div class="input-group-append">' +
                            '<button class="btn btn-danger ms-3 remove-question" id="' + i +
                            '" type="button"><i class="icon-trash"></i></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    }

                }
            }
        }

        $('#AppModel').on('hidden.bs.modal', function(e) {

            $("#myLargeModalLabel").text("Add New App");
            $("#question").val("");
            $("#app_name").attr("value", "");
            $('input:radio[name=platform][value="1"]').click();
            $('#category option[value=1]').attr("selected", "selected");
            $("#package").attr("value", "");
            $("#play_store_url").attr("value", "");
            $("#app_store_url").attr("value", "");
            $("#you_tube_url").attr("value", "");
            $("#slug").attr("value", "");
            $("#price").attr("value", "");
            $("#main_question").attr("value", "");
            $("#custom_message").attr("value", "");
            $("#dynamic_field").html("");
            $("#logo_id").attr({
                style: "max-height:200px; max-width:200px;display: none",
                src: "#"
            });
            $("#sendAppData").attr("onclick", "addApp()").text("Add");

            $("#pre-main-question").text("");
            $("#pre-custom-message").text("");

        });

        function resetFrom() {

            //$("#myLargeModalLabel").text("Add New App");
            $("#app_name").attr("value", "");
            $('input:radio[name=platform][value="1"]').click();
            $('#category option[value=1]').attr("selected", "selected");
            $("#package").attr("value", "");
            $("#play_store_url").attr("value", "");
            $("#app_store_url").attr("value", "");
            $("#you_tube_url").attr("value", "");
            $("#slug").attr("value", "");
            $("#price").attr("value", "");
            $("#main_question").attr("value", "");
            $("#custom_message").attr("value", "");
            $("#dynamic_field").html("");
            $("#logo_id").attr({
                style: "max-height:200px; max-width:200px;display: none",
                src: "#"
            });
            //$("#sendAppData").attr("onclick", "addApp()").text("Add");

        }

        function switchToggleIsActive(data) {
            let is_checked = $(`#is_active${data}`).is(":checked");
            let modelPassData = modelData.find((elem) => elem.app_id == data);
            let slug = modelPassData.slug;
            let platform = (modelPassData.platform == 'Android') ? 1 : 2;
            let package_name = modelPassData.package_name;
            let status = is_checked == true ? 1 : 0;
            $.ajax({
                type: 'POST',
                url: '{{ url('/api/updateStatus') }}',
                beforeSend: function(xhr) {
                    //Include the bearer token in header
                    xhr.setRequestHeader("Authorization", token);
                },
                data: {
                    'is_active': status,
                    'app_id': data,
                    'slug': slug,
                    'platform' : platform,
                    'package_name' : package_name
                },
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        console.log(data);
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
                }
            });
        }

        function switchToggleIsPaid(data) {
            let is_checked = $(`#is_paid${data}`).is(":checked");
            let modelPassData = modelData.find((elem) => elem.app_id == data);
            let slug = modelPassData.slug;
            let platform = (modelPassData.platform == 'Android') ? 1 : 2;
            let package_name = modelPassData.package_name;
            let status = is_checked == true ? 1 : 0;
            $.ajax({
                type: 'POST',
                url: '{{ url('/api/updateStatus') }}',
                beforeSend: function(xhr) {
                    //Include the bearer token in header
                    xhr.setRequestHeader("Authorization", token);
                },
                data: {
                    'is_paid': status,
                    'app_id': data,
                    'slug': slug,
                    'platform' : platform,
                    'package_name' : package_name
                },
                success: function(data) {
                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        console.log(data);
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
                }
            });
        }

    </script>
@endsection
