@extends('admin.layouts.master')

@section('title')
    OB-Testimonial | Redis Cache
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Redis keys</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Redis-Keys</li>
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
                                <div class="input-group">
                                    <input class="form-control search-keys" type="text" placeholder="Search key..."
                                        aria-label="Search key...">
                                    <span class="input-group-text total-keys" id="total-keys">Keys : N/A</span>
                                    <span class="input-group-text delete-keys" id="delete-keys"
                                        style="cursor:pointer;color: red;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table class="table table-xl" id="redis-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Key Name</th>
                                                        <th>
                                                            <div class="form-check checkbox checkbox-primary mb-0">
                                                                <input name="type" class="form-check-input"
                                                                    id="checkbox-primary-all" type="checkbox"
                                                                    data-bs-original-title="" title="">
                                                                <label class="form-check-label"
                                                                    for="checkbox-primary-all"></label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="redis-table-data">
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
    </div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                type: "POST",
                url: '{{ url('api/getRedisKeys') }}',
                beforeSend: function(xhr) {
                    //Include the bearer token in header
                    xhr.setRequestHeader("Authorization", token);
                },
                success: function(data) {

                    let code = data.code;
                    let message = data.message;
                    if (code == 200) {

                        for (let i = 0; i < data.data.length; i++) {
                            let element = data.data[i];
                            $("#redis-table-data").append(
                                `<tr>` +
                                `<td>${i + 1}</td>` +
                                `<td>${element}</td>` +
                                `<td><div class='form-check checkbox checkbox-primary mb-0'><input name='type' class='form-check-input redis-check-all' value="${element}" id='checkbox-primary-${i}' type='checkbox' data-bs-original-title='' title=''> <label class='form-check-label' for='checkbox-primary-${i}'></label></div></td>` +
                                `</tr>`
                            );
                        }

                        document.getElementsByClassName('total-keys')[0].innerHTML = "Keys : " + data
                            .data.length;

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

            $(".search-keys").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#redis-table-data tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#checkbox-primary-all").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $("#delete-keys").click(function() {
                //$("#delete-keys").on("click", function(e) {

                let redisValueArray = [];
                let inputElements = document.querySelectorAll('.redis-check-all:checked');
                for (let i = 0; i < inputElements.length; i++) {
                    redisValueArray.push(inputElements[i].value);
                }

                if (redisValueArray.length <= 0) {
                    swal({
                        text: "Please select atleast one key to delete",
                        icon: "error",
                        timer: 2000
                    });
                    return;
                }

                // else if(confirm("Are you sure you want to delete cache keys?") == false){
                //     return;
                // }
                else {
                    swal({
                        title: "Delete confirmation",
                        text: "Are you sure you want to delete cache keys?",
                        type: "warning",
                        buttons: [true, "Delete"],

                    }).then(isConfirm => {

                        if (isConfirm) {

                            $.ajax({
                                type: "POST",
                                url: '{{ url('api/deleteRedisKeys') }}',
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader("Authorization", token);
                                },
                                data: JSON.stringify({
                                    keys_list: redisValueArray
                                }),
                                success: function(data) {
                                    let code = data.code;
                                    let message = data.message;
                                    if (code == 200) {
                                        window.location =
                                            '{{ route('admin.redis-cache') }}';
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
                                        text: err.responseJSON.message ? err
                                            .responseJSON.message :
                                            'Bad request Call....',
                                        type: "error",
                                        icon: "error",
                                        timer: 2000
                                    });
                                },
                            });

                        }

                    }).catch(err => {
                        swal({
                            title: "Oops...",
                            text: err.responseJSON.message ? err.responseJSON.message :
                                'Bad request Call....',
                            type: "error",
                            icon: "error",
                            timer: 2000
                        });
                    });
                }
            });
        });
    </script>
@endsection
