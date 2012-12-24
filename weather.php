<?php
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Weather_Curl.php';
$pictures = new Weather_Curl();
$latestPicNum = $pictures->getPicturesCount() % Weather_Curl::PICTURES_NUM;
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="/js/jquery.cycle.all.js"></script>
<style>
    #cycle_weather {
        margin: 0 auto;
    }

    .controls-container {
        position: absolute;
        width: 28px;
        left: 50%;
    }
    #controls {
        position: absolute;
        width: 28px;
        left: -408px;
        top: 18px;
    }

    #controls a {
        display: block;
        width: 28px;
        border: 1px solid #ccc;
        text-decoration: none;
        margin: 3px 5px;
        padding: 3px 5px;
        font-size: 10px;
        font-family: Helvetica, serif;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
    }

    #controls a.activeSlide {
        background: #10a4bf;
        color: white;
    }
</style>
<script>
    $(function () {
        $('#cycle_weather')
            .before('<div class="controls-container"><div id="controls"></div></div><br/>')
            .cycle({
                fx:'fade',
                speed:'fast',
                timeout:0,
                speed:300,
                next:'#cycle_weather',
                pager:'#controls',
                pagerAnchorBuilder: function (k, v) {
                    return '<a href="">' + $(v).attr('data-time-created') + '</a>';
                }
            });
    });
</script>
</head>
<body>
<div id="cycle_weather"><?php
    for ($ii = Weather_Curl::PICTURES_NUM + $latestPicNum; $ii > $latestPicNum; $ii--) {
        $picNum = $ii % Weather_Curl::PICTURES_NUM;
        $time = @filemtime(__DIR__ . '/weather_pictures/weather_cache_file' . $picNum . '.png');
        ?><img src="/weather_pictures/weather_cache_file<?php echo $picNum?>.png" alt="weather" data-time-created="<?php echo date('H:i', $time)?>"/><?php
    }
    ?>
</div>
</body>
</html>