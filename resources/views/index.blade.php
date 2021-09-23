<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="https://oss.maxcdn.com/semantic-ui/2.2.10/semantic.min.css">

    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
</head>

<body>


    <style>
        .login__wrapper-B .login__inner .button {
    text-transform: none;
}

.night .button--twitch {
    background-color: #9146ff;
    color: #fff;
}

    </style>



{{--
    <a href="" class="ui twitch button"> <i class="twitch icon"></i> Connect with twitch</a>--}}

    <button id="connect-with-twitch" class="button login-button button--twitch" data-platform="twitch">
        <i class="fab fa-twitch"></i>
        <span>Continue with Twitch</span>
    </button>




    <script>
        $('#connect-with-twitch').click(function(e) {
            e.preventDefault();

            ga('send', 'event', 'firstLogin', 'click', 'twitch', '1');

            window.location =
                "https://id.twitch.tv/oauth2/authorize?client_id="+{{ env('TWITCH_CLIENT_ID') }}+"&redirect_uri="+{{ env('TWITCH_REDIRECT_URI') }}+"/success&response_type=code&scope=channel:read:subscriptions";
        });
    </script>
</body>

</html>
