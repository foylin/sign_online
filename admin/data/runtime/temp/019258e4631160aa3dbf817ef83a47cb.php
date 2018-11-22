<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:55:"themes/admin_simpleboot3/protocol/admin_coor/index.html";i:1542907854;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <style>
        body{
            margin: 0;
            padding: 0;
        }
        #draggable {
            width: 100px;
            height: 20px;
            padding: 0.5em;
            /* position: fixed; */
        }
        .main{
            width: 746px;
            margin: 0 auto;
        }
        .left{
            /* float: left; */
            position: absolute;
            left: 10px;
            top: 10px;
        }
        .left p{
            line-height: 20px;
            margin: 0;
            text-align: center;
        }
        .main img{
            text-align: center;
            border: 1px solid #ccc;
        }
        .data{
            position: fixed;
            top: 80px;            
        }
    </style>
    <script>
        $(function () {
            $("#draggable").draggable({
                stop:function(e,u){
                    console.log(e);
                    console.log(u.position.left);
                    var width = $(window).width();
                    console.log(width);
                    var page = parseInt(u.position.top / 844);
                    var x = u.position.left;
                    var y = u.position.top - (844 * page);
                    var coor = x + ',' + y;
                    $('.getxy').val(coor);
                    $('.getpage').val(page+1);
                }
            });
        });
    </script>

</head>

<body>
    <div class="left">
        <div id="draggable" class="ui-widget-content">
            <p>拖动定位</p>
        </div>
    </div>

    <div class="data">
        <div>页数: <input type="text" class="getpage"> </div>
        <div>坐标: <input type="text" class="getxy" value=""></div>
    </div>

    <div class="main">
        <img src="/static/coor/0.png" alt="">
        <img src="/static/coor/1.png" alt="">
        <img src="/static/coor/2.png" alt="">
        <img src="/static/coor/3.png" alt="">
    </div>
</body>

</html>