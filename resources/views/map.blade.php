<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
</script>
</head>

<body>
    <!-- Scripts -->
    <script src="/js/crafty-min.js"></script>
    <script>
        window.onload = function() {

            Crafty.init();

            Crafty.sprite("images/basic_ground_tiles.png", {
                grass_long: [0,   0, 128, 128],
                grass:      [128, 0, 128, 128],
                stone:      [256, 0, 128, 128],
                dirt:       [384, 0, 128, 128],
            });

            var iso = Crafty.isometric.size(128);

            var prevBase;

            // var grass = Crafty.e("2D, DOM, grass");

            var area = iso.area(); //get the area
            console.log(area);
            for(var y = 0; y <= 20; y++){
                for(var x = 0; x <= 10; x++){
                    var i = Crafty.math.randomInt(0, 3);
                    var tile;
                    switch ( i ) {
                        case 0: tile = 'grass_long'; break;
                        case 1: tile = 'grass'; break;
                        case 2: tile = 'stone'; break;
                        case 3: tile = 'dirt'; break;
                    }
                    var tile = Crafty.e("2D, Canvas, " + tile);
                    iso.place(x, y, 0, tile); //Display tiles in the Screen
                }
            }

            Crafty.addEvent(this, Crafty.stage.elem, "mousedown", function(e) {

                if(e.button > 1) return;

                function scroll(e) {

                    var currBase = {
                        x: e.clientX, 
                        y: e.clientY
                    };

                    if ( prevBase ) {

                        var dX = prevBase.x - currBase.x;
                        var dY = prevBase.y - currBase.y;
                        
                        panMap(dX, dY);

                    }

                    prevBase = currBase;
                };

                function panMap(moveX, moveY){
                    Crafty.viewport.x -= moveX;
                    Crafty.viewport.y -= moveY;
                };

                Crafty.addEvent(this, Crafty.stage.elem, "mousemove", scroll);
                Crafty.addEvent(this, Crafty.stage.elem, "mouseup", function() {
                    Crafty.removeEvent(this, Crafty.stage.elem, "mousemove", scroll);
                    prevBase = null;
                });
            });

        }
    </script>

</body>
</html>