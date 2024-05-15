<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>App Redirection</title>
</head>
<body>

<svg style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);width: 50px;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
<circle cx="50" cy="50" fill="none" stroke="#808080" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
</circle></svg>
<script>

    function redirection(){
        let query = get_query();
        let appstore = query.appstore;
        let playstore = query.playstore;
        const userAgent = navigator.userAgent;
        if (/android/i.test(userAgent)) {
            window.location.href = playstore;
        }else if (/iPad|iPhone|iPod/i.test(userAgent)) {
            window.location.href = appstore;
        }else{
            if(navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){
                window.location.href = appstore;
            }else{
                window.location.href = playstore;
            }
        }
    }

    function get_query(){
        var url = location.search;
        var qs = url.substring(url.indexOf('?') + 1).split('&');
        if(qs[0] == ""){
            return {
                playstore : "https://play.google.com/store/apps/details?id=com.bg.flyermaker&referrer=utm_source%3DOB_PAK",
                appstore : "https://apps.apple.com/us/app/flyer-maker-poster-maker/id1337666644"
            }
        }else{
            if(qs[2]){
                return {
                    playstore: qs[0].replace(/(playstore=)/g,"") + "&" + qs[1],
                    appstore: qs[2].replace(/(appstore=)/g,""),
                }
            }else{
                return{
                    playstore: qs[0].replace(/(playstore=)/g,"") + "&referrer=utm_source%3DOB_PAK",
                    appstore: qs[1].replace(/(appstore=)/g,"")
                }
            }
        }
    }
    redirection();
</script>
</body>
</html>
