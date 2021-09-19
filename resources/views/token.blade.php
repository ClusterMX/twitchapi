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


    <p>Codigo: {{ $code }}</p>
    <form action="https://id.twitch.tv/oauth2/token" method="post">
        {{-- @csrf --}}
        <input type="hidden" name="client_id" value="usgzw5f481gonmhmlwkm93gifo0d6t">
        <input type="hidden" name="client_secret" value="h5gux7o0jhxrx81n64gnt0cjue67cs">
        <input type="hidden" name="code" value="{{ $code }}">
        <input type="hidden" name="grant_type" value="authorization_code">
        <input type="hidden" name="redirect_uri" value="https://twitchapi.clustermx.com/success">
        <button class="ui twitch button">
            <i class="twitch icon"></i> Ver datos de subs
        </button>

    </form>



</body>
</html>
