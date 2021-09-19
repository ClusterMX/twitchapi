<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="https://oss.maxcdn.com/semantic-ui/2.2.10/semantic.min.css">
</head>

<body>


    <style>
        .ui.twitch.button {
            background-color: #6441A5;
            color: #FFF;
            box-shadow: 0 0 0 0 rgba(34, 36, 38, .15) inset
        }

        .ui.twitch.button:hover {
            background-color: #3B2064
        }

    </style>

    <form action="" method="post">
        {{-- @csrf --}}
        <button class="ui twitch button">
            <i class="twitch icon"></i> Connect with Twitch
        </button>

    </form>

    <a href="https://id.twitch.tv/oauth2/authorize?client_id={{ env('TWITCH_CLIENT_ID') }}&redirect_uri={{ env('TWITCH_REDIRECT_URI') }}/success&response_type=code&scope=channel:read:subscriptions" class="ui twitch button"> <i class="twitch icon"></i> Connect with twitch</a>


</body>

</html>
