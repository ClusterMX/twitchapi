<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://oss.maxcdn.com/semantic-ui/2.2.10/semantic.min.css">
</head>
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
<body>


    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, ducimus pariatur fugiat natus mollitia quasi impedit repellendus dolor illo quaerat. Quia quo atque provident aliquam culpa, quidem deserunt perspiciatis! Magni?



    <p>Codigo: {{ $code }}</p>
    <form action="https://id.twitch.tv/oauth2/token" method="post">
        {{-- @csrf --}}
        <input type="hidden" name="client_id" value="{{ app('TWITCH_CLIENT_ID') }}">
        <input type="hidden" name="client_secret" value="{{ app('TWITCH_CLIENT_SECRET') }}">
        <input type="hidden" name="code" value="{{ $code }}">
        <input type="hidden" name="grant_type" value="authorization_code">
        <input type="hidden" name="redirect_uri" value="https://twitchapi.clustermx.com/success">
        <button class="ui twitch button">
            <i class="twitch icon"></i> Ver datos de subs
        </button>

    </form>



</body>
</html>
