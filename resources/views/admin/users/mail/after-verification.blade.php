<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap');

        @font-face {
            font-family: Raleway-bold;
            src: url(https://testimonial.graphicdesigns.co.in/assets/css/testimonial/ralewey/Raleway-Bold.ttf) format("opentype");
            /* 700 */
        }

        @font-face {
            font-family: Inter-Regular;
            src: url(https://testimonial.graphicdesigns.co.in/assets/css/testimonial/font-inter/Inter-Regular.otf);
            /* 400 */
        }

        @font-face {
            font-family: Inter-Bold;
            src: url(https://testimonial.graphicdesigns.co.in/assets/css/testimonial/font-inter/Inter-Bold.otf);
            /* 700 */
        }

        @font-face {
            font-family: azofont-Medium;
            src: url(https://testimonial.graphicdesigns.co.in/assets/css/testimonial/azofont/AzoSans-Medium.woff2);
            /* 500 */
        }

        /* * {
            max-width: 685px;
            margin: auto;
        } */
        /* body{
          background-color: #F5F6FA;
        } */

        .email-main {
            padding: 20px 20px;
            margin: 15px 15px;
            background: #FFFFFF;
            box-shadow: 0px 0px 7px rgba(0, 0, 0, 0.17);
            border-radius: 4px;
            max-width: 685px;
            margin: 10px auto;
        }

        .text-submitting {
            font-size: 21px;
            /* margin-top: 9px; */
            /* font-family: "Raleway-bold"; */
            font-family: 'Raleway', sans-serif !important;
            padding: 9px 11px 13px;
            color: #1d1d1d;
        }

        .paragraph-text {
            /* font-family: "Inter-Regular"; */
            font-family: 'Inter', sans-serif !important;
            font-weight: 400 !important;
            font-size: 14px;
            color: #1d1d1d !important;
            line-height: 15px;
        }

        .rainbow-line {
            background: linear-gradient(270deg, #4770FF 0%, #00D1FF 27.08%, #0BCD8C 48.44%, #FFE600 71.88%, #FF0000 100%);
            border-radius: 19px;
            width: 100%;
            height: 3px;
            margin: 20px 0px;
        }

        .visit-app {
            font-size: 12px;
            cursor: pointer;
            padding: 0;
            list-style: none;
            text-decoration: underline;
            /* font-family: "Inter-Regular"; */
            font-family: 'Inter', sans-serif !important;
            font-weight: 400 !important;
            line-height: 16px;
            color: #0085FF;
        }

        .dolor-price {
            font-size: 33px;
            color: rgba(233, 102, 67, 0.8);
            /* font-family: "azofont-Medium"; */
            font-weight: 700 !important;
            font-family: 'Lato', sans-serif !important;
        }

        .card-details {
            /* font-family: "azofont-Medium"; */
            font-weight: 700 !important;
            font-family: 'Lato', sans-serif !important;
            color: rgba(233, 102, 67, 0.8);
            font-size: 13px;
        }

        .image-screen {
            width: 50%;
        }

        .border-text-link {
            color: #0085FF !important;
            text-decoration-color: #0085FF !important;
        }

        .c-user-name {
            font-size: 14px;
            color: #1d1d1d !important;
        }

        .c-bestregards {
            font-size: 13px;
            margin-bottom: 3px;
        }

        .c-bold-name {
            font-size: 13px;
            font-family: 'Inter', sans-serif !important;
            font-weight: 700 !important;
            margin: 0;
        }

        .image-set {
            width: 50px;
            height: 50px;
        }

        .c-visit-apps {
            margin-bottom: 12px;
            font-size: 14px !important;
        }

        .c-mob-view {
            display: none !important;
        }

        .c-user-discription {
            margin-bottom: 20px;
            color: #1d1d1d !important;
        }

        .c-margin {
            margin: 0px;
        }
        .cu-dolor{
            color: #ffffff !important;
            font-size: 40px !important;
            font-family: 'Lato', sans-serif !important;
            font-weight: 900 !important;
        }

        @media only screen and (max-width: 500px) {
            .image-screen {
                width: 100% !important;
            }
            .cu-dolor{
            left: 8% !important;
            font-size: 18px !important;
        }
        }

        @media only screen and (min-width: 600px) {
            .c-user-name {
                font-size: 16px;
                line-height: 20.57px;
                color: #1d1d1d !important;
            }

            .c-user-discription {
                font-size: 16px;
                line-height: 20.57px;
                margin-bottom: 20px;
                color: #1d1d1d !important;
            }

            .card-details {
                font-size: 16px;
            }

            .c-bestregards {
                font-size: 18px !important;
                line-height: 23.19px !important;
            }

            .c-bold-name {
                font-size: 18px !important;
                line-height: 23.19px !important;
            }

            .image-set {
                width: 55px !important;
                height: 55px !important;
            }

            .c-visit-apps {
                font-size: 19px !important;
            }

            .rainbow-line {
                margin: 26px 0px !important;
            }

            .c-web-view {
                display: block;
            }

            .visit-app {
                font-size: 15px;
                line-height: 29px;
            }
        }

        /* @media only screen and (max-width: 684px) {
            .c-mob-view {
                display: block !important;
            }

            .c-web-view {
                display: none !important;
            }
        } */
    </style>
</head>
<body>
<center style="width: 100%; background: #F5F6FA; text-align: left;">
  <div style="margin: 0px; padding: 10px;" bgcolor="#ffffff">
<table class="email-main">
    <tr>
        <td>
            <div>
                <h4 class="paragraph-text c-user-name" style="margin-bottom: 15px;">Hey {{$message_body['user_name']}},</h4>
                <p class="paragraph-text c-user-discription" style="white-space:pre-wrap;">{{$message_body['message']}}</p>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <!-- <h1 class="dolor-price" style="text-align: center;margin: 16px 0 10px 0px;">$10</h1> -->
                <a href="https://www.amazon.com/gp/help/customer/display.html?nodeId=G5D4TA7NBKQT7GW2">
                    <div style="text-align: center !important;position: relative !important;">
                        <img class="image-screen"
                             src="https://testimonial.graphicdesigns.co.in/assets/images/testimonial/amazon.png" alt="">
                    </div>
                </a>
                <div style="margin-bottom: 12px; margin-top: 30px;">
                    <span style="margin: 0px;" class="card-details">Gift Card ID:</span>
                    <span style="margin: 0px;color: rgba(29, 29, 29, 1);"
                          class="card-details">{{$message_body['gift_id']}}</span>
                </div>
                <div style="margin-bottom: 12px;">
                    <span style="margin: 0px;" class="card-details">Gift Card Code:</span>
                    <span style="margin: 0px;color: rgba(29, 29, 29, 1);"
                          class="card-details">{{$message_body['gift_code']}}</span>
                </div>
                @if(isset($message_body['expiry_date']) && $message_body['expiry_date'] != NULL)
                    <div style="margin-bottom: 25px;">
                        <span style="margin: 0px;" class="card-details">Expiration Date:</span>
                        <span style="margin: 0px;color: rgba(29, 29, 29, 1);"
                              class="card-details">{{$message_body['expiry_date']}}</span>
                    </div>
                @endif
                <div style="margin-bottom: 30px;">
                    <span class="card-details"
                          style="color: rgba(29, 29, 29, 1);font-family: 'Montserrat', sans-serif;margin: 0px;">Click Here to </span>
                    <a href="https://www.amazon.com/gp/help/customer/display.html?nodeId=G5D4TA7NBKQT7GW2"
                       class="card-details"
                       style="color: rgba(8, 62, 218, 1); text-decoration: underline;font-family: 'Montserrat', sans-serif;    text-decoration-color: #083EDA !important;">redeem
                        your gift card</a>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="display: flex;align-items: center;">
                @if($message_body['app_platform'] == 3)
                    <a href="{{$message_body['play_store_url']}}" style="margin: 0;">
                        @else
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore={{$message_body['play_store_url']}}&appstore={{$message_body['app_store_url']}}" style="margin: 0;">
                                @endif
                    <div style="display: flex;">
                        <img style="margin-right: 12px;border-radius: 7px;" class="image-set"
                             src="{{$message_body['app_logo']}}" alt="">
                    </div>
                </a>
                <div style="margin: 0px;">
                    <p class="paragraph-text c-bestregards" style="margin: 0px !important;">Best Regards,</p>
                    <p class="paragraph-text c-bold-name"
                       style="font-size: 13px; font-family: 'Inter', sans-serif !important; font-weight: 700 !important;margin: 0px;">
                        The {{$message_body['app_name']}}
                        Team</p>
                </div>
            </div>
            <div class="rainbow-line"></div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <h4 class="paragraph-text c-visit-apps" style="margin: 0px;">Visit Our More Apps:</h4>
                <div class="c-mob-view">
                    <div style="display: flex;">
                        <div style="width: 50%;">
                            <ul class="visit-app">
                            <!-- <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.flyermaker&appstore=https://apps.apple.com/us/app/id1337666644"
                               class="border-text-link">
                                <li class="c-margin">Flyer Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.nra.flyermaker&appstore=https://apps.apple.com/us/app/id1347162740"
                               class="border-text-link">
                                <li class="c-margin">Poster Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.logomaker&appstore=https://apps.apple.com/us/app/id1332661961"
                               class="border-text-link">
                                <li class="c-margin">Logo Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.brochuremaker&appstore=https://apps.apple.com/us/app/id1347160240"
                               class="border-text-link">
                                <li class="c-margin">Brochure Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.optimumbrewlab.invitationcardmaker&appstore=https://apps.apple.com/us/app/id1320828574"
                               class="border-text-link">
                                <li class="c-margin">Invitation Card Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.optimumbrewlab.businesscardmaker&appstore=https://apps.apple.com/us/app/id1319234642"
                               class="border-text-link">
                                <li class="c-margin">Business Card Maker</li>
                            </a> -->
                            </ul>
                        </div>
                        <div style="width: 50%;">
                            <ul class="visit-app">
                            <!-- <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.rollerbannermaker&appstore=https://apps.apple.com/us/app/id1546183729"
                               class="border-text-link">
                                <li class="c-margin">Banner Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.socialcardmaker&appstore=https://apps.apple.com/us/app/id1363852671"
                               class="border-text-link">
                                <li class="c-margin">Social Media Post Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.digitalmarketing.slideshowmaker&appstore=https://apps.apple.com/us/app/id1480483917"
                               class="border-text-link">
                                <li class="c-margin">Marketing Video Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.oneintro.intromaker&appstore=https://apps.apple.com/us/app/id1516421168"
                               class="border-text-link">
                                <li class="c-margin">Intro Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.videomaker.postermaker&appstore=https://apps.apple.com/us/app/id1438099294"
                               class="border-text-link">
                                <li class="c-margin">VideoAdKing</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.nra.productmarketingmaker&appstore=https://apps.apple.com/us/app/id1362417191"
                               class="border-text-link">
                                <li class="c-margin">Product Ad Maker</li>
                            </a> -->
                            </ul>
                        </div>
                    </div>
                </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="c-web-view">
                <div style="display: flex;">
                    <div style="width: 33.33%!important;">
                        <ul class="visit-app" style="padding: 0px;list-style: none;">
                        <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.flyermaker&appstore=https://apps.apple.com/us/app/id1337666644"
                               class="border-text-link">
                                <li class="c-margin">Flyer Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.nra.flyermaker&appstore=https://apps.apple.com/us/app/id1347162740"
                               class="border-text-link">
                                <li class="c-margin">Poster Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.brochuremaker&appstore=https://apps.apple.com/us/app/id1347160240"
                               class="border-text-link">
                                <li class="c-margin">Brochure Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.optimumbrewlab.invitationcardmaker&appstore=https://apps.apple.com/us/app/id1320828574"
                               class="border-text-link">
                                <li class="c-margin">Invitation Card Maker</li>
                            </a>
                        </ul>
                    </div>
                    <div style="width: 33.33%!important;">
                        <ul class="visit-app" style="padding: 0px;list-style: none;">
                        <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.logomaker&appstore=https://apps.apple.com/us/app/id1332661961"
                               class="border-text-link">
                                <li class="c-margin">Logo Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.rollerbannermaker&appstore=https://apps.apple.com/us/app/id1546183729"
                               class="border-text-link">
                                <li class="c-margin">Banner Maker</li>
                            </a>

                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.optimumbrewlab.businesscardmaker&appstore=https://apps.apple.com/us/app/id1319234642"
                               class="border-text-link">
                                <li class="c-margin">Businees card Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.bg.socialcardmaker&appstore=https://apps.apple.com/us/app/id1363852671"
                               class="border-text-link">
                                <li class="c-margin" style="padding-right: 15px;">Social Media Post Maker</li>
                            </a>
                        </ul>
                    </div>
                    <div style="width: 33.33%!important;">
                        <ul class="visit-app" style="padding: 0px;list-style: none;">
                        <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.nra.productmarketingmaker&appstore=https://apps.apple.com/us/app/id1362417191"
                               class="border-text-link">
                                <li class="c-margin">Product Ad Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.oneintro.intromaker&appstore=https://apps.apple.com/us/app/id1516421168"
                               class="border-text-link">
                                <li class="c-margin">Intro Maker</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.videomaker.postermaker&appstore=https://apps.apple.com/us/app/id1438099294"
                               class="border-text-link">
                                <li class="c-margin">VideoAdKing</li>
                            </a>
                            <a href="https://testimonial.graphicdesigns.co.in/app/redirect?playstore=https://play.google.com/store/apps/details?id=com.digitalmarketing.slideshowmaker&appstore=https://apps.apple.com/us/app/id1480483917"
                               class="border-text-link">
                                <li class="c-margin">Marketing Video Maker</li>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <a href="https://photoadking.com/">
                <div style="display: flex;justify-content: center;">
                    <img style="max-width: 100%;height: auto;"
                         src="https://testimonial.graphicdesigns.co.in/assets/images/testimonial/banner.png" alt="">
                </div>
            </a>
        </td>
    </tr>
</table>
</div>
</center>
</body>
</html>
