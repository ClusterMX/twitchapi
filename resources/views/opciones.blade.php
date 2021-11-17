<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <button id="btn1" class="button login-button button--twitch" data-platform="twitch">
        <i class="fab fa-twitch"></i>
        <span>Estrellas</span>
    </button>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/15a0d76b97.js" crossorigin="anonymous"></script>
    <script>
        $('#btn1').click(function(e) {
            e.preventDefault();

            // ga('send', 'event', 'firstLogin', 'click', 'twitch', '1');

            var client_id = "{{ env('TWITCH_CLIENT_ID') }}";
            var redirect = "{{ env('TWITCH_REDIRECT_URI') }}";


            window.location = "{{ route('estrellas'), $user_id, $token }}";
        });
    </script>
</body>
</html>
