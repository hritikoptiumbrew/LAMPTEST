@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Image Details
@endsection
@section('extra-css')
    <style>
        #track-tbl {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #track-tbl td, #track-tbl th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #track-tbl tr:nth-child(even){background-color: #f2f2f2;}

        #track-tbl tr:hover {background-color: #ddd;}

        #track-tbl th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #3fbcd7;
            color: white;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="page-body">

        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>QR Details</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/admin/home')}}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">QR-Details</li>
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
                                                <th>Total Scan</th>
                                                <th>Total Update</th>
                                                <th>Total Page</th>
                                                <th>Content Type</th>
                                                <th>Last Scan At</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Scan Count Per Day</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                            data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <div class="card-body" >
                        <div class="row">
                            <div class="text-center w-100" id="image_design">
                                <table id="track-tbl">
                                    <tr>
                                        <th>Date</th>
                                        <th>Count</th>
                                    </tr>
                                    <tbody id="scan_result">

                                    </tbody>
                                </table>
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
        let suid = window.location.pathname.split("/").pop();
        $.ajax({
            type: "POST",
            url: '{{url('getUserQrDetails')}}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                suid: suid,
            }),
            success: function (data) {

                let code = data.code;
                let message = data.message;
                if (code == 200) {
                    qr_scan_data = data.data.scan_details;

                    $("#ajax-data-object").dataTable().fnDestroy();
                    let table = $('#ajax-data-object').DataTable({

                        "pageLength": 50,
                        "deferRender": true,
                        data: data.data.image_details,
                        rowCallback: function (row, data, index) {
                            if (data.is_debug == 1) {
                                $(row).filter('tr').css('color', '#808080');
                            }
                        },
                        columns: [
                            {
                                "data": null,
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                }
                            },
                            {
                                "data": "qr_id",
                                "render": function (data, type, row) {
                                    return `<a href="${row.qr_url}" target="_blank"> <img src="${row.preview_image}" style="max-height:100px; max-width:100px"></a>`;
                                }
                            },
                            {"data": "user_name"},
                            {"data": "name"},
                            {"data": "platform"},
                            {
                                "data": "qr_id", "width": "5%",
                                "render": function (data, type, row) {
                                    if (row.scan_count === 0) {
                                        return `<div class="btn-group">
                                                    <button class="btn btn-primary btn-lg images-modal" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" onclick="setScanCountInModel('${data}')" data-bs-original-title="" style="border-radius: 10px" disabled>${row.scan_count}</button>
                                                </div>`;
                                    } else {
                                        return `<div class="btn-group">
                                                    <button class="btn btn-primary btn-lg images-modal" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" onclick="setScanCountInModel('${data}')" data-bs-original-title="" style="border-radius: 10px">${row.scan_count}</button>
                                                </div>`;
                                    }
                                }
                            },
                            {"data": "update_count"},
                            {"data": "total_pages"},
                            {"data": "content_type"},
                            {"data": "last_scan_at"},
                            {"data": "created_at"},
                            {"data": "updated_at"},
                        ],
                    });

                } else {
                    swal({text: message, icon: "error", timer: 2000});
                    //showAlertMessage(0, err);
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
                //showAlertMessage(0, err);
            },
        });

        function setScanCountInModel(id) {
            $("#scan_result").html("");
            let qr = qr_scan_data.filter((elem) => elem.qr_id == id);
            if (qr.length > 0) {
                for (var i = 0; i < qr.length; i++) {
                    $("#scan_result").append(`<tr><td>${qr[i].scan_date}</td><td>${qr[i].total_scan}</td></tr>`)
                    // $("#image_design").append(`<p style="font-size: 30px">${x.scan_date} => ${x.total_scan}<p><hr>`);
                }
            } else {
                $("#scan_count").html('');
            }
        }

    </script>
@endsection
