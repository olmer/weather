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

    #controls {
        margin: 20px auto 0;
        width: 690px;
    }

    #controls a {
        border: 1px solid #ccc;
        text-decoration: none;
        margin: 0 5px;
        padding: 3px 5px;
    }

    #controls a.activeSlide {
        background: #ea0
    }
</style>
<script>
    $(function () {
        $('#cycle_weather')
            .before('<div id="controls"></div><br/>')
            .cycle({
                fx:'fade',
                speed:'fast',
                timeout:0,
                speed:300,
                next:'#cycle_weather',
                pager:'#controls'
            });
    });
</script>
</head>
<body>
<div id="cycle_weather"><?php
    for ($ii = Weather_Curl::PICTURES_NUM + $latestPicNum; $ii > $latestPicNum; $ii--) {
        $picNum = $ii % Weather_Curl::PICTURES_NUM;
        ?><img src="/weather_pictures/weather_cache_file<?php echo $picNum?>.png" alt="weather"/><?php
    }
    ?>
</div>
</body>
</html>