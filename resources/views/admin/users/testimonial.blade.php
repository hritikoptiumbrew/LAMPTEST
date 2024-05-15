<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/css/testimonial/style.css?1')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sweetalert2.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Pattaya&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ $data[0]->preview_image }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $data[0]->preview_image }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $data[0]->app_name }}</title>
</head>

<body onbeforeunload="return myFunction()" style="width:100%;background: #F6F8F9;">
<div class="show-view" style="position: absolute; top:0;left:0;right:0;background: #ffffff;">
    <!-- ..........position-fixed............. -->
    <div id="subPage" class="d-none">
        <!-- <div style="width: 100%;height: 100%;background: rgba(0,0,0,0.5);position: absolute;z-index: 999;"></div> -->
        <div class="text-center">
            <div class="d-flex justify-content-center" style="padding-top: 20px !important;">
                <!-- <img src="https://d33r26vb2a4c28.cloudfront.net/photoadking-test/temp/63317c5314e69_my_design_1664187475.png" alt=""> -->
            </div>
            <h4 class="record-heading">Review your video</h4>
            <p class="record-subheading c-record-subheading">Please fill out all the required fields to proceed.</p>
        </div>
        <div class="d-flex justify-content-center my-vid-con">
            <video id="my-video" class="video-js vjs-theme-city mw-100 vjs-16-9" controls>
                <source
                    src="https://player.vimeo.com/external/353539377.sd.mp4?s=fa4823ac540c8484ddbbcd6b0f8e9128fd2887f5&profile_id=165&oauth2_token_id=57447761"/>
            </video>
        </div>

        <label class="form-control text-center c-n-input-box"onclick="recordAgain()"><span>Record Again</span></label>


        <form class="px-3" id="feedback-form">
            <div class="form-group">
                <label for="name" class="input-name">Your Name<span
                        style="color: #FF5E5E;font-family: 'Inter-Medium';">*</span></label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                       placeholder="" onblur="validInput('text','name','pname','false')" oninput="validInput('text','name','pname','true')">
                <p class="em d-none" style="color:#FF5E5E;font-size:13px;display: flex;align-items: center;margin-top: 5px;" id="pname">
                <img src="{{asset('assets/images/testimonial/danger.svg')}}" alt="">
                <span style="margin-left: 5px;margin-top: 3px;" class="errormassage">Please enter your name.</span>
                </p>
            </div>
            <div class="form-group">
                <label for="email" class="input-name">Email<span style="color: #FF5E5E;font-family: 'Inter-Medium';">*</span></label>
                <input type="email" class="form-control"  onblur="validInput('email','email','eid','false')" oninput="validInput('email','email','eid','true')" id="email" name="email" aria-describedby="emailHelp"
                       placeholder="" >
                <p id="eid" class="em d-none" style="color:#FF5E5E;font-size:13px;display: flex;align-items: center;margin-top: 5px;" >
                <img src="{{asset('assets/images/testimonial/danger.svg')}}" alt="">
                <span style="margin-left: 5px;margin-top: 3px;" class="errormassage"></span>
                </p>
            </div>
            <div class="form-group">
                <label for="designation" class="input-name">Designations<span
                style="color: #FF5E5E;font-family: 'Inter-Medium';">*</span></label>
                <input type="text" class="form-control" onblur="validInput('text','designation','desid','false')" oninput="validInput('text','designation','desid','true')" id="designation" name="designation" aria-describedby="emailHelp"
                       placeholder="" >
                <p id="desid" class="em d-none" style="color:#FF5E5E;font-size:13px;display: flex;align-items: center;margin-top: 5px;" >
                <img src="{{asset('assets/images/testimonial/danger.svg')}}" alt="">
                <span style="margin-left: 5px;margin-top: 3px;" class="errormassage">Please enter your designation.</span>
                </p>
            </div>
            <div class="form-group position-relative">
                <label for="country" class="input-name">Choose Your Country<span
                style="color: #FF5E5E;font-family: 'Inter-Medium';">*</span></label>
                <select id="country" onblur="validInput('select','country','cid','false')" onchange="validInput('select','country','cid','true')" class="form-control" name="country" >
                    <option value="" selected>Select country</option>
                    <!-- <option value="india">India</option>
                    <option value="afghanistan">Afganistan</option>
                    <option value="albania">Albania</option>
                    <option value="alegeria">Alegeria</option>
                    <option value="angola">Angola</option> -->
                </select>
                <img src="{{asset('assets/images/testimonial/Polygon.svg')}}" alt="" class="carrat-custom">
                <p id="cid" class="em d-none" style="color:#FF5E5E;font-size:13px;display: flex;align-items: center;margin-top: 5px;" >
                <img src="{{asset('assets/images/testimonial/danger.svg')}}" alt="">
                <span style="margin-left: 5px;margin-top: 3px;" class="errormassage">Please select your country.</span>
                </p>
            </div>
            <div class="form-group">
                <div class="form-check d-flex" style="align-items: center;">
                    <input class="form-check-input" type="checkbox" value="" onblur="validInput('chkbox','invalidCheck','checkid','false')" onchange="validInput('chkbox','invalidCheck','checkid','true')" id="invalidCheck" required
                           style="width: 20px; height: 20px;accent-color: #000000;border: 1px solid #ff5e5e;">
                    <label class="form-check-label permission-text" for="invalidCheck"
                           style="position: relative;top: 3px;">
                        I give permission to use this testimonial across social channels and other marketing efforts
                    </label>
                    <div class="invalid-feedback">
                        You must agree before submitting.
                    </div>
                </div>
                <p id="checkid" class="em d-none" style="color:#FF5E5E;font-size:13px;display: flex;align-items: center;margin-top: 5px;" >
                <img src="{{asset('assets/images/testimonial/danger.svg')}}" alt="">
                <span style="margin-left: 5px;margin-top: 3px;" class="errormassage">Please give permission.</span>
                </p>
            </div>

        </form>
        <div class="form-cm" style="padding: 8px 15px 10px;background-color: #ffffff;bottom: 0;width: 100%;">
            <button class="recorder-btn btn ripple" onclick="checkvalidate()">
                Confirm to Submit
                <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
            </button>
        </div>
        <!-- <div style="padding: 8px 15px 10px;background-color: #ffffff;bottom: 0;width: 100%;">
            <button class="recorder-btn btn ripple" style="background-color: #ffffff; color: rgba(0,0,0,0.5);"
                    onclick="recordAgain()">
                Record Again
            </button>
        </div> -->
        <!-- <div class="box-setup">
        <div class="upload-box">
            <div class="d-flex justify-content-center text-center">
                <div class="upload-video">
                    <div class="circular-progress">
                        <span class="progress-value">75%</span>
                    </div>
                </div>
            </div>
            <h4 class="uploading-heading">Uploading your video...</h4>
            <p class="uploading-text">Your video is being uploaded. Please do not close the page.</p>

        </div>
    </div> -->
    <!-- <div class="box-setup" style="top: 135px;">
        <div class="upload-box">
            <div class="text-center">
                <p class="uploading-text">Successfully uploaded.</p>
                <div>
                    <img src="{{asset('assets/images/testimonial/thankyou.svg')}}')}}'" alt="">
                </div>

            </div>
            <p class="uploading-text" style="margin-top: 22px;">Thank you so much for your review! It means a ton for us!</p>
            <div style="padding: 0px 15px 10px;background-color: #ffffff;bottom: 0;width: 100%;">
                <button class="recorder-btn" style="background-color: #ffffff; color: rgba(0,0,0,0.5);border: 1px solid rgba(0,0,0,0.2);">
                    Close
                </button>
            </div>
        </div>
    </div> -->
    </div>
    <div class="main-page" style="max-width: 600px;padding: 0 33px;" id="mainPage">

        <div>
            @if($data[0]->is_paid == 1)
                <header>
                    <div class="hurryup d-flex">
                        <div class="gift-section">
                            <img class="hurryup-img" src="{{asset('assets/images/testimonial/gift.svg')}}" alt="">
                        </div>
                        <div class="gift-writting">
                            <h2 class="main-heading">Hurry up!</h2>
                            <h3 class="main-sub-heading">Give a Review,<span style="color:#0034C8;font-weight: 800;font-family: 'Inter-ExtraBold';"> Get ${{$data[0]->price}}.</span></h3>
                            <p class="side-text"><a href="{{url('terms-and-conditions')}}" target="_blank">T&C Apply</a></p>
                        </div>
                    </div>
                </header>
            @endif
            <main>

           <div class="d-flex justify-content-center position-relative px-3" style="align-items: flex-start;">
               @if($data[0]->youtube_url == null)
                    <div class="iframe-container">
                        <img class="mw-100" style="margin-top: 19px;width: 568px;"  src="{{$data[0]->header_image}}" alt="">
                    </div>
                @else
                    <div class="iframe-container">
                        <iframe id="videoId" class="mw-100" style="margin-top: 19px;" src="{{$data[0]->youtube_url}}?enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>
                    </div>
               @endif
                    {{--                    <img class="mw-100 pt-3 px-3" src="https://32b9-49-36-83-112.ngrok.io/ob_testimonial/public/assets/images/testimonial/video.jpg" alt="">--}}
                    @if(!empty($data[0]->preview_image))
                       <img class="c-logo-set" style="border: 1.5px solid #ffffff;;border-radius: 9px;width:41.4px;height: 41.4px;"
                             src="{{$data[0]->preview_image}}" alt="">
                    @endif
                </div>
                <p class="video-text">{{ $data[0]->main_question }}
                <!-- svg image emoji -->

                </p>
                <P class="point-hints text-center c-pedding">{!! $data[0]->custom_message !!}</P>

                <!-- ........ -->
                <div style="padding-bottom: 65px;">
                    <h4 class="border-type">HINTS OF REVIEW</h4>
                    <ul class="point-hints">
                        @foreach ($data[0]->apps_question_details as $question)
                            <li>{!! $question->name !!}</li>
                        @endforeach
                    </ul>
                </div>
            </main>
        </div>
        <!-- ........ -->
        <footer style="bottom: 0;">
            <div class="btn_implement btn-space"
                 id="dialogFirst">
                <button class="recorder-btn btn ripple" onclick="conditionalFunction()">
                    <img class="recorderimg" src="{{asset('assets/images/testimonial/recorder.svg')}}" alt="">
                    Record a Video
                    <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
                </button>
            </div>

        </footer>
    </div>
    <div style="margin-top: 30px;" id="recordPage" class="d-none">
        <h4 class="border-type">HINTS OF REVIEW</h4>
        <ul class="point-hints mb-0">
            @foreach ($data[0]->apps_question_details as $question)
                <li>{!! $question->name !!}</li>
            @endforeach
        </ul>
        <div style="padding: 23px 15px 0px 15px; position:relative" id="videorccon">
        <!-- <img src="{{asset('images/testimonial/girls.png')}}" alt="" class="girls-img"> -->
            <p class="ready-cnt d-none" id="readyCnt">3</p>

            <div style="position: relative; line-height: 0;">

            <video id="recordVideo" class="mw-100" style="transform: rotateY(180deg);" onloadeddata="videoload()"></video>
            <div class="overLay-web">
                <div class="overlay-div-first">

                </div>
                <div class="overlay-div-second">

                </div>

                <div class="overlay-div-first-after">

                </div>
                <span class="before-video  second-before-done">Please align your face to the guide</span>
                <span class="after-video  second-after-done">Please align your face to the guide</span>
            </div>
            </div>

            <div class="record-btn">
                <div class="d-flex">
                    <span class="red-btn" id="redTimer" hidden></span>
                    <div class="start-btn " id="timer">Start</div>
                    <div class="record-small-btn" id="startButton" onclick="checkFotStartOrStopRecording()"></div>
                </div>
            </div>
        </div>
        <div id="safariVideoCon" class="d-none">
        <div class="d-flex justify-content-center pt-2">
                <img src="{{asset('assets/images/testimonial/record.svg')}}" alt="">
            </div>

            <h4 class="record-heading mb-3">Record a Video</h4>
            <p class="record-subheading record-font-size mb-0" style="color: #e40000;" id="safariErrorMsg"></p>
            <p class="record-subheading record-font-size">You have up to <span class="secId">240</span> seconds to record your video. Don’t worry: You can
                review
                your video before submitting it, and you can re-record if needed.</p>
            <div class="input-group mb-3 px-3">
                <!-- <input type="text" class="form-control text-center c-input-box" placeholder="Choose a File to Submit "
                aria-label="Choose a File to Submit" aria-describedby="basic-addon2"> -->
                <label for="file-upload-new" id="safChoose" class="form-control d-none text-center c-input-box"><span>Choose a File to
                  Submit</span></label>
                <input id="file-upload-new" type="file" class="d-none" accept="video/*"
                       onchange="checkSafariFileInfo(event,'file-upload-new','safariErrorMsg')"/>
                <input id="file-upload-new-capture" capture="camcorder" type="file" class="d-none" accept="video/*"
                       onchange="checkSafariFileInfo(event,'file-upload-new-capture','safariErrorMsg')"/>
                <label for="file-upload-new-capture" class="recorder-btn btn ripple">
                    <span>
                        <img class="recorderimg" src="{{asset('assets/images/testimonial/recorder.svg')}}" alt="">
                            Start Recording
                        <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
                    </span>
                </label>
            </div>
        </div>
    </div>

</div>
<div class="overlay" id="overLayBack">
    <div class="record-video-box text-center" style="max-width: 600px;margin: auto;left: 0;right: 0;" id="dialogSecond">
        <div id="normalDialog">
            <img style="position: absolute;right: 14px;top: 16px;"
                 src="{{asset('assets/images/testimonial/close.svg')}}" alt=""
                 onclick="hideDialog('#dialogSecond')">
            <div class="d-flex justify-content-center pt-2">
                <img src="{{asset('assets/images/testimonial/record.svg')}}" alt="">
            </div>

            <h4 class="record-heading mb-3">Record a video</h4>
            <p class="record-subheading mb-0 record-font-size mb-3" style="color: #FF5E5E;" id="errorMsg"></p>
            <p class="record-subheading record-font-size">You have up to <span class="secId">240</span> seconds to record your video. Don’t worry: You can
                review
                your video before submitting it, and you can re-record if needed.</p>
            <div class="input-group mb-3 px-3">
                <!-- <input type="text" class="form-control text-center c-input-box" placeholder="Choose a File to Submit "
                aria-label="Choose a File to Submit" aria-describedby="basic-addon2"> -->
                <label for="file-upload" class="form-control text-center c-input-box"><span>Choose a File to
                  Submit</span></label>
                <input id="file-upload" type="file" class="d-none" accept="video/*"
                       onchange="checkFileCallInfo(event,'file-upload','errorMsg')"/>
                <button class="recorder-btn btn ripple" onclick="captureCamera()">
                    Record My Video
                    <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
                </button>
                <!-- <button class="recorder-btn btn ripple" onclick="captureCamera()">
                    Record My Video
                    <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}"
                         alt="">
                </button> -->
            </div>
        </div>
        <div id="acessDialog" class="d-none">
            <img style="position: absolute;right: 14px;top: 16px;"
                 src="{{asset('assets/images/testimonial/close.svg')}}" alt=""
                 onclick="hideDialog('#dialogSecond')">
            <div class="d-flex justify-content-center pt-2">
                <img src="{{asset('assets/images/testimonial/record.svg')}}" alt="">
            </div>
            <h4 class="record-heading mb-3">Record a video</h4>
            <p class="record-subheading mb-0 record-font-size mb-3" style="color: #FF5E5E;" id="errorMsgNew"></p>
            <p class="record-subheading record-font-size">You have up to <span class="secId">240</span> seconds to record your video. Don’t worry: You can
                review
                your video before submitting it, and you can re-record if needed.</p>
            <div class="input-group mb-3 px-3">
                <label class="recorder-btn btn ripple" for="file-upload">
                <span>
                  Choose a File to Submit
                  <img class="pl-1 rightaarow" src="{{asset('assets/images/testimonial/rightaarow.svg')}}" alt="">
                </span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="box-setup d-none" id="loader" style="max-width: 600px;">
    <div class="upload-box">
        <div class="d-flex justify-content-center text-center">
            <div class="upload-video">
                <div class="circular-progress" id="circProgress">
                    <span class="progress-value">0%</span>
                </div>
            </div>
        </div>
        <h4 class="uploading-heading">Uploading your video...</h4>
        <p class="uploading-text thank-you-screen">Your video is being uploaded. Please do not close the page.</p>

    </div>
</div>

<div class="box-setup d-none" id="thank-loader" style="max-width: 600px;">
    <div class="upload-box">
        <div class="text-center">
            <p class="uploading-text">Successfully uploaded.</p>
            <div>
                <img src="{{asset('assets/images/testimonial/thankyou.svg')}}" width="200px" alt="">
            </div>

        </div>
        <p class="uploading-text thank-you-screen">Thank you so much for your review! It means a ton for
            us!

            <svg height="12" viewBox="0 0 60 61" width="12" xmlns="http://www.w3.org/2000/svg">
                <g id="Page-1" fill="none" fill-rule="evenodd">
                    <g id="045---Prayer-Hands" fill-rule="nonzero" transform="translate(0 -1)">
                        <path id="Shape"
                              d="m30 10.32v36.68c0 6-2 7-4 8-1.0922703.5166441-2.1029938 1.1904597-3 2-.33 0-.66-.01-.97-.02-9.1-.51-10.03-7.98-10.03-7.98 9-5 8-13 8-17 .1425396-2.395334.8927856-4.7149021 2.18-6.74.5419923-.909108.8766203-1.9266503.98-2.98l.72-7.91 1.59-4.78c.2604197-.77579298.9101346-1.35711692 1.71-1.53.1636109-.040235.3315149-.06038349.5-.06 1.2808436.00110275 2.3188972 1.03915643 2.32 2.32z"
                              fill="#f9c795"/>
                        <path id="Shape"
                              d="m29 10.32v36.68c0 6-2 7-4 8-1.079554.5146419-2.0797328 1.1814278-2.97 1.98-9.1-.51-10.03-7.98-10.03-7.98 9-5 8-13 8-17 .1425396-2.395334.8927856-4.7149021 2.18-6.74.5419923-.909108.8766203-1.9266503.98-2.98l.72-7.91 1.59-4.78c.2604197-.77579298.9101346-1.35711692 1.71-1.53 1.0635856.23008297 1.8219708 1.17181406 1.82 2.26z"
                              fill="#fdd7ad"/>
                        <path id="Shape"
                              d="m27.18 8.06c-.6316855.13793665-1.1761382.53538712-1.5 1.095.2085755.35287945.3190537.75508935.32 1.165v36.68c0 6-2 7-4 8-.896987.4433523-1.7449653.9796232-2.53 1.6.8398934.2053389 1.696786.3335381 2.56.383.8900743-.7996307 1.8902627-1.4674333 2.97-1.983 2-1 4-2 4-8v-36.68c.0019708-1.08818594-.7564144-2.02991703-1.82-2.26z"
                              fill="#dfc49c"/>
                        <path id="Shape"
                              d="m30 4.61v5.71c-.0035544-1.13852618-.8310614-2.10699336-1.9550919-2.28812852-1.1240305-.18113515-2.2138792.47835417-2.5749081 1.55812852l-1.59 4.78.9-9.99c.1148793-1.35324022 1.2519299-2.39009091 2.61-2.38 1.4410061.00110295 2.608897 1.16899391 2.61 2.61z"
                              fill="#f9c795"/>
                        <path id="Shape"
                              d="m23 57v1.01c.0000138 1.100676-.8893377 1.9944966-1.99 2l-18 .07c-.53216349.0026609-1.04344411-.2068776-1.42068246-.5822391-.37723835-.3753616-.58932419-.8855908-.58931754-1.4177609v-4.93c.0016555-.7293244.40018405-1.3999253 1.04-1.75 2.77155361-1.5198081 5.65292849-2.8301317 8.62-3.92.3063999-.1107754.6475555-.0653389.9142822.1217679s.4255792.4924222.4257178.8182321v.58s1 8 11 8z"
                              fill="#02a9f4"/>
                        <path id="Shape"
                              d="m36.12 14.37-1.59-4.78c-.3610289-1.07977435-1.4508776-1.73926367-2.5749081-1.55812852-1.1240305.18113516-1.9515375 1.14960234-1.9550919 2.28812852v-5.71c.001103-1.44100609 1.1689939-2.60889705 2.61-2.61 1.3580701-.01009091 2.4951207 1.02675978 2.61 2.38z"
                              fill="#f9c795"/>
                        <path id="Shape"
                              d="m48 49s-.93 7.47-10.03 7.98c-.31.01-.64.02-.97.02-.8970062-.8095403-1.9077297-1.4833559-3-2-2-1-4-2-4-8v-36.68c.0011028-1.28084357 1.0391564-2.31889725 2.32-2.32.1684851-.00038349.3363891.019765.5.06.7998654.17288308 1.4495803.75420702 1.71 1.53l1.59 4.78.72 7.91c.1033797 1.0533497.4380077 2.070892.98 2.98 1.2872144 2.0250979 2.0374604 4.344666 2.18 6.74 0 4-1 12 8 17z"
                              fill="#f9c795"/>
                        <path id="Shape"
                              d="m48 49s-.93 7.47-10.03 7.98c-.8902672-.7985722-1.890446-1.4653581-2.97-1.98-2-1-4-2-4-8v-36.68c-.0019708-1.08818594.7564144-2.02991703 1.82-2.26.7998654.17288308 1.4495803.75420702 1.71 1.53l1.59 4.78.72 7.91c.1033797 1.0533497.4380077 2.070892.98 2.98 1.2872144 2.0250979 2.0374604 4.344666 2.18 6.74 0 4-1 12 8 17z"
                              fill="#fdd7ad"/>
                        <path id="Shape"
                              d="m40 32c-.1425396-2.395334-.8927856-4.7149021-2.18-6.74-.5419923-.909108-.8766203-1.9266503-.98-2.98l-.72-7.91-1.59-4.78c-.2604197-.77579298-.9101346-1.35711692-1.71-1.53-.6316855.13793665-1.1761382.53538712-1.5 1.095.0857849.13743195.1574815.28317033.214.435l1.59 4.78.72 7.91c.1033797 1.0533497.4380077 2.070892.98 2.98 1.2858043 2.0254838 2.0346653 4.3450257 2.176 6.74 0 4-1 12 8 17-.7136958 3.816225-3.6666553 6.8205747-7.47 7.6.231.188.384.327.44.383 9.1-.513 10.03-7.983 10.03-7.983-9-5-8-13-8-17z"
                              fill="#dfc49c"/>
                        <path id="Shape"
                              d="m59 53.15v4.93c.0000067.5321701-.2120792 1.0423993-.5893175 1.4177609-.3772384.3753615-.888519.5849-1.4206825.5822391l-18-.07c-1.1006623-.0055034-1.9900138-.899324-1.99-2v-1.01c10 0 11-8 11-8v-.58c.0001386-.3258099.1589911-.6311253.4257178-.8182321s.6078823-.2325433.9142822-.1217679c2.9670715 1.0898683 5.8484464 2.4001919 8.62 3.92.639816.3500747 1.0383445 1.0206756 1.04 1.75z"
                              fill="#02a9f4"/>
                        <path id="Shape"
                              d="m58.448 50.525c-2.81871-1.5393283-5.746178-2.8705425-8.759-3.983-.9016351-.3449977-1.9201975.0182895-2.4.856-6.489-4.261-6.383-10.243-6.304-14.278.008-.4.015-.774.015-1.12-.134679-2.5764092-.933184-5.0742347-2.318-7.251-.4696419-.7806714-.7577469-1.656948-.843-2.564l-1.627-17.9c-.1223969-1.41520434-1.0655358-2.62612243-2.4076966-3.09129827-1.3421609-.46517584-2.8323761-.09762724-3.8043034.93829827-.9720602-1.03600053-2.4624815-1.40346096-3.8047131-.93804453s-2.2852388 1.67666387-2.4072869 3.09204453l-1.627 17.9c-.0852531.907052-.3733581 1.7833286-.843 2.564-1.3846523 2.1764739-2.1831506 4.673934-2.318 7.25 0 .346.007.72.015 1.12.079 4.035.187 10.017-6.307 14.277-.4809859-.836301-1.4985945-1.198824-2.4-.855-3.01216799 1.1132622-5.93924577 2.4444509-8.758 3.983-.95341121.5317378-1.54592775 1.53634-1.55 2.628v4.927c0 1.6568542 1.34314575 3 3 3h.014l18-.072c1.6511876-.009335 2.9857306-1.3487892 2.989-3v-.555c.7536214-.6079995 1.5734809-1.1289658 2.444-1.553 1.5375043-.5987372 2.8017796-1.7409617 3.553-3.21.7512204 1.4690383 2.0154957 2.6112628 3.553 3.21.8713326.4238502 1.69217.9444631 2.447 1.552v.556c.0032655 1.6508231 1.3372032 2.990118 2.988 3l18 .072h.012c1.6568542 0 3-1.3431458 3-3v-4.927c-.0040547-1.0921961-.5975111-2.0970953-1.552-2.628zm-25.835-47.525c.8363265-.00409366 1.5356218.63471496 1.607 1.468l.307 3.379c-.961454-.86669203-2.3414874-1.08971984-3.527-.57v-2.664c.001102-.89037846.7226215-1.61189805 1.613-1.613zm-5.226 0c.8903785.00110195 1.611898.72262154 1.613 1.613v2.664c-1.1859782-.51988964-2.5665592-.29644526-3.528.571l.308-3.38c.0718406-.83305701.7708589-1.47161257 1.607-1.468zm-6.387 56.008-18 .072c-.2635757-.0088724-.51519155-.1121449-.709-.291-.18796715-.1878711-.29278339-.4432482-.291-.709v-4.927c.00379836-.3680381.20557917-.7054859.528-.883 2.72668929-1.4875054 5.55819379-2.774249 8.472-3.85v.58c0 .017.009.031.01.048s0 .05 0 .076c.011.086 1.182 8.285 10.992 8.824v.06c.0000005.2655634-.1056308.5202209-.2936.7078148-.1879691.187594-.4428372.2927163-.7084.2921852zm4.549-4.9c-1.0465122.513655-2.028936 1.1486895-2.927 1.892-7.15-.157-9.04-4.772-9.5-6.492 8.115-4.883 7.969-12.359 7.89-16.423-.005-.385-.012-.752-.012-1.085.149105-2.2138269.8497092-4.3551731 2.038-6.229.6217694-1.0372697 1.0028005-2.2008668 1.115-3.405l.706-7.773 1.559-4.684c.202722-.61778266.8240243-.99694264 1.4661338-.89473233s1.1149792.65553942 1.1158662 1.30573233v36.68c0 5.382-1.6 6.181-3.447 7.105zm5.451-7.108v-36.68c.0009801-.64887604.4717312-1.20157697 1.1121837-1.30579629.6404525-.10421931 1.2621545.27070933 1.4688163.88579629l1.559 4.687.707 7.774c.1121995 1.2041332.4932306 2.3677303 1.115 3.405 1.189081 1.8752915 1.889717 4.018454 2.038 6.234 0 .333-.007.7-.015 1.081-.079 4.064-.226 11.54 7.89 16.423-.459 1.724-2.351 6.335-9.5 6.492-.899366-.7432253-1.8831434-1.3779312-2.931-1.891-1.844-.924-3.444-1.723-3.444-7.105zm27 11.08c0 .5522847-.4477153 1-1 1l-18-.072c-.5522847 0-1-.4477153-1-1v-.06c9.81-.539 10.982-8.738 10.992-8.824 0-.026 0-.05 0-.076s.008-.031.008-.048l-.007-.583c2.916319 1.0767049 5.7501779 2.3647922 8.479 3.854.322872.1765492.5248978.514024.528.882z"
                              fill="#000"/>
                    </g>
                </g>
            </svg>
        <!-- <img src="{{asset('assets/images/testimonial/hands.png')}}"> -->
        </p>
        <div style="padding: 0px 15px 18px;background-color: #ffffff;bottom: 0;width: 100%;">
            <button class="recorder-btn btn ripple" onclick="closeDialog()"
                    style="background-color: #ffffff; color: #818593;border: 1px solid #818593!important;box-shadow: none;">
                Close
            </button>
        </div>
    </div>
</div>

<div class="preview-err-info ctooltip d-none" data-text="Preview is not supported by the browser but you can submit it."
 >
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="416.979px" height="416.979px" viewBox="0 0 416.979 416.979" style="enable-background:new 0 0 416.979 416.979;"
	 xml:space="preserve">
<g>
	<path fill="#00b2ff" d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85
		c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786
		c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576
		c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765
		c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
            </div>
<!-- <div style="background: rgba(0,0,0,0.5);width: 100%;height: 100vh;position: absolute;top: 0;display: none;"
             id="backOverlay"></div> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- recommended -->
<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<!-- use 5.5.6 or any other version on cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.5.6/RecordRTC.js"></script>
<script src="https://www.webrtc-experiment.com/EBML.js"></script>
<script src="https://cdn.plyr.io/3.7.2/plyr.polyfilled.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
<script src="https://unpkg.com/bowser@2.7.0/es5.js"></script>
<script src="http://www.youtube.com/player_api"></script>
<script>
    let isBlockedDialog = false;
    let stream;
    let recorder;
    let timeInterval;
    let videofile;
    let isRecordCount;
    let timerInterval;
    let isBackEnable = false;
    let country = [{
        "iso": "AF",
        "name": "AFGHANISTAN",
        "printable_name": "Afghanistan",
        "iso3": "AFG",
        "numcode": "4",
        "code": "af"
    },
        {
            "iso": "ax",
            "name": "ALAND ISLANDS",
            "printable_name": "Aland Islands",
            "iso3": "ALA",
            "numcode": "1006",
            "code": "ax"
        },
        {
            "iso": "AL",
            "name": "ALBANIA",
            "printable_name": "Albania",
            "iso3": "ALB",
            "numcode": "8",
            "code": "al"
        },
        {
            "iso": "DZ",
            "name": "ALGERIA",
            "printable_name": "Algeria",
            "iso3": "DZA",
            "numcode": "12",
            "code": "dz"
        },
        {
            "iso": "AS",
            "name": "AMERICAN SAMOA",
            "printable_name": "American Samoa",
            "iso3": "ASM",
            "numcode": "16",
            "code": "as"
        },
        {
            "iso": "AD",
            "name": "ANDORRA",
            "printable_name": "Andorra",
            "iso3": "AND",
            "numcode": "20",
            "code": "ad"
        },
        {
            "iso": "AO",
            "name": "ANGOLA",
            "printable_name": "Angola",
            "iso3": "AGO",
            "numcode": "24",
            "code": "ao"
        },
        {
            "iso": "AI",
            "name": "ANGUILLA",
            "printable_name": "Anguilla",
            "iso3": "AIA",
            "numcode": "660",
            "code": "ai"
        },
        {
            "iso": "AQ",
            "name": "ANTARCTICA",
            "printable_name": "Antarctica",
            "iso3": null,
            "numcode": "10",
            "code": "aq"
        },
        {
            "iso": "AG",
            "name": "ANTIGUA AND BARBUDA",
            "printable_name": "Antigua and Barbuda",
            "iso3": "ATG",
            "numcode": "28",
            "code": "ag"
        },
        {
            "iso": "AR",
            "name": "ARGENTINA",
            "printable_name": "Argentina",
            "iso3": "ARG",
            "numcode": "32",
            "code": "ar"
        },
        {
            "iso": "AM",
            "name": "ARMENIA",
            "printable_name": "Armenia",
            "iso3": "ARM",
            "numcode": "51",
            "code": "am"
        },
        {
            "iso": "AW",
            "name": "ARUBA",
            "printable_name": "Aruba",
            "iso3": "ABW",
            "numcode": "533",
            "code": "aw"
        },
        {
            "iso": "ap",
            "name": "ASIA-PACIFIC",
            "printable_name": "Asia-Pacific",
            "iso3": "",
            "numcode": "1004",
            "code": "ap"
        },
        {
            "iso": "AU",
            "name": "AUSTRALIA",
            "printable_name": "Australia",
            "iso3": "AUS",
            "numcode": "36",
            "code": "au"
        },
        {
            "iso": "AT",
            "name": "AUSTRIA",
            "printable_name": "Austria",
            "iso3": "AUT",
            "numcode": "40",
            "code": "at"
        },
        {
            "iso": "AZ",
            "name": "AZERBAIJAN",
            "printable_name": "Azerbaijan",
            "iso3": "AZE",
            "numcode": "31",
            "code": "az"
        },
        {
            "iso": "BS",
            "name": "BAHAMAS",
            "printable_name": "Bahamas",
            "iso3": "BHS",
            "numcode": "44",
            "code": "bs"
        },
        {
            "iso": "BH",
            "name": "BAHRAIN",
            "printable_name": "Bahrain",
            "iso3": "BHR",
            "numcode": "48",
            "code": "bh"
        },
        {
            "iso": "BD",
            "name": "BANGLADESH",
            "printable_name": "Bangladesh",
            "iso3": "BGD",
            "numcode": "50",
            "code": "bd"
        },
        {
            "iso": "BB",
            "name": "BARBADOS",
            "printable_name": "Barbados",
            "iso3": "BRB",
            "numcode": "52",
            "code": "bb"
        },
        {
            "iso": "BY",
            "name": "BELARUS",
            "printable_name": "Belarus",
            "iso3": "BLR",
            "numcode": "112",
            "code": "by"
        },
        {
            "iso": "BE",
            "name": "BELGIUM",
            "printable_name": "Belgium",
            "iso3": "BEL",
            "numcode": "56",
            "code": "be"
        },
        {
            "iso": "BZ",
            "name": "BELIZE",
            "printable_name": "Belize",
            "iso3": "BLZ",
            "numcode": "84",
            "code": "bz"
        },
        {
            "iso": "BJ",
            "name": "BENIN",
            "printable_name": "Benin",
            "iso3": "BEN",
            "numcode": "204",
            "code": "bj"
        },
        {
            "iso": "BM",
            "name": "BERMUDA",
            "printable_name": "Bermuda",
            "iso3": "BMU",
            "numcode": "60",
            "code": "bm"
        },
        {
            "iso": "BT",
            "name": "BHUTAN",
            "printable_name": "Bhutan",
            "iso3": "BTN",
            "numcode": "64",
            "code": "bt"
        },
        {
            "iso": "BO",
            "name": "BOLIVIA",
            "printable_name": "Bolivia",
            "iso3": "BOL",
            "numcode": "68",
            "code": "bo"
        },
        {
            "iso": "BA",
            "name": "BOSNIA AND HERZEGOVINA",
            "printable_name": "Bosnia and Herzegovina",
            "iso3": "BIH",
            "numcode": "70",
            "code": "ba"
        },
        {
            "iso": "BW",
            "name": "BOTSWANA",
            "printable_name": "Botswana",
            "iso3": "BWA",
            "numcode": "72",
            "code": "bw"
        },
        {
            "iso": "BV",
            "name": "BOUVET ISLAND",
            "printable_name": "Bouvet Island",
            "iso3": null,
            "numcode": "74",
            "code": "bv"
        },
        {
            "iso": "BR",
            "name": "BRAZIL",
            "printable_name": "Brazil",
            "iso3": "BRA",
            "numcode": "76",
            "code": "br"
        },
        {
            "iso": "IO",
            "name": "BRITISH INDIAN OCEAN TERRITORY",
            "printable_name": "British Indian Ocean Territory",
            "iso3": null,
            "numcode": "86",
            "code": "io"
        },
        {
            "iso": "BN",
            "name": "BRUNEI DARUSSALAM",
            "printable_name": "Brunei Darussalam",
            "iso3": "BRN",
            "numcode": "96",
            "code": "bn"
        },
        {
            "iso": "BG",
            "name": "BULGARIA",
            "printable_name": "Bulgaria",
            "iso3": "BGR",
            "numcode": "100",
            "code": "bg"
        },
        {
            "iso": "BF",
            "name": "BURKINA FASO",
            "printable_name": "Burkina Faso",
            "iso3": "BFA",
            "numcode": "854",
            "code": "bf"
        },
        {
            "iso": "BI",
            "name": "BURUNDI",
            "printable_name": "Burundi",
            "iso3": "BDI",
            "numcode": "108",
            "code": "bi"
        },
        {
            "iso": "KH",
            "name": "CAMBODIA",
            "printable_name": "Cambodia",
            "iso3": "KHM",
            "numcode": "116",
            "code": "kh"
        },
        {
            "iso": "CM",
            "name": "CAMEROON",
            "printable_name": "Cameroon",
            "iso3": "CMR",
            "numcode": "120",
            "code": "cm"
        },
        {
            "iso": "CA",
            "name": "CANADA",
            "printable_name": "Canada",
            "iso3": "CAN",
            "numcode": "124",
            "code": "ca"
        },
        {
            "iso": "CV",
            "name": "CAPE VERDE",
            "printable_name": "Cape Verde",
            "iso3": "CPV",
            "numcode": "132",
            "code": "cv"
        },
        {
            "iso": "KY",
            "name": "CAYMAN ISLANDS",
            "printable_name": "Cayman Islands",
            "iso3": "CYM",
            "numcode": "136",
            "code": "ky"
        },
        {
            "iso": "CF",
            "name": "CENTRAL AFRICAN REPUBLIC",
            "printable_name": "Central African Republic",
            "iso3": "CAF",
            "numcode": "140",
            "code": "cf"
        },
        {
            "iso": "TD",
            "name": "CHAD",
            "printable_name": "Chad",
            "iso3": "TCD",
            "numcode": "148",
            "code": "td"
        },
        {
            "iso": "CL",
            "name": "CHILE",
            "printable_name": "Chile",
            "iso3": "CHL",
            "numcode": "152",
            "code": "cl"
        },
        {
            "iso": "CN",
            "name": "CHINA",
            "printable_name": "China",
            "iso3": "CHN",
            "numcode": "156",
            "code": "cn"
        },
        {
            "iso": "CX",
            "name": "CHRISTMAS ISLAND",
            "printable_name": "Christmas Island",
            "iso3": null,
            "numcode": "162",
            "code": "cx"
        },
        {
            "iso": "CC",
            "name": "COCOS (KEELING) ISLANDS",
            "printable_name": "Cocos (Keeling) Islands",
            "iso3": null,
            "numcode": "166",
            "code": "cc"
        },
        {
            "iso": "CO",
            "name": "COLOMBIA",
            "printable_name": "Colombia",
            "iso3": "COL",
            "numcode": "170",
            "code": "co"
        },
        {
            "iso": "KM",
            "name": "COMOROS",
            "printable_name": "Comoros",
            "iso3": "COM",
            "numcode": "174",
            "code": "km"
        },
        {
            "iso": "CG",
            "name": "CONGO",
            "printable_name": "Congo",
            "iso3": "COG",
            "numcode": "178",
            "code": "cg"
        },
        {
            "iso": "CD",
            "name": "CONGO, THE DEMOCRATIC REPUBLIC OF THE",
            "printable_name": "Congo, the Democratic Republic of the",
            "iso3": "COD",
            "numcode": "180",
            "code": "cd"
        },
        {
            "iso": "CK",
            "name": "COOK ISLANDS",
            "printable_name": "Cook Islands",
            "iso3": "COK",
            "numcode": "184",
            "code": "ck"
        },
        {
            "iso": "CR",
            "name": "COSTA RICA",
            "printable_name": "Costa Rica",
            "iso3": "CRI",
            "numcode": "188",
            "code": "cr"
        },
        {
            "iso": "CI",
            "name": "COTE D'IVOIRE",
            "printable_name": "Cote D'Ivoire",
            "iso3": "CIV",
            "numcode": "384",
            "code": "ci"
        },
        {
            "iso": "HR",
            "name": "CROATIA",
            "printable_name": "Croatia",
            "iso3": "HRV",
            "numcode": "191",
            "code": "hr"
        },
        {
            "iso": "CU",
            "name": "CUBA",
            "printable_name": "Cuba",
            "iso3": "CUB",
            "numcode": "192",
            "code": "cu"
        },
        {
            "iso": "CY",
            "name": "CYPRUS",
            "printable_name": "Cyprus",
            "iso3": "CYP",
            "numcode": "196",
            "code": "cy"
        },
        {
            "iso": "CZ",
            "name": "CZECH REPUBLIC",
            "printable_name": "Czech Republic",
            "iso3": "CZE",
            "numcode": "203",
            "code": "cz"
        },
        {
            "iso": "DK",
            "name": "DENMARK",
            "printable_name": "Denmark",
            "iso3": "DNK",
            "numcode": "208",
            "code": "dk"
        },
        {
            "iso": "DJ",
            "name": "DJIBOUTI",
            "printable_name": "Djibouti",
            "iso3": "DJI",
            "numcode": "262",
            "code": "dj"
        },
        {
            "iso": "DM",
            "name": "DOMINICA",
            "printable_name": "Dominica",
            "iso3": "DMA",
            "numcode": "212",
            "code": "dm"
        },
        {
            "iso": "DO",
            "name": "DOMINICAN REPUBLIC",
            "printable_name": "Dominican Republic",
            "iso3": "DOM",
            "numcode": "214",
            "code": "do"
        },
        {
            "iso": "EC",
            "name": "ECUADOR",
            "printable_name": "Ecuador",
            "iso3": "ECU",
            "numcode": "218",
            "code": "ec"
        },
        {
            "iso": "EG",
            "name": "EGYPT",
            "printable_name": "Egypt",
            "iso3": "EGY",
            "numcode": "818",
            "code": "eg"
        },
        {
            "iso": "SV",
            "name": "EL SALVADOR",
            "printable_name": "El Salvador",
            "iso3": "SLV",
            "numcode": "222",
            "code": "sv"
        },
        {
            "iso": "GQ",
            "name": "EQUATORIAL GUINEA",
            "printable_name": "Equatorial Guinea",
            "iso3": "GNQ",
            "numcode": "226",
            "code": "gq"
        },
        {
            "iso": "ER",
            "name": "ERITREA",
            "printable_name": "Eritrea",
            "iso3": "ERI",
            "numcode": "232",
            "code": "er"
        },
        {
            "iso": "EE",
            "name": "ESTONIA",
            "printable_name": "Estonia",
            "iso3": "EST",
            "numcode": "233",
            "code": "ee"
        },
        {
            "iso": "ET",
            "name": "ETHIOPIA",
            "printable_name": "Ethiopia",
            "iso3": "ETH",
            "numcode": "231",
            "code": "et"
        },
        {
            "iso": "eu",
            "name": "EUROPE",
            "printable_name": "Europe",
            "iso3": "",
            "numcode": "1007",
            "code": "eu"
        },
        {
            "iso": "FK",
            "name": "FALKLAND ISLANDS (MALVINAS)",
            "printable_name": "Falkland Islands (Malvinas)",
            "iso3": "FLK",
            "numcode": "238",
            "code": "fk"
        },
        {
            "iso": "FO",
            "name": "FAROE ISLANDS",
            "printable_name": "Faroe Islands",
            "iso3": "FRO",
            "numcode": "234",
            "code": "fo"
        },
        {
            "iso": "FJ",
            "name": "FIJI",
            "printable_name": "Fiji",
            "iso3": "FJI",
            "numcode": "242",
            "code": "fj"
        },
        {
            "iso": "FI",
            "name": "FINLAND",
            "printable_name": "Finland",
            "iso3": "FIN",
            "numcode": "246",
            "code": "fi"
        },
        {
            "iso": "FR",
            "name": "FRANCE",
            "printable_name": "France",
            "iso3": "FRA",
            "numcode": "250",
            "code": "fr"
        },
        {
            "iso": "GF",
            "name": "FRENCH GUIANA",
            "printable_name": "French Guiana",
            "iso3": "GUF",
            "numcode": "254",
            "code": "gf"
        },
        {
            "iso": "PF",
            "name": "FRENCH POLYNESIA",
            "printable_name": "French Polynesia",
            "iso3": "PYF",
            "numcode": "258",
            "code": "pf"
        },
        {
            "iso": "TF",
            "name": "FRENCH SOUTHERN TERRITORIES",
            "printable_name": "French Southern Territories",
            "iso3": null,
            "numcode": "260",
            "code": "tf"
        },
        {
            "iso": "GA",
            "name": "GABON",
            "printable_name": "Gabon",
            "iso3": "GAB",
            "numcode": "266",
            "code": "ga"
        },
        {
            "iso": "GM",
            "name": "GAMBIA",
            "printable_name": "Gambia",
            "iso3": "GMB",
            "numcode": "270",
            "code": "gm"
        },
        {
            "iso": "GE",
            "name": "GEORGIA",
            "printable_name": "Georgia",
            "iso3": "GEO",
            "numcode": "268",
            "code": "ge"
        },
        {
            "iso": "DE",
            "name": "GERMANY",
            "printable_name": "Germany",
            "iso3": "DEU",
            "numcode": "276",
            "code": "de"
        },
        {
            "iso": "GH",
            "name": "GHANA",
            "printable_name": "Ghana",
            "iso3": "GHA",
            "numcode": "288",
            "code": "gh"
        },
        {
            "iso": "GI",
            "name": "GIBRALTAR",
            "printable_name": "Gibraltar",
            "iso3": "GIB",
            "numcode": "292",
            "code": "gi"
        },
        {
            "iso": "GR",
            "name": "GREECE",
            "printable_name": "Greece",
            "iso3": "GRC",
            "numcode": "300",
            "code": "gr"
        },
        {
            "iso": "GL",
            "name": "GREENLAND",
            "printable_name": "Greenland",
            "iso3": "GRL",
            "numcode": "304",
            "code": "gl"
        },
        {
            "iso": "GD",
            "name": "GRENADA",
            "printable_name": "Grenada",
            "iso3": "GRD",
            "numcode": "308",
            "code": "gd"
        },
        {
            "iso": "GP",
            "name": "GUADELOUPE",
            "printable_name": "Guadeloupe",
            "iso3": "GLP",
            "numcode": "312",
            "code": "gp"
        },
        {
            "iso": "GU",
            "name": "GUAM",
            "printable_name": "Guam",
            "iso3": "GUM",
            "numcode": "316",
            "code": "gu"
        },
        {
            "iso": "GT",
            "name": "GUATEMALA",
            "printable_name": "Guatemala",
            "iso3": "GTM",
            "numcode": "320",
            "code": "gt"
        },
        {
            "iso": "GN",
            "name": "GUINEA",
            "printable_name": "Guinea",
            "iso3": "GIN",
            "numcode": "324",
            "code": "gn"
        },
        {
            "iso": "GW",
            "name": "GUINEA-BISSAU",
            "printable_name": "Guinea-Bissau",
            "iso3": "GNB",
            "numcode": "624",
            "code": "gw"
        },
        {
            "iso": "GY",
            "name": "GUYANA",
            "printable_name": "Guyana",
            "iso3": "GUY",
            "numcode": "328",
            "code": "gy"
        },
        {
            "iso": "HT",
            "name": "HAITI",
            "printable_name": "Haiti",
            "iso3": "HTI",
            "numcode": "332",
            "code": "ht"
        },
        {
            "iso": "HM",
            "name": "HEARD ISLAND AND MCDONALD ISLANDS",
            "printable_name": "Heard Island and Mcdonald Islands",
            "iso3": null,
            "numcode": "334",
            "code": "hm"
        },
        {
            "iso": "VA",
            "name": "HOLY SEE (VATICAN CITY STATE)",
            "printable_name": "Holy See (Vatican City State)",
            "iso3": "VAT",
            "numcode": "336",
            "code": "va"
        },
        {
            "iso": "HN",
            "name": "HONDURAS",
            "printable_name": "Honduras",
            "iso3": "HND",
            "numcode": "340",
            "code": "hn"
        },
        {
            "iso": "HK",
            "name": "HONG KONG",
            "printable_name": "Hong Kong",
            "iso3": "HKG",
            "numcode": "344",
            "code": "hk"
        },
        {
            "iso": "HU",
            "name": "HUNGARY",
            "printable_name": "Hungary",
            "iso3": "HUN",
            "numcode": "348",
            "code": "hu"
        },
        {
            "iso": "IS",
            "name": "ICELAND",
            "printable_name": "Iceland",
            "iso3": "ISL",
            "numcode": "352",
            "code": "is"
        },
        {
            "iso": "IN",
            "name": "INDIA",
            "printable_name": "India",
            "iso3": "IND",
            "numcode": "356",
            "code": "in"
        },
        {
            "iso": "ID",
            "name": "INDONESIA",
            "printable_name": "Indonesia",
            "iso3": "IDN",
            "numcode": "360",
            "code": "id"
        },
        {
            "iso": "IR",
            "name": "IRAN, ISLAMIC REPUBLIC OF",
            "printable_name": "Iran, Islamic Republic of",
            "iso3": "IRN",
            "numcode": "364",
            "code": "ir"
        },
        {
            "iso": "IQ",
            "name": "IRAQ",
            "printable_name": "Iraq",
            "iso3": "IRQ",
            "numcode": "368",
            "code": "iq"
        },
        {
            "iso": "IE",
            "name": "IRELAND",
            "printable_name": "Ireland",
            "iso3": "IRL",
            "numcode": "372",
            "code": "ie"
        },
        {
            "iso": "IL",
            "name": "ISRAEL",
            "printable_name": "Israel",
            "iso3": "ISR",
            "numcode": "376",
            "code": "il"
        },
        {
            "iso": "IT",
            "name": "ITALY",
            "printable_name": "Italy",
            "iso3": "ITA",
            "numcode": "380",
            "code": "it"
        },
        {
            "iso": "JM",
            "name": "JAMAICA",
            "printable_name": "Jamaica",
            "iso3": "JAM",
            "numcode": "388",
            "code": "jm"
        },
        {
            "iso": "JP",
            "name": "JAPAN",
            "printable_name": "Japan",
            "iso3": "JPN",
            "numcode": "392",
            "code": "jp"
        },
        {
            "iso": "JO",
            "name": "JORDAN",
            "printable_name": "Jordan",
            "iso3": "JOR",
            "numcode": "400",
            "code": "jo"
        },
        {
            "iso": "KZ",
            "name": "KAZAKHSTAN",
            "printable_name": "Kazakhstan",
            "iso3": "KAZ",
            "numcode": "398",
            "code": "kz"
        },
        {
            "iso": "KE",
            "name": "KENYA",
            "printable_name": "Kenya",
            "iso3": "KEN",
            "numcode": "404",
            "code": "ke"
        },
        {
            "iso": "KI",
            "name": "KIRIBATI",
            "printable_name": "Kiribati",
            "iso3": "KIR",
            "numcode": "296",
            "code": "ki"
        },
        {
            "iso": "KP",
            "name": "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF",
            "printable_name": "Korea, Democratic People's Republic of",
            "iso3": "PRK",
            "numcode": "408",
            "code": "kp"
        },
        {
            "iso": "KR",
            "name": "KOREA, REPUBLIC OF",
            "printable_name": "Korea, Republic of",
            "iso3": "KOR",
            "numcode": "410",
            "code": "kr"
        },
        {
            "iso": "KW",
            "name": "KUWAIT",
            "printable_name": "Kuwait",
            "iso3": "KWT",
            "numcode": "414",
            "code": "kw"
        },
        {
            "iso": "KG",
            "name": "KYRGYZSTAN",
            "printable_name": "Kyrgyzstan",
            "iso3": "KGZ",
            "numcode": "417",
            "code": "kg"
        },
        {
            "iso": "LA",
            "name": "LAO PEOPLE'S DEMOCRATIC REPUBLIC",
            "printable_name": "Lao People's Democratic Republic",
            "iso3": "LAO",
            "numcode": "418",
            "code": "la"
        },
        {
            "iso": "LV",
            "name": "LATVIA",
            "printable_name": "Latvia",
            "iso3": "LVA",
            "numcode": "428",
            "code": "lv"
        },
        {
            "iso": "LB",
            "name": "LEBANON",
            "printable_name": "Lebanon",
            "iso3": "LBN",
            "numcode": "422",
            "code": "lb"
        },
        {
            "iso": "LS",
            "name": "LESOTHO",
            "printable_name": "Lesotho",
            "iso3": "LSO",
            "numcode": "426",
            "code": "ls"
        },
        {
            "iso": "LR",
            "name": "LIBERIA",
            "printable_name": "Liberia",
            "iso3": "LBR",
            "numcode": "430",
            "code": "lr"
        },
        {
            "iso": "LY",
            "name": "LIBYAN ARAB JAMAHIRIYA",
            "printable_name": "Libyan Arab Jamahiriya",
            "iso3": "LBY",
            "numcode": "434",
            "code": "ly"
        },
        {
            "iso": "LI",
            "name": "LIECHTENSTEIN",
            "printable_name": "Liechtenstein",
            "iso3": "LIE",
            "numcode": "438",
            "code": "li"
        },
        {
            "iso": "LT",
            "name": "LITHUANIA",
            "printable_name": "Lithuania",
            "iso3": "LTU",
            "numcode": "440",
            "code": "lt"
        },
        {
            "iso": "LU",
            "name": "LUXEMBOURG",
            "printable_name": "Luxembourg",
            "iso3": "LUX",
            "numcode": "442",
            "code": "lu"
        },
        {
            "iso": "MO",
            "name": "MACAO",
            "printable_name": "Macao",
            "iso3": "MAC",
            "numcode": "446",
            "code": "mo"
        },
        {
            "iso": "MK",
            "name": "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
            "printable_name": "Macedonia, the Former Yugoslav Republic of",
            "iso3": "MKD",
            "numcode": "807",
            "code": "mk"
        },
        {
            "iso": "MG",
            "name": "MADAGASCAR",
            "printable_name": "Madagascar",
            "iso3": "MDG",
            "numcode": "450",
            "code": "mg"
        },
        {
            "iso": "MW",
            "name": "MALAWI",
            "printable_name": "Malawi",
            "iso3": "MWI",
            "numcode": "454",
            "code": "mw"
        },
        {
            "iso": "MY",
            "name": "MALAYSIA",
            "printable_name": "Malaysia",
            "iso3": "MYS",
            "numcode": "458",
            "code": "my"
        },
        {
            "iso": "MV",
            "name": "MALDIVES",
            "printable_name": "Maldives",
            "iso3": "MDV",
            "numcode": "462",
            "code": "mv"
        },
        {
            "iso": "ML",
            "name": "MALI",
            "printable_name": "Mali",
            "iso3": "MLI",
            "numcode": "466",
            "code": "ml"
        },
        {
            "iso": "MT",
            "name": "MALTA",
            "printable_name": "Malta",
            "iso3": "MLT",
            "numcode": "470",
            "code": "mt"
        },
        {
            "iso": "MH",
            "name": "MARSHALL ISLANDS",
            "printable_name": "Marshall Islands",
            "iso3": "MHL",
            "numcode": "584",
            "code": "mh"
        },
        {
            "iso": "MQ",
            "name": "MARTINIQUE",
            "printable_name": "Martinique",
            "iso3": "MTQ",
            "numcode": "474",
            "code": "mq"
        },
        {
            "iso": "MR",
            "name": "MAURITANIA",
            "printable_name": "Mauritania",
            "iso3": "MRT",
            "numcode": "478",
            "code": "mr"
        },
        {
            "iso": "MU",
            "name": "MAURITIUS",
            "printable_name": "Mauritius",
            "iso3": "MUS",
            "numcode": "480",
            "code": "mu"
        },
        {
            "iso": "YT",
            "name": "MAYOTTE",
            "printable_name": "Mayotte",
            "iso3": null,
            "numcode": "175",
            "code": "yt"
        },
        {
            "iso": "MX",
            "name": "MEXICO",
            "printable_name": "Mexico",
            "iso3": "MEX",
            "numcode": "484",
            "code": "mx"
        },
        {
            "iso": "FM",
            "name": "MICRONESIA, FEDERATED STATES OF",
            "printable_name": "Micronesia, Federated States of",
            "iso3": "FSM",
            "numcode": "583",
            "code": "fm"
        },
        {
            "iso": "MD",
            "name": "MOLDOVA, REPUBLIC OF",
            "printable_name": "Moldova, Republic of",
            "iso3": "MDA",
            "numcode": "498",
            "code": "md"
        },
        {
            "iso": "MC",
            "name": "MONACO",
            "printable_name": "Monaco",
            "iso3": "MCO",
            "numcode": "492",
            "code": "mc"
        },
        {
            "iso": "MN",
            "name": "MONGOLIA",
            "printable_name": "Mongolia",
            "iso3": "MNG",
            "numcode": "496",
            "code": "mn"
        },
        {
            "iso": "me",
            "name": "MONTENEGRO",
            "printable_name": "Montenegro",
            "iso3": "MNE",
            "numcode": "1010",
            "code": "me"
        },
        {
            "iso": "MS",
            "name": "MONTSERRAT",
            "printable_name": "Montserrat",
            "iso3": "MSR",
            "numcode": "500",
            "code": "ms"
        },
        {
            "iso": "MA",
            "name": "MOROCCO",
            "printable_name": "Morocco",
            "iso3": "MAR",
            "numcode": "504",
            "code": "ma"
        },
        {
            "iso": "MZ",
            "name": "MOZAMBIQUE",
            "printable_name": "Mozambique",
            "iso3": "MOZ",
            "numcode": "508",
            "code": "mz"
        },
        {
            "iso": "MM",
            "name": "MYANMAR",
            "printable_name": "Myanmar",
            "iso3": "MMR",
            "numcode": "104",
            "code": "mm"
        },
        {
            "iso": "NA",
            "name": "NAMIBIA",
            "printable_name": "Namibia",
            "iso3": "NAM",
            "numcode": "516",
            "code": "na"
        },
        {
            "iso": "NR",
            "name": "NAURU",
            "printable_name": "Nauru",
            "iso3": "NRU",
            "numcode": "520",
            "code": "nr"
        },
        {
            "iso": "NP",
            "name": "NEPAL",
            "printable_name": "Nepal",
            "iso3": "NPL",
            "numcode": "524",
            "code": "np"
        },
        {
            "iso": "NL",
            "name": "NETHERLANDS",
            "printable_name": "Netherlands",
            "iso3": "NLD",
            "numcode": "528",
            "code": "nl"
        },
        {
            "iso": "AN",
            "name": "NETHERLANDS ANTILLES",
            "printable_name": "Netherlands Antilles",
            "iso3": "ANT",
            "numcode": "530",
            "code": "an"
        },
        {
            "iso": "nt",
            "name": "NEUTRAL ZONE",
            "printable_name": "Neutral Zone",
            "iso3": "NTZ",
            "numcode": "1002",
            "code": "nt"
        },
        {
            "iso": "NC",
            "name": "NEW CALEDONIA",
            "printable_name": "New Caledonia",
            "iso3": "NCL",
            "numcode": "540",
            "code": "nc"
        },
        {
            "iso": "NZ",
            "name": "NEW ZEALAND",
            "printable_name": "New Zealand",
            "iso3": "NZL",
            "numcode": "554",
            "code": "nz"
        },
        {
            "iso": "NI",
            "name": "NICARAGUA",
            "printable_name": "Nicaragua",
            "iso3": "NIC",
            "numcode": "558",
            "code": "ni"
        },
        {
            "iso": "NE",
            "name": "NIGER",
            "printable_name": "Niger",
            "iso3": "NER",
            "numcode": "562",
            "code": "ne"
        },
        {
            "iso": "NG",
            "name": "NIGERIA",
            "printable_name": "Nigeria",
            "iso3": "NGA",
            "numcode": "566",
            "code": "ng"
        },
        {
            "iso": "NU",
            "name": "NIUE",
            "printable_name": "Niue",
            "iso3": "NIU",
            "numcode": "570",
            "code": "nu"
        },
        {
            "iso": "NF",
            "name": "NORFOLK ISLAND",
            "printable_name": "Norfolk Island",
            "iso3": "NFK",
            "numcode": "574",
            "code": "nf"
        },
        {
            "iso": "MP",
            "name": "NORTHERN MARIANA ISLANDS",
            "printable_name": "Northern Mariana Islands",
            "iso3": "MNP",
            "numcode": "580",
            "code": "mp"
        },
        {
            "iso": "NO",
            "name": "NORWAY",
            "printable_name": "Norway",
            "iso3": "NOR",
            "numcode": "578",
            "code": "no"
        },
        {
            "iso": "OM",
            "name": "OMAN",
            "printable_name": "Oman",
            "iso3": "OMN",
            "numcode": "512",
            "code": "om"
        },
        {
            "iso": "PK",
            "name": "PAKISTAN",
            "printable_name": "Pakistan",
            "iso3": "PAK",
            "numcode": "586",
            "code": "pk"
        },
        {
            "iso": "PW",
            "name": "PALAU",
            "printable_name": "Palau",
            "iso3": "PLW",
            "numcode": "585",
            "code": "pw"
        },
        {
            "iso": "ps",
            "name": "PALESTINIAN TERRITORY, OCCUPIED",
            "printable_name": "Palestinian Territory, Occupied",
            "iso3": "PSE",
            "numcode": "1009",
            "code": "ps"
        },
        {
            "iso": "PA",
            "name": "PANAMA",
            "printable_name": "Panama",
            "iso3": "PAN",
            "numcode": "591",
            "code": "pa"
        },
        {
            "iso": "PG",
            "name": "PAPUA NEW GUINEA",
            "printable_name": "Papua New Guinea",
            "iso3": "PNG",
            "numcode": "598",
            "code": "pg"
        },
        {
            "iso": "PY",
            "name": "PARAGUAY",
            "printable_name": "Paraguay",
            "iso3": "PRY",
            "numcode": "600",
            "code": "py"
        },
        {
            "iso": "PE",
            "name": "PERU",
            "printable_name": "Peru",
            "iso3": "PER",
            "numcode": "604",
            "code": "pe"
        },
        {
            "iso": "PH",
            "name": "PHILIPPINES",
            "printable_name": "Philippines",
            "iso3": "PHL",
            "numcode": "608",
            "code": "ph"
        },
        {
            "iso": "PN",
            "name": "PITCAIRN",
            "printable_name": "Pitcairn",
            "iso3": "PCN",
            "numcode": "612",
            "code": "pn"
        },
        {
            "iso": "PL",
            "name": "POLAND",
            "printable_name": "Poland",
            "iso3": "POL",
            "numcode": "616",
            "code": "pl"
        },
        {
            "iso": "PT",
            "name": "PORTUGAL",
            "printable_name": "Portugal",
            "iso3": "PRT",
            "numcode": "620",
            "code": "pt"
        },
        {
            "iso": "01",
            "name": "PRIVATE",
            "printable_name": "Private",
            "iso3": "",
            "numcode": "1008",
            "code": "01"
        },
        {
            "iso": "PR",
            "name": "PUERTO RICO",
            "printable_name": "Puerto Rico",
            "iso3": "PRI",
            "numcode": "630",
            "code": "pr"
        },
        {
            "iso": "QA",
            "name": "QATAR",
            "printable_name": "Qatar",
            "iso3": "QAT",
            "numcode": "634",
            "code": "qa"
        },
        {
            "iso": "rs",
            "name": "REPUBLIC OF SERBIA",
            "printable_name": "Republic of Serbia",
            "iso3": "SRB",
            "numcode": "1005",
            "code": "rs"
        },
        {
            "iso": "RE",
            "name": "REUNION",
            "printable_name": "Reunion",
            "iso3": "REU",
            "numcode": "638",
            "code": "re"
        },
        {
            "iso": "RO",
            "name": "ROMANIA",
            "printable_name": "Romania",
            "iso3": "ROM",
            "numcode": "642",
            "code": "ro"
        },
        {
            "iso": "RU",
            "name": "RUSSIAN FEDERATION",
            "printable_name": "Russian Federation",
            "iso3": "RUS",
            "numcode": "643",
            "code": "ru"
        },
        {
            "iso": "RW",
            "name": "RWANDA",
            "printable_name": "Rwanda",
            "iso3": "RWA",
            "numcode": "646",
            "code": "rw"
        },
        {
            "iso": "SH",
            "name": "SAINT HELENA",
            "printable_name": "Saint Helena",
            "iso3": "SHN",
            "numcode": "654",
            "code": "sh"
        },
        {
            "iso": "KN",
            "name": "SAINT KITTS AND NEVIS",
            "printable_name": "Saint Kitts and Nevis",
            "iso3": "KNA",
            "numcode": "659",
            "code": "kn"
        },
        {
            "iso": "LC",
            "name": "SAINT LUCIA",
            "printable_name": "Saint Lucia",
            "iso3": "LCA",
            "numcode": "662",
            "code": "lc"
        },
        {
            "iso": "PM",
            "name": "SAINT PIERRE AND MIQUELON",
            "printable_name": "Saint Pierre and Miquelon",
            "iso3": "SPM",
            "numcode": "666",
            "code": "pm"
        },
        {
            "iso": "VC",
            "name": "SAINT VINCENT AND THE GRENADINES",
            "printable_name": "Saint Vincent and the Grenadines",
            "iso3": "VCT",
            "numcode": "670",
            "code": "vc"
        },
        {
            "iso": "WS",
            "name": "SAMOA",
            "printable_name": "Samoa",
            "iso3": "WSM",
            "numcode": "882",
            "code": "ws"
        },
        {
            "iso": "SM",
            "name": "SAN MARINO",
            "printable_name": "San Marino",
            "iso3": "SMR",
            "numcode": "674",
            "code": "sm"
        },
        {
            "iso": "ST",
            "name": "SAO TOME AND PRINCIPE",
            "printable_name": "Sao Tome and Principe",
            "iso3": "STP",
            "numcode": "678",
            "code": "st"
        },
        {
            "iso": "SA",
            "name": "SAUDI ARABIA",
            "printable_name": "Saudi Arabia",
            "iso3": "SAU",
            "numcode": "682",
            "code": "sa"
        },
        {
            "iso": "SN",
            "name": "SENEGAL",
            "printable_name": "Senegal",
            "iso3": "SEN",
            "numcode": "686",
            "code": "sn"
        },
        {
            "iso": "cs",
            "name": "SERBIA AND MONTENEGRO",
            "printable_name": "Serbia and Montenegro",
            "iso3": "SCG",
            "numcode": "1001",
            "code": "cs"
        },
        {
            "iso": "SC",
            "name": "SEYCHELLES",
            "printable_name": "Seychelles",
            "iso3": "SYC",
            "numcode": "690",
            "code": "sc"
        },
        {
            "iso": "SL",
            "name": "SIERRA LEONE",
            "printable_name": "Sierra Leone",
            "iso3": "SLE",
            "numcode": "694",
            "code": "sl"
        },
        {
            "iso": "SG",
            "name": "SINGAPORE",
            "printable_name": "Singapore",
            "iso3": "SGP",
            "numcode": "702",
            "code": "sg"
        },
        {
            "iso": "SK",
            "name": "SLOVAKIA",
            "printable_name": "Slovakia",
            "iso3": "SVK",
            "numcode": "703",
            "code": "sk"
        },
        {
            "iso": "SI",
            "name": "SLOVENIA",
            "printable_name": "Slovenia",
            "iso3": "SVN",
            "numcode": "705",
            "code": "si"
        },
        {
            "iso": "SB",
            "name": "SOLOMON ISLANDS",
            "printable_name": "Solomon Islands",
            "iso3": "SLB",
            "numcode": "90",
            "code": "sb"
        },
        {
            "iso": "SO",
            "name": "SOMALIA",
            "printable_name": "Somalia",
            "iso3": "SOM",
            "numcode": "706",
            "code": "so"
        },
        {
            "iso": "ZA",
            "name": "SOUTH AFRICA",
            "printable_name": "South Africa",
            "iso3": "ZAF",
            "numcode": "710",
            "code": "za"
        },
        {
            "iso": "GS",
            "name": "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
            "printable_name": "South Georgia and the South Sandwich Islands",
            "iso3": null,
            "numcode": "239",
            "code": "gs"
        },
        {
            "iso": "ES",
            "name": "SPAIN",
            "printable_name": "Spain",
            "iso3": "ESP",
            "numcode": "724",
            "code": "es"
        },
        {
            "iso": "LK",
            "name": "SRI LANKA",
            "printable_name": "Sri Lanka",
            "iso3": "LKA",
            "numcode": "144",
            "code": "lk"
        },
        {
            "iso": "SD",
            "name": "SUDAN",
            "printable_name": "Sudan",
            "iso3": "SDN",
            "numcode": "736",
            "code": "sd"
        },
        {
            "iso": "SR",
            "name": "SURINAME",
            "printable_name": "Suriname",
            "iso3": "SUR",
            "numcode": "740",
            "code": "sr"
        },
        {
            "iso": "SJ",
            "name": "SVALBARD AND JAN MAYEN",
            "printable_name": "Svalbard and Jan Mayen",
            "iso3": "SJM",
            "numcode": "744",
            "code": "sj"
        },
        {
            "iso": "SZ",
            "name": "SWAZILAND",
            "printable_name": "Swaziland",
            "iso3": "SWZ",
            "numcode": "748",
            "code": "sz"
        },
        {
            "iso": "SE",
            "name": "SWEDEN",
            "printable_name": "Sweden",
            "iso3": "SWE",
            "numcode": "752",
            "code": "se"
        },
        {
            "iso": "CH",
            "name": "SWITZERLAND",
            "printable_name": "Switzerland",
            "iso3": "CHE",
            "numcode": "756",
            "code": "ch"
        },
        {
            "iso": "SY",
            "name": "SYRIAN ARAB REPUBLIC",
            "printable_name": "Syrian Arab Republic",
            "iso3": "SYR",
            "numcode": "760",
            "code": "sy"
        },
        {
            "iso": "TW",
            "name": "TAIWAN, PROVINCE OF CHINA",
            "printable_name": "Taiwan, Province of China",
            "iso3": "TWN",
            "numcode": "158",
            "code": "tw"
        },
        {
            "iso": "TJ",
            "name": "TAJIKISTAN",
            "printable_name": "Tajikistan",
            "iso3": "TJK",
            "numcode": "762",
            "code": "tj"
        },
        {
            "iso": "TZ",
            "name": "TANZANIA, UNITED REPUBLIC OF",
            "printable_name": "Tanzania, United Republic of",
            "iso3": "TZA",
            "numcode": "834",
            "code": "tz"
        },
        {
            "iso": "TH",
            "name": "THAILAND",
            "printable_name": "Thailand",
            "iso3": "THA",
            "numcode": "764",
            "code": "th"
        },
        {
            "iso": "TL",
            "name": "TIMOR-LESTE",
            "printable_name": "Timor-Leste",
            "iso3": null,
            "numcode": "626",
            "code": "tl"
        },
        {
            "iso": "TG",
            "name": "TOGO",
            "printable_name": "Togo",
            "iso3": "TGO",
            "numcode": "768",
            "code": "tg"
        },
        {
            "iso": "TK",
            "name": "TOKELAU",
            "printable_name": "Tokelau",
            "iso3": "TKL",
            "numcode": "772",
            "code": "tk"
        },
        {
            "iso": "TO",
            "name": "TONGA",
            "printable_name": "Tonga",
            "iso3": "TON",
            "numcode": "776",
            "code": "to"
        },
        {
            "iso": "TT",
            "name": "TRINIDAD AND TOBAGO",
            "printable_name": "Trinidad and Tobago",
            "iso3": "TTO",
            "numcode": "780",
            "code": "tt"
        },
        {
            "iso": "TN",
            "name": "TUNISIA",
            "printable_name": "Tunisia",
            "iso3": "TUN",
            "numcode": "788",
            "code": "tn"
        },
        {
            "iso": "TR",
            "name": "TURKEY",
            "printable_name": "Turkey",
            "iso3": "TUR",
            "numcode": "792",
            "code": "tr"
        },
        {
            "iso": "TM",
            "name": "TURKMENISTAN",
            "printable_name": "Turkmenistan",
            "iso3": "TKM",
            "numcode": "795",
            "code": "tm"
        },
        {
            "iso": "TC",
            "name": "TURKS AND CAICOS ISLANDS",
            "printable_name": "Turks and Caicos Islands",
            "iso3": "TCA",
            "numcode": "796",
            "code": "tc"
        },
        {
            "iso": "TV",
            "name": "TUVALU",
            "printable_name": "Tuvalu",
            "iso3": "TUV",
            "numcode": "798",
            "code": "tv"
        },
        {
            "iso": "UG",
            "name": "UGANDA",
            "printable_name": "Uganda",
            "iso3": "UGA",
            "numcode": "800",
            "code": "ug"
        },
        {
            "iso": "UA",
            "name": "UKRAINE",
            "printable_name": "Ukraine",
            "iso3": "UKR",
            "numcode": "804",
            "code": "ua"
        },
        {
            "iso": "AE",
            "name": "UNITED ARAB EMIRATES",
            "printable_name": "United Arab Emirates",
            "iso3": "ARE",
            "numcode": "784",
            "code": "ae"
        },
        {
            "iso": "GB",
            "name": "UNITED KINGDOM",
            "printable_name": "United Kingdom",
            "iso3": "GBR",
            "numcode": "826",
            "code": "uk"
        },
        {
            "iso": "US",
            "name": "UNITED STATES",
            "printable_name": "United States",
            "iso3": "USA",
            "numcode": "840",
            "code": "us"
        },
        {
            "iso": "UM",
            "name": "UNITED STATES MINOR OUTLYING ISLANDS",
            "printable_name": "United States Minor Outlying Islands",
            "iso3": null,
            "numcode": "581",
            "code": "um"
        },
        {
            "iso": "UY",
            "name": "URUGUAY",
            "printable_name": "Uruguay",
            "iso3": "URY",
            "numcode": "858",
            "code": "uy"
        },
        {
            "iso": "UZ",
            "name": "UZBEKISTAN",
            "printable_name": "Uzbekistan",
            "iso3": "UZB",
            "numcode": "860",
            "code": "uz"
        },
        {
            "iso": "VU",
            "name": "VANUATU",
            "printable_name": "Vanuatu",
            "iso3": "VUT",
            "numcode": "548",
            "code": "vu"
        },
        {
            "iso": "VE",
            "name": "VENEZUELA",
            "printable_name": "Venezuela",
            "iso3": "VEN",
            "numcode": "862",
            "code": "ve"
        },
        {
            "iso": "VN",
            "name": "VIET NAM",
            "printable_name": "Viet Nam",
            "iso3": "VNM",
            "numcode": "704",
            "code": "vn"
        },
        {
            "iso": "VG",
            "name": "VIRGIN ISLANDS, BRITISH",
            "printable_name": "Virgin Islands, British",
            "iso3": "VGB",
            "numcode": "92",
            "code": "vg"
        },
        {
            "iso": "VI",
            "name": "VIRGIN ISLANDS, U.S.",
            "printable_name": "Virgin Islands, U.s.",
            "iso3": "VIR",
            "numcode": "850",
            "code": "vi"
        },
        {
            "iso": "WF",
            "name": "WALLIS AND FUTUNA",
            "printable_name": "Wallis and Futuna",
            "iso3": "WLF",
            "numcode": "876",
            "code": "wf"
        },
        {
            "iso": "EH",
            "name": "WESTERN SAHARA",
            "printable_name": "Western Sahara",
            "iso3": "ESH",
            "numcode": "732",
            "code": "eh"
        },
        {
            "iso": "YE",
            "name": "YEMEN",
            "printable_name": "Yemen",
            "iso3": "YEM",
            "numcode": "887",
            "code": "ye"
        },
        {
            "iso": "yu",
            "name": "YUGOSLAVIA",
            "printable_name": "Yugoslavia",
            "iso3": "YUG",
            "numcode": "1003",
            "code": "yu"
        },
        {
            "iso": "ZM",
            "name": "ZAMBIA",
            "printable_name": "Zambia",
            "iso3": "ZMB",
            "numcode": "894",
            "code": "zm"
        },
        {
            "iso": "ZW",
            "name": "ZIMBABWE",
            "printable_name": "Zimbabwe",
            "iso3": "ZWE",
            "numcode": "716",
            "code": "zw"
        }
    ];
    let country_name;
    let timerinterval;
    var toastmixin;
    var interval;
    const messages = {
        "LONG_DURATION": "Please make sure your video is within 240 seconds.",
        "SHORT_DURATION": "Please make sure your video is minimum 5 seconds long.",
        "LONG_SIZE": "Please make sure your video is within 100 MB.",
        "VALID_FORMAT": "Please select the video.",
        "AUDIO_VIDEO_ACESS_DENIED": "You may have denied camera & microphone access, if so you will have to allow access in browser settings. However, you can still choose a file to upload.",
        "ALREADY_START_RECORDING": "Camera is being used by another tab or app. Please close it and reload this page to start recording."
    };
    isSafari = false;
    var uploadType;
    let chunks = [];
    recLimit = 240;
    recMessage = "Please make sure your video is within 240 seconds.";

    function myFunction() {
        if (isBackEnable == true) {
            localStorage.setItem("is_recording_start", "false");
            return "Write something clever here...";
        } else {
            if (localStorage.getItem("is_recording_start") == 'true') {
                localStorage.setItem("is_recording_start", "false");
                return "Write something clever here...";
            }
        }

    }

    function videoload(){
        const video = document.getElementById("recordVideo");
        $(".overLay-web").css('width',video.clientWidth+'px')
    }



    // document.addEventListener("DOMContentLoaded", function () {
    //     window.addEventListener('online',  updateOnlineStatus);
    //     window.addEventListener('offline', updateOnlineStatus);
    // });


    $(document).ready(() => {
        if (/^((?!chrome|android).)*safari/i.test(navigator.userAgent) && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            isSafari = true;
            $("#videorccon").addClass("d-none");
            $("#safariVideoCon").removeClass("d-none");
        }
        if(isSafari == false){
            checkForMediaAccess();
        }
        const player = new Plyr('#my-video', {
            controls: ['play-large', 'play', 'progress', 'current-time', 'airplay', 'fullscreen']
        });
        addopt();
        toastMixin = Swal.mixin({
            toast: true,
            iconHtml: `<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M52.5 0H7.5C5.51136 0.00157247 3.60462 0.792254 2.19844 2.19844C0.792254 3.60462 0.00157247 5.51136 0 7.5V52.5C0.00157247 54.4886 0.792254 56.3954 2.19844 57.8016C3.60462 59.2077 5.51136 59.9984 7.5 60H52.5C54.4886 59.9984 56.3954 59.2077 57.8016 57.8016C59.2077 56.3954 59.9984 54.4886 60 52.5V7.5C59.9984 5.51136 59.2077 3.60462 57.8016 2.19844C56.3954 0.792254 54.4886 0.00157247 52.5 0V0ZM44.2625 40.7375C44.4956 40.9686 44.6808 41.2434 44.8074 41.5463C44.934 41.8491 44.9995 42.174 45.0002 42.5022C45.001 42.8305 44.9368 43.1556 44.8115 43.459C44.6863 43.7624 44.5023 44.0381 44.2702 44.2702C44.0381 44.5023 43.7624 44.6863 43.459 44.8115C43.1556 44.9368 42.8305 45.001 42.5022 45.0002C42.174 44.9995 41.8491 44.934 41.5463 44.8074C41.2434 44.6808 40.9686 44.4956 40.7375 44.2625L30 33.5375L19.2625 44.2625C18.7951 44.7299 18.1611 44.9926 17.5 44.9926C16.8389 44.9926 16.2049 44.7299 15.7375 44.2625C15.2701 43.7951 15.0074 43.1611 15.0074 42.5C15.0074 41.8389 15.2701 41.2049 15.7375 40.7375L26.4625 30L15.7375 19.2625C15.2701 18.7951 15.0074 18.1611 15.0074 17.5C15.0074 16.8389 15.2701 16.2049 15.7375 15.7375C16.2049 15.2701 16.8389 15.0074 17.5 15.0074C18.1611 15.0074 18.7951 15.2701 19.2625 15.7375L30 26.4625L40.7375 15.7375C41.2049 15.2701 41.8389 15.0074 42.5 15.0074C43.1611 15.0074 43.7951 15.2701 44.2625 15.7375C44.7299 16.2049 44.9926 16.8389 44.9926 17.5C44.9926 18.1611 44.7299 18.7951 44.2625 19.2625L33.5375 30L44.2625 40.7375Z" fill="#FF355B"/>
<path d="M44.2625 40.7374C44.4956 40.9685 44.6808 41.2433 44.8074 41.5462C44.934 41.849 44.9995 42.1739 45.0002 42.5021C45.001 42.8304 44.9368 43.1555 44.8115 43.4589C44.6863 43.7623 44.5023 44.038 44.2702 44.2701C44.0381 44.5022 43.7624 44.6861 43.459 44.8114C43.1556 44.9367 42.8305 45.0008 42.5022 45.0001C42.174 44.9994 41.8491 44.9339 41.5463 44.8073C41.2434 44.6807 40.9686 44.4955 40.7375 44.2624L30 33.5374L19.2625 44.2624C18.7951 44.7298 18.1611 44.9924 17.5 44.9924C16.8389 44.9924 16.2049 44.7298 15.7375 44.2624C15.2701 43.7949 15.0074 43.1609 15.0074 42.4999C15.0074 41.8388 15.2701 41.2048 15.7375 40.7374L26.4625 29.9999L15.7375 19.2624C15.2701 18.7949 15.0074 18.1609 15.0074 17.4999C15.0074 16.8388 15.2701 16.2048 15.7375 15.7374C16.2049 15.2699 16.8389 15.0073 17.5 15.0073C18.1611 15.0073 18.7951 15.2699 19.2625 15.7374L30 26.4624L40.7375 15.7374C41.2049 15.2699 41.8389 15.0073 42.5 15.0073C43.1611 15.0073 43.7951 15.2699 44.2625 15.7374C44.7299 16.2048 44.9925 16.8388 44.9925 17.4999C44.9925 18.1609 44.7299 18.7949 44.2625 19.2624L33.5375 29.9999L44.2625 40.7374Z" fill="white"/>
</svg>`,
            // icon: 'danger',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
            customClass: {
                container: 'c-sw-container',
                popup: 'c-sw-popup',
                header: 'c-sw-header',
                closeButton: 'c-sw-close',
                icon: 'c-sw-icon',
                progressBar: 'c-sw-progress'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        get_query();
        function get_query(){
            var url = location.search;
            var qs = url.substring(url.indexOf('?') + 1).split('&');
            for(var i = 0, result = {}; i < qs.length; i++){
                qs[i] = qs[i].split('=');
                result[qs[i][0]] = decodeURIComponent(qs[i][1]);
            }
            if(result[""] != 'undefined'){
                localStorage.setItem("urm_params", JSON.stringify(result));
            }
            window.history.replaceState(null, null, window.location.pathname);
        }
        if(getOS() == "Mac OS" && $(window).width() > 768){
            $(".secId").text("120");
            recLimit = 120;
            recMessage = "Please make sure your video is within 120 seconds.";
        }
    });


    function addopt() {
        let data = '';
        country.forEach(element => {
            data += `<option value="${element.printable_name}">${element.printable_name}</option>`;
        });
        $("#country").append(data);


    }

    const showDialog = (id) => {
        isBackEnable = true;
        // $("#mainPage").addClass("position-fixed");
        let height = $(id).height() + "px";
        $(id).css("height", "0px");
        $(id).show();
        $(id).animate({
            height
        }, 300, () => {
            $(id).css("height", "auto");
            $("body").css({"overflow": "hidden","position": "fixed"});
            $("#overLayBack").show();
            if(isSafari == false){
                // alert("hello");
                checkForMediaAccess();
            }

        });

    }


    const hideDialog = (id) => {
        isBackEnable = false;
        setErrorMSG("", true);
        let height = $(id).height() + "px";
        $(id).animate({
            height: "0px"
        }, 300, () => {
            $("#overLayBack").hide();
            // $("body").css("overflow", "auto");
            $("body").css({"overflow": "auto","position": "relative"});
            $(id).hide();
            $(id).css("height", height);
        });

        // $("#backOverlay").hide();
        $("#mainPage").removeClass("position-fixed");
    }



    const checkFileInfo = (event) => {
        uploadType = 2;
        var files = event.target.files;
        var video = document.createElement('video');
        video.preload = 'metadata';
        let fileSize = (files[0].size / (1024 * 1024)).toFixed(2);
        if (!isVideo(files[0].name)) {

            document.getElementById("file-upload").value = "";
            setErrorMSG(messages.VALID_FORMAT);
            return;
        } else if (fileSize > 100) {

            document.getElementById("file-upload").value = "";
            setErrorMSG(messages.LONG_SIZE);
            return;
        } else {

            video.onloadedmetadata = function () {
                window.URL.revokeObjectURL(video.src);
                var duration = video.duration;
                if (duration == "Infinity") {
                    setErrorMSG("", true);
                    hideDialog('#dialogSecond');
                    proceedForReviewUpload(files[0]);
                    document.getElementById("file-upload").value = "";
                } else if (Number(duration) < 5) {
                    document.getElementById("file-upload").value = "";
                    setErrorMSG(messages.SHORT_DURATION);
                    return;
                } else if (Number(duration) > recLimit) {
                    document.getElementById("file-upload").value = "";
                    setErrorMSG(recMessage);
                    return;
                } else {

                    setErrorMSG("", true);
                    hideDialog('#dialogSecond');
                    proceedForReviewUpload(files[0]);
                    document.getElementById("file-upload").value = "";
                }

            }
            video.src = URL.createObjectURL(files[0]);
        }
    }

    const checkSafariFileInfo = (event, inputId, msgId) => {
        if(isSafari == true){
            if(inputId == "file-upload-new" || inputId == "file-upload"){
                uploadType = 2;
            }else{
                uploadType = 1;
            }
        }else{
            uploadType = 2;
        }
        var files = event.target.files;
        var video = document.createElement('video');
        video.preload = 'metadata';
        let fileSize = (files[0].size / (1024 * 1024)).toFixed(2);
        if (!isVideo(files[0].name)) {
            $("#safChoose").removeClass("d-none");
            document.getElementById(inputId).value = "";
            setSafariErrorMSG(messages.VALID_FORMAT, false, msgId);
            return;
        } else if (fileSize > 100) {
            $("#safChoose").removeClass("d-none");
            document.getElementById(inputId).value = "";
            setSafariErrorMSG(messages.LONG_SIZE, false, msgId);
            return;
        } else {
            video.onloadedmetadata = function () {
                window.URL.revokeObjectURL(video.src);
                var duration = video.duration;
                if (duration == "Infinity") {
                    setSafariErrorMSG("", true, msgId);
                    $("#safChoose").addClass("d-none");
                    hideDialog('#dialogSecond');
                    proceedForReviewUploadSafari(files[0]);
                    document.getElementById(inputId).value = "";
                } else if (Number(duration) < 5) {
                    $("#safChoose").removeClass("d-none");
                    document.getElementById(inputId).value = "";
                    setSafariErrorMSG(messages.SHORT_DURATION, false, msgId);
                    return;
                } else if (Number(duration) > recLimit) {
                    $("#safChoose").removeClass("d-none");
                    document.getElementById(inputId).value = "";
                    setSafariErrorMSG(recMessage, false, msgId);
                    return;
                } else {
                    $("#safChoose").addClass("d-none");
                    setSafariErrorMSG("", true, msgId);
                    hideDialog('#dialogSecond');
                    proceedForReviewUploadSafari(files[0]);
                    document.getElementById(inputId).value = "";
                }

            }
            video.src = URL.createObjectURL(files[0]);
        }
    }




    const isVideo = (filename) => {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'm4v':
            case 'avi':
            case 'mpg':
            case 'mp4':
            case 'webm':
            case 'mov':
                // etc
                return true;
        }
        return false;
    }

    const getExtension = (filename) => {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    const proceedForReviewUpload = (file) => {

        let fileSize = (file.size / (1024 * 1024)).toFixed(2);
        if (fileSize > 100){
            showAlert(messages.LONG_SIZE);
            recordAgain();
            SendErrorReporting();
            return;
        }
        var reader = new FileReader();
        isBackEnable = true;
        reader.onload = function (e) {
            let blob;
            if(getOS() == "Mac OS"){
                blob = new Blob([reader.result],{type: "video/mp4"});
                if(file.name){
                    let splited = file.name.split(".");
                    if(splited[splited.length - 1] == "mov" || splited[splited.length - 1] == "MOV"){
                        setTimeout(() => {
                                var x = document.getElementById("my-video").getBoundingClientRect();
                                $(".preview-err-info").css({"left" : (x.left + 10) + "px", "top": (x.top + 10) + "px"});
                                $(".preview-err-info").removeClass("d-none");
                            }, 500);

                    }
                }
            }
            else{
                blob = new Blob([reader.result]);
            }
            const url = URL.createObjectURL(blob, {type: "video/mp4"});
            $("#mainPage").addClass("d-none");
            $("#recordPage").addClass("d-none");
            $("#subPage").removeClass("d-none");
            $('#my-video').attr('src', url);
        };
        reader.readAsArrayBuffer(file);
        videofile = file;
    }

    const proceedForReviewUploadSafari = (file) => {

        let fileSize = (file.size / (1024 * 1024)).toFixed(2);

        if (fileSize > 100){
            showAlert(messages.LONG_SIZE);
            recordAgain();
            SendErrorReporting();
            return;
        }
        var reader = new FileReader();
        isBackEnable = true;
        reader.onload = function (e) {
            // const blob = new Blob([reader.result]);
            // const url = e.target.result;
            const blob = new Blob([reader.result], {type: "video/mp4"});
            // let myFile = new File([blob], 'video.mp4', {
            //         type: "video/mp4",
            //     });
            const url = URL.createObjectURL(blob, {type: "video/mp4"});
            $("#mainPage").addClass("d-none");
            $("#recordPage").addClass("d-none");
            $("#subPage").removeClass("d-none");
            $('#my-video').attr('src', url);
        };
        // reader.readAsArrayBuffer(file);
        reader.readAsArrayBuffer(file);
        videofile = file;
        // reader.readAsDataURL(file);

    }

    const recordAgain = () => {
        localStorage.setItem("is_recording_start", "false");
        isBackEnable = false;
        let video = document.getElementById("my-video");
        $(".preview-err-info").addClass("d-none");
        video.pause();
        $("#subPage").addClass("d-none");
        $("#recordPage").addClass("d-none");
        $("#mainPage").removeClass("d-none");
        $(".overlay-div-first").show();
        $(".overlay-div-first-after").hide();
        $(".after-video").hide();
        $(".before-video").show();
        resetForm();
    }

    const setErrorMSG = (message, is_hide = false) => {
        if (is_hide == true) {
            if (isBlockedDialog == true) {
                $('#errorMsgNew').html("");
            } else {
                $('#errorMsg').html("");
            }

        } else {
            if (isBlockedDialog == true) {
                $('#errorMsgNew').html(message);
            } else {
                $('#errorMsg').html(message);
            }
        }
    }



    const setSafariErrorMSG = (message, is_hide = false, msgId) => {
        if (is_hide == true) {
            $('#'+msgId).html("");
        } else {
            $('#'+msgId).html(message);
        }
    }

    const captureCamera = async (callback) => {

        try {
            if(isSafari == true){
                recordPagePreview();
            }else{
                let options;
                if(getOS() == "Mac OS"){
                    options = {
                        width: { min: 480, ideal: 480, max: 480 },
                        height: { min: 320, ideal: 320, max: 320 },
                    }
                }else{
                    options = true;
                }
                    navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: options
                }).then(function (camera) {
                    stream = camera;
                    localStorage.removeItem("is_md_blc");
                    let video = document.getElementById("recordVideo");
                    recordPagePreview();
                    video.muted = true;
                    video.volume = 0;
                    video.srcObject = camera;
                    video.play();
                }).catch(function (error) {
                    localStorage.setItem("is_md_blc", "true");
                    checkForMediaAccess();
                });
            }
            // }
            // });
        } catch (err) {
            // setErrorMSG(messages.AUDIO_VIDEO_ACESS_DENIED);
            localStorage.setItem("is_md_blc", "true");
            checkForMediaAccess();
        }
    }

    const checkForMediaAccess = () => {
        let isBlocked = localStorage.getItem("is_md_blc");
        if (isBlocked && isBlocked == 'true') {
            isBlockedDialog = true;
            $("#normalDialog").addClass("d-none");
            $("#acessDialog").removeClass("d-none");
            setErrorMSG(messages.AUDIO_VIDEO_ACESS_DENIED);
        } else {
            if (localStorage.getItem("is_recording_start") && localStorage.getItem("is_recording_start") == 'true') {
                isBlockedDialog = true;
                $("#normalDialog").addClass("d-none");
                $("#acessDialog").removeClass("d-none");
                setErrorMSG(messages.ALREADY_START_RECORDING);
            } else {
                localStorage.setItem("is_recording_start", "false");
                isBlockedDialog = false;
                $("#acessDialog").addClass("d-none");
                $("#normalDialog").removeClass("d-none");
                setErrorMSG("", true);
            }
        }
    }

    const recordPagePreview = () => {
        localStorage.setItem("is_recording_start", "true");
        hideDialog('#dialogSecond');
        $("#subPage").addClass("d-none");
        $("#mainPage").addClass("d-none");
        $("#recordPage").removeClass("d-none");
        $("#timer").text("Start");
        $("#readyCnt").html("3");
    };

    const isMediaAllow = () => {
        showDialog('#dialogSecond');
        try {
            navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            }).then(function (camera) {

                localStorage.removeItem("is_md_blc");
                setTimeout(() => {
                    checkForMediaAccess();
                }, 300);

                return;
            }).catch(function (error) {
                localStorage.setItem("is_md_blc", "true");
                setTimeout(() => {
                    checkForMediaAccess();
                }, 300);
                return;
            });
        } catch (err) {
            localStorage.setItem("is_md_blc", "true");
            setTimeout(() => {
                checkForMediaAccess();
            }, 300);
        }
    };
    const conditionalFunction = () => {
        if($('#videoId').length > 0)
        {
            let video = document.getElementById("videoId");
         video.contentWindow.postMessage( '{"event":"command", "func":"pauseVideo", "args":""}', '*');
        }

    // $('#c_video')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
        if (localStorage.getItem("is_md_blc") && isSafari == false) {
            isMediaAllow();
        } else {
            showDialog('#dialogSecond');
        }
    }

    const checkFotStartOrStopRecording = () => {

        if (!interval) {
            if ($("#startButton").hasClass("played-btn")) {

                if ($("#timer").text() != "Start") {
                    let second = $("#timer").text().split(":")[1];
                    if (Number(second) < 55 && Number(second) != "00") {
                        $("#startButton").removeClass("played-btn");
                        stopRecording();
                    } else {
                        return;
                    }
                } else {
                    $("#startButton").removeClass("played-btn");
                    stopRecording();
                }
            } else {
                isBackEnable = true;
                $("#readyCnt").removeClass("d-none");
                $("#startButton").addClass("played-btn");
                interval = setInterval(startReadycnt, 1000);
            }
        } else {
            $("#readyCnt").addClass("d-none");
            $("#startButton").removeClass("played-btn");
            clearInterval(interval);
            interval = undefined;
            $("#readyCnt").html(3);
            return;
        }
    }

    const startReadycnt = () => {
        let cnt = Number($("#readyCnt").html());
        cnt--;
        if (cnt == 0) {
            $("#readyCnt").html("GO");
            $(".overlay-div-first").hide();
            $(".overlay-div-first-after").show();
            $(".after-video").show();
            $(".before-video").hide();
            setTimeout(() => {
                clearReadyCnt();
                interval = undefined;
            }, 200);

        } else {
            $("#readyCnt").html(cnt);
        }
    }

    const clearReadyCnt = () => {
        $("#redTimer").attr('hidden', false);
        $("#timer").addClass("c-start-btn");
        $("#readyCnt").addClass("d-none");
        startRecording();
        clearInterval(interval);
        interval = undefined;
        if(getOS() == "Mac OS"){
            startTimer(((60 * 2) - 1), $("#timer"));
        }else{
            startTimer(((60 * 4) - 1), $("#timer"));
        }
    }

    const startTimer = (duration, display) => {
        var timer = duration,
            minutes, seconds;
        if(getOS() == "Mac OS"){
            $("#timer").text('02' + ":" + '00');
        }else{
            $("#timer").text('04' + ":" + '00');
        }

        timeInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (minutes == 0 && seconds <= 25) {
                $("#timer").css("color", "red");
            }
            if (minutes == 0 && seconds == 0) {
                clearInterval(timeInterval);
                $("#startButton").removeClass("played-btn");
                setTimeout(() => {
                    stopRecording();
                }, 1000);
            }

            $("#timer").text(minutes + ":" + seconds);

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }

    const stopRecordingCallback = () => {
        uploadType = 1;
        if(getOS() == "Mac OS"){
            var blob = new Blob(chunks, {
                type: 'video/mp4'
            });
                const myFile = new File([blob], 'video.mp4', {
                    type: "video/mp4",
                });
                // video.src = URL.createObjectURL(seekableBlob);

               recorder.stop();
                recorder = null;
                proceedForReviewUploadSafari(myFile);
                // let filename = Math.random().toString(36).substring(2, 15) + Math.random().toString(23).substring(2, 5);
                // invokeSaveAsDialog(seekableBlob, filename+'.webm');
            // });
        }else{
                getSeekableBlob(recorder.getBlob(), function (seekableBlob) {
                const myFile = new File([seekableBlob], 'video.webm', {
                    type: seekableBlob.type,
                });
                // video.src = URL.createObjectURL(seekableBlob);

                recorder.camera.stop();
                recorder.destroy();
                recorder = null;
                proceedForReviewUpload(myFile);
                // let filename = Math.random().toString(36).substring(2, 15) + Math.random().toString(23).substring(2, 5);
                // invokeSaveAsDialog(seekableBlob, filename+'.webm');
            });
        }

    }

    const startRecording = () => {
        if(getOS() == "Mac OS"){
            recorder = new MediaRecorder(stream,{mimeType: 'video/mp4'});

            recorder.addEventListener('dataavailable', onRecordingReady);

            recorder.start(1000);
        }else{
            recorder = RecordRTC(stream, {
                type: 'video'
            });

            recorder.startRecording();
            recorder.camera = stream;
        }
    };

    const onRecordingReady = (e) => {
        if (e.data.size > 0) {
            chunks.push(e.data);
        }
    }

    const stopRecording = async () => {
        if (document.fullscreenElement) {
            await document.exitFullscreen();
        }
        if (timeInterval) {
            clearInterval(timeInterval);
            $("#redTimer").attr('hidden', true);
            $("#timer").removeClass("c-start-btn");
            $("#timer").css("color", "white");
        }
        if (recorder) {
            if(getOS() == "Mac OS"){
                stopRecordingCallback();
            }else{
                recorder.stopRecording(stopRecordingCallback);
            }
        }

    };

    function uploadUserData() {
        let app_id = {{ $data[0]->app_id }};
        let is_paid = {{$data[0]->is_paid}};
        let app_platform = {{$data[0]->platform}};
        let name = $("input[name=name]").val();
        let email = $("input[name=email]").val();
        let country = $("#country").find(':selected').val();
        let designation = $("input[name=designation]").val();
        // $("body").css("overflow", "hidden");
        $("body").css({"overflow": "hidden","position": "fixed"});
        let video = document.getElementById("my-video");
        video.pause();
        var resumable = new Resumable({
            // Use chunk size that is smaller than your maximum limit due a resumable issue
            // https://github.com/23/resumable.js/issues/51
            chunkSize: 1 * 1024 * 1024, // 1MB
            simultaneousUploads: 5,
            testChunks: false,
            throttleProgressCallbacks: 1,
            // Get the url from data-url tag
            target: '{{url('uploadChunkFile')}}',
            method: 'POST',
            // Append token to the request - required for web routes
            query: {_token: $('meta[name="csrf-token"]').attr('content')}
        });
        if (!resumable.support) {
            console.log("error");
        } else {
            // Show a place for dropping/selecting files


            // Handle file add event
            resumable.on('fileAdded', function (file) {
                resumable.upload();
            });
            resumable.on('fileSuccess', function (file, message) {
                console.log('file success')
                let successRes = JSON.parse(message);
                // setTimeout(() => {
                // }, 2000);
                var result = bowser.getParser(window.navigator.userAgent);
                let browser = "Chrome";
                let version = "Not Found";
                let platform = "Not Found";
                const ua = window.navigator.userAgent;
                if(window.navigator.userAgent){
                    browser = result.parsedResult.browser.name;
                    version = result.parsedResult.browser.version;
                    // platform = result.parsedResult.platform.type;
                    if ((/iPad|iPod/.test(navigator.platform) ||
                        (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)) && !window.MSStream) {
                         platform = "ipad";
                    }
                   else{
                    platform = result.parsedResult.platform.type;
                   }

                }else{
                    browser = "Safari";


                }
                queryParams = JSON.parse(localStorage.getItem("urm_params"));
                if(queryParams && queryParams[""] != 'undefined'){
                    queryParams = {
                        testimonial_come_from: queryParams.utm_tcf,
                        is_purchased: queryParams.utm_ip,
                        is_login: queryParams.utm_il,
                        social_user_id: queryParams.utm_suid,
                        country_code: queryParams.utm_cc || "",
                        platform: queryParams.utm_pf,
                        device_name: queryParams.utm_dn || "",
                        url_d : queryParams.utm_pi
                    };
                }else{
                    queryParams={};
                }
                if(platform == 'ipad')
                {
                    platform =platform.charAt(0) + platform.charAt(1).toUpperCase() + platform.slice(2) ;
                }
                else{
                    platform = platform.charAt(0).toUpperCase() + platform.slice(1)
                }
                let data = {
                    app_id: app_id,
                    is_paid: is_paid,
                    app_platform: app_platform,
                    name: name,
                    email: email,
                    country: country,
                    designation: designation,
                    webp_thumbnail: successRes.webp_thumbnail,
                    file_name: successRes.name,
                    user_info: {
                        browser_name: browser,
                        upload_type: uploadType,
                        device_platform: getOS(),
                        device_os_version: version,
                        device_type: platform,
                        ...queryParams
                    }
                };
                let form_Data = new FormData();
                form_Data.append('request_body', JSON.stringify(data));
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('uploadData') }}',
                    data: form_Data,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        let code = data.code;
                        let message = data.message;
                        if (code == 200) {
                            clearInterval(timerInterval);
                            $("#circProgress").css("background", `conic-gradient(#31B4CC 100%, #ededed 100%)`);
                            $("#circProgress span").html(`100%`);
                            setTimeout(() => {
                                // $("body").css("overflow", "auto");
                                $('#loader').addClass('d-none');
                                $('#thank-loader').removeClass('d-none');
                                $("#circProgress").css("background", `conic-gradient(#31B4CC 0%, #ededed 0%)`);
                                $("#circProgress span").html(`0%`);
                            }, 500);

                        } else {
                            clearInterval(timerInterval);
                            // $("body").css("overflow", "auto");
                            $("body").css({"overflow": "auto","position": "relative"});
                            $('#loader').addClass('d-none');
                            $("#circProgress").css("background", `conic-gradient(#31B4CC 0%, #ededed 0%)`);
                            $("#circProgress span").html(`0%`);
                            showAlert('Unable to upload the video please try again');
                        }

                    },
                    error: function (err) {
                        clearInterval(timerInterval);
                        // $("body").css("overflow", "auto");
                        $("body").css({"overflow": "auto","position": "relative"});
                        $('#loader').addClass('d-none');
                        $("#circProgress").css("background", `conic-gradient(#31B4CC 0%, #ededed 0%)`);
                        $("#circProgress span").html(`0%`);
                        showAlert('Unable to upload the video please try again');
                    },
                });
            });
            resumable.on('fileError', function (file, message) {
                clearInterval(timerInterval);
                // $("body").css("overflow", "auto");
                $("body").css({"overflow": "auto","position": "relative"});
                $('#loader').addClass('d-none');
                $("#circProgress").css("background", `conic-gradient(#31B4CC 0%, #ededed 0%)`);
                $("#circProgress span").html(`1%`);
                showAlert('Unable to upload the video please try again');
            });
            resumable.on('fileProgress', function (file) {
                // Handle progress for both the file and the overall upload
                let cnt = Math.floor(file.progress() * 100);
                if(cnt == 0){
                    cnt = 1;
                }
                if (cnt < 95) {
                    manageCircularProgress(cnt);
                }
            });
            resumable.addFile(videofile);
        }

    }

    const manageCircularProgress = (cnt) => {
        isBackEnable = true;
        $("#backOverlay").show();
        $("#backOverlay").css("height", "100%");
        $('#loader').removeClass('d-none');
        $("#circProgress").css("background", `conic-gradient(#31B4CC ${cnt}%, #ededed ${cnt}%)`);
        $("#circProgress span").html(`${cnt}%`);
    }

    const closeDialog = () => {
        // $("#backOverlay").hide();
        $('#thank-loader').addClass('d-none');
        // $("#backOverlay").css("height: 100vh");
        // $("body").css("overflow", "auto");
        $("body").css({"overflow": "auto","position": "relative"});
        recordAgain();
    }

    const resetForm = () => {
        resetFormerror();
        $("input[type='text'],input[type='email'],select").val('');
        $('#invalidCheck').prop('checked', false);
        $('#checkid').text('');
    }

    const validInput = (type, val, nval,flag) => {
        if (type == 'text') {

            let txtval = $('#' + val).val().toString();
            let txt2 = txtval.trim(txtval);

            if (txt2.length == 0) {
                if(flag == 'false')
            {
                $("#" + nval).removeClass("d-none");
                $("#" + nval).parent().children("input").addClass("error-border");
            }

                // $("#pname").removeClass("d-none");
                // $("#pname").parent().children("input").addClass("error-border");
                // $('#' + nval).text("Please enter your name");
                // showAlert("Please enter your name");
            } else {
                $("#" + nval).addClass("d-none");
                $("#" + nval).parent().children("input").removeClass("error-border");
            //     $("#pname").addClass("d-none");
            // $("#pname").parent().children("input").removeClass("error-border");
                // $('#pname').text("");

            }

        } else if (type == 'email') {
            let txtval = $('#' + val).val().toString();
            let txt2 = txtval.trim(txtval);
            if (txt2.length == 0) {
                if(flag == 'false')
                {
                    $("#" + nval).removeClass("d-none");
                $("#" + nval).parent().children("input").addClass("error-border");
                $("#" + nval).children("span").text("Please enter your email.")
                }

                // showAlert("Please enter your email");
            } else if (!validateEmail($('#' + val).val())) {
                if(flag == 'false')
                {
                    $("#" + nval).removeClass("d-none");
                $("#" + nval).parent().children("input").addClass("error-border");
                $("#" + nval).children("span").text("Please enter your valid email.")
                }

                // showAlert("Please enter valid email");
            } else {
                $("#" + nval).addClass("d-none");
                $("#" + nval).parent().children("input").removeClass("error-border");
                $("#" + nval).children("span").text("");
                // $('#'+nval).text("");
            }
        } else if (type == 'designation') {
            let txtval = $('#' + val).val().toString();
            let txt2 = txtval.trim(txtval);
            if (txt2.length == 0) {
                if(flag == false)
                {
                    $("#" + nval).removeClass("d-none");
                $("#" + nval).parent().children("input").addClass("error-border");
                }

                // $('#'+nval).text("Please enter your designation");
                // showAlert("Please enter your designation");
            } else {
                $("#" + nval).addClass("d-none");
                $("#" + nval).parent().children("input").removeClass("error-border");
                // $('#'+nval).text("");
            }
        } else if ($('#' + val).is('select') == true) {

            if ($('#' + val).val() == '') {
                if(flag == 'false')
                {
                $("#" + nval).removeClass("d-none");
                $("#" + nval).parent().children("input").addClass("error-border");
                }

                // $('#'+nval).text("Please select your country");
                // showAlert("Please select your country");
            } else {
                $("#" + nval).addClass("d-none");
                $("#" + nval).parent().children("input").removeClass("error-border");
                // $('#'+nval).text("");
            }

        }
        else   if(type == 'chkbox')
        {
            if($(val).checked == false)
           {
                $("#" + nval).removeClass("d-none");

            // $('#'+id).text("please check the checkbox");

            // $("#" + nval).parent().children("input").addClass("error-border");
           }
           else{
            // $('#'+id).text("");
            $("#" + nval).addClass("d-none");
                // $("#" + nval).parent().children("input").removeClass("error-border");
           }
        }

    }

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);

    }

    function checkvalidate() {
        let name = $('#name').val().toString();
        let email = $('#email').val();
        let designation = $('#designation').val();
        let country = $('#country').val();
        let chbx = $('#invalidCheck').is(':checked');

        let inputval = name.trim(name);
        let input2 = email.trim(email);
        let desinput = designation.trim(designation);
        let coninput = country.trim(country);


        if (inputval.length == 0) {
            // showAlert('Please enter your name');
            $("#pname").removeClass("d-none");
            $("#pname").parent().children("input").addClass("error-border")
        } else if (input2.length == 0) {
            // showAlert('Please enter your email');
            $("#pname").addClass("d-none");
            $("#pname").parent().children("input").removeClass("error-border")
            $("#eid").removeClass("d-none");
            $("#eid").parent().children("input").addClass("error-border");
            $("#eid").children("span").text("Please enter your email.");
        } else if (!validateEmail(input2)) {
            // showAlert('Please enter valid email');
            $("#pname").addClass("d-none");
            $("#pname").parent().children("input").removeClass("error-border")
            $("#eid").removeClass("d-none");
            $("#eid").parent().children("input").addClass("error-border");
            $("#eid").children("span").text("Please enter your valid email.")
        } else if (desinput.length == 0) {
            $("#eid").addClass("d-none");
            $("#eid").parent().children("input").removeClass("error-border");
            $("#eid").children("span").text("");
            $("#desid").removeClass("d-none");
            $("#desid").parent().children("input").addClass("error-border")
            // showAlert('Please enter your designation');
        } else if (coninput.length == 0) {
            // showAlert('Please select your country');
            $("#desid").addClass("d-none");
            $("#desid").parent().children("input").removeClass("error-border")
            $("#cid").removeClass("d-none");
            $("#cid").parent().children("input").addClass("error-border")
        } else if (chbx != true) {
            // showAlert('Sorry you need to confirm to give the permission');
            $("#cid").addClass("d-none");
            $("#cid").parent().children("input").removeClass("error-border")
            $("#checkid").removeClass("d-none");
            $("#checkid").parent().children("input").addClass("error-border")
        }
            //    else if(input2.length >1)
            //    {
            //     if(!validateEmail(input2))
            //        {
            //         $('#eid').text('please enter valid email');
            //        }
        //    }
        else {
            resetFormerror();
            uploadUserData();
        }
        if(document.querySelectorAll('.em:not(.d-none)')[0]){
            document.querySelectorAll('.em:not(.d-none)')[0].scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    const resetFormerror = () =>{
            $("#pname").addClass("d-none");
            $("#pname").parent().children("input").removeClass("error-border");
            $("#eid").addClass("d-none");
            $("#eid").parent().children("input").removeClass("error-border");
            $("#desid").addClass("d-none");
            $("#desid").parent().children("input").removeClass("error-border");
            $("#cid").addClass("d-none");
            $("#cid").parent().children("input").removeClass("error-border");
            $("#checkid").addClass("d-none");
            $("#checkid").parent().children("input").removeClass("error-border");
    }

    const showAlert = (title) => {
        toastMixin.fire({
            title,
            icon: 'error'
        });
    }

    const checkFileCallInfo = (e, id, msgId) => {
        if(isSafari == true){
            checkSafariFileInfo(e, id, msgId);
        }else{
            checkFileInfo(e);
        }
    }

    const getOS = () => {
        try{
            var userAgent = window.navigator.userAgent,
            result = bowser.getParser(window.navigator.userAgent);
            platform =window.navigator.platform,
            macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
            windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
            iosPlatforms = ['iPhone', 'iPad', 'iPod'],
            os = null;
            if (macosPlatforms.indexOf(platform) !== -1) {
                os = 'Mac OS';
            }
            else if (iosPlatforms.indexOf(platform) !== -1) {
                os = 'iOS';
            }
             else if (windowsPlatforms.indexOf(platform) !== -1) {
                os = 'Windows';
            } else if (/Android/.test(userAgent)) {
                os = 'Android';
            } else if (/Linux/.test(platform)) {
                os = 'Linux';
            }
            else if(navigator.appVersion.indexOf("Mac") != -1 || navigator.userAgent.indexOf("Mac") != -1)
            {
                os = 'Mac OS';
            }

            return os;
        }catch(err) {
            return '-';
        };

    }

    const SendErrorReporting = () => {
        $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('api/errorReportingViaMail')}}',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        let code = data.code;
                        let message = data.message;
                        if (code == 200) {
                            return;
                        } else {
                            showAlert('Unable to connect with server please try again');
                        }
                    },
                    error: function (err) {
                        showAlert('Unable to connect with server please try again');
                    },
                });
    }

    if(window.innerWidth > 820){
        if (navigator.userAgent.indexOf('Mac') != -1) {
            $(".overlay-div-second").css({"top" : "39%" , "height" : "52%"});
        }
    }

</script>
</body>

</html>
