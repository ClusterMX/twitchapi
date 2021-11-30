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



{{--
    <a href="" class="ui twitch button"> <i class="twitch icon"></i> Connect with twitch</a>--}}

    <a href="{{ route('loginTwitch') }}" class="button login-button button--twitch" data-platform="twitch">
        <i class="fab fa-twitch"></i>
        <span>Continue with Twitch</span>
    </a>










    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/15a0d76b97.js" crossorigin="anonymous"></script>
    <script>
        $('#connect-with-twitch').click(function(e) {
            e.preventDefault();

            // ga('send', 'event', 'firstLogin', 'click', 'twitch', '1');

            var client_id = "{{ env('TWITCH_CLIENT_ID') }}";
            var redirect = "{{ env('TWITCH_REDIRECT_URI') }}";


            window.location = "https://id.twitch.tv/oauth2/authorize?client_id="+client_id+"&redirect_uri="+redirect+"/success&response_type=code&scope=channel:read:subscriptions+user:read:email";
        });




    </script>
</body>

</html>
