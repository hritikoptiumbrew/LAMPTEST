<!-- latest jquery-->
<script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{asset('assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/moment.min.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js')}}"></script>
<script src="{{asset('assets/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
@yield('dropzone-js')
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/js/script.js')}}"></script>

<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
{{--<script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>--}}
@yield('extra-script')

<script>

    function showAlertMessage(is_success, message) {
        if (is_success === 1) {
            document.getElementsByClassName('success-message')[0].style.display = 'block';
            document.getElementsByClassName('success-message-text')[0].innerHTML = message;
            setTimeout(function () {
                document.getElementsByClassName('success-message')[0].style.display = 'none';
            }, 2000);
        } else {
            document.getElementsByClassName('error-message')[0].style.display = 'block';
            document.getElementsByClassName('error-message-text')[0].innerHTML = message;
            setTimeout(function () {
                document.getElementsByClassName('error-message')[0].style.display = 'none';
            }, 2000);
        }
    }

    $('#logout').click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{url('api/doLogout')}}',
            beforeSend: function (xhr) {
                //Include the bearer token in header
                xhr.setRequestHeader("Authorization", token);
            },
            success: function (data) {
                localStorage.clear();
                window.location = '{{route('admin.login')}}';
            },
            error: function (err) {
                swal({text: err, icon: "error", timer: 2000});
                //showAlertMessage(0, err);
            },
        });
    });

    $("#dark-mode-enable").click(function (e) {

        let is_dark_mode_enable = localStorage.getItem("is_dark_mode_enable");

        if (is_dark_mode_enable == 0 || is_dark_mode_enable == null) {
            window.localStorage.setItem('is_dark_mode_enable', 1);

        } else {
            window.localStorage.setItem('is_dark_mode_enable', 0);
        }

    });

    if (is_dark_mode_enable == 1) {
        document.getElementById("dark-mode-enable").className = "fa fa-lightbulb-o";
    }

    $("#email-id").text(user_detail.email);
    $("#user-name").text(user_detail.email);

    if(role_id == 3){
        $("#app-details").hide();
        $("#redis-cache").hide();
        $("#settings").hide();
    }

</script>
