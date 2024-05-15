@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Users
@endsection
@section('extra-css')
    <style>
        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
    </style>
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Users</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Users</li>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="ajax-data-object_wrapper" class="dataTables_wrapper">
                                        <table class="display datatables dataTable" id="users-table" role="grid"
                                            aria-describedby="ajax-data-object_info" style="width: 1173px;">
                                            <thead>
                                                <tr role="row">
                                                    <th> Id </th>
                                                    <th> App Name </th>
                                                    <th> Email </th>
                                                    <th> Created At </th>
                                                    <th> Updated At </th>
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
    <div class="modal fade bd-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Folders Name</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                        data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="text-center w-100" id="folders-name">
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
                    <h4 class="modal-title" id="myLargeModalLabel">User Resources</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                        data-bs-original-title="" title=""></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="text-center w-100" id="image_design">
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
        getAllUsersByAdmin();
        let users_data = [];

        function getAllUsersByAdmin() {

            $.ajax({
                type: "POST",
                url: '{{ url('api/getAllUsersByAdmin') }}',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", token);
                },
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {
                        users_data = data.data.result;
                        $("#users-table").dataTable().fnDestroy();
                        let table = $('#users-table').DataTable({
                            "order": [
                                [0, 'desc']
                            ],
                            data: users_data,
                            columns: [{
                                    "data": "user_id",
                                    "width": "10%"
                                },
                                {
                                    "data": "app_name"
                                },
                                {
                                    "data": "email"
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
                            ],
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
                    showAlertMessage(0, err);
                },
            });
        }

        function setFoldersNameInModel(id) {
            let data = users_data.find((elem) => elem.user_id == id);
            if (data.folders_name) {
                $("#folders-name").html('');
                let folders_name = data.folders_name.split(',');
                for (var i = 0; i < folders_name.length; i++) {
                    $('#folders-name').append(
                        '<div class="p-3 mb-2 bg-secondary text-white">' + folders_name[i] + '</div>');
                }
            } else {
                $("#folders-name").html('');
            }
        }

        function setUserResourcesInModel(id) {
            let resource_data = users_data.find((elem) => elem.user_id == id);
            let users_resource = resource_data.users_resource;
            let path = '{{ config('constants.ORIGINAL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN') }}';
            $('#image_design').html('');
            for (var i = 0; i < users_resource.length; i++) {
                $('#image_design').append(
                    '<a href="' + path + users_resource[i].file +
                    '" itemprop="contentUrl" data-size="1600x950" data-bs-original-title="" title="">' +
                    '<img class="d-block m-auto mw-100 h-auto" src="' + path + users_resource[i].file +
                    '" itemprop="thumbnail" alt="Image description" style="padding-bottom: 20px">');
            }
        }
    </script>
@endsection
