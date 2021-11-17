<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



    @foreach ($datos_subs as $ds)

        {{ $i = $loop->index +1 }}

        {{ $aniTime = mt_rand(1, 3); }}
        <div class="star{{ $i }} " style="position: absolute; display:none; animation: glow {{ $aniTime }}s linear alternate infinite;"><i style="font-size: 15px; color:gold;" class="fas fa-star"></i></div>


    @endforeach





    <script>
        function makeDiv(){


            for (let index = 0; index < 10000; index++) {

                var divsize = ((Math.random()*100) + 50).toFixed();
                var color = '#'+ Math.round(0xffffff * Math.random()).toString(16);

                var timeGlow = Math.floor(Math.random() * 1.5) + 1;

                star = document.querySelectorAll(".star");
                var posx = (Math.random() * ($(document).width() - divsize)).toFixed();
                var posy = (Math.random() * ($(document).height() - divsize)).toFixed();

                console.log(index)

                // $(".star"+index).css({'left':posx+'px', 'top':posy+'px', 'animation': 'glow '+timeGlow+'s linear alternate infinite'}).appendTo( 'body' ).fadeIn(100);
                $(".star"+index).css({'left':posx+'px', 'top':posy+'px'}).appendTo( 'body' ).fadeIn(100);


            }



            };

            makeDiv();
    </script>
</body>
</html>
