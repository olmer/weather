<?php

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Weather_Curl.php';

$picture = new Weather_Curl();
$picture->savePicture();
