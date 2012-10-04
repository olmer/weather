<?php
class Weather_Curl
{
    const PICTURES_NUM = 20;

    protected $_picturesFolder;

    public function __construct()
    {
        $this->_picturesFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'weather_pictures' . DIRECTORY_SEPARATOR;
    }

    public function getPicturesFolder()
    {
        return $this->_picturesFolder;
    }

    public function getPicturesCount()
    {
        return file_get_contents($this->_picturesFolder . 'temp');
    }

    protected function _getDownloadedContent()
    {
        $url = "http://meteoinfo.by/radar/UKBB/UKBB_latest.png";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
        curl_setopt($ch, CURLOPT_POST, 1); // set POST method
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);
        return $result;
    }

    protected function _processPicture()
    {
        $result = false;
        try {
            $result = $this->_getDownloadedContent();
        } catch (Exception $e) {
            file_put_contents($this->_picturesFolder . 'error_log.txt', $e->getMessage(), FILE_APPEND);
        }

        try {
            if (!$result) {
                throw new Exception('Picture has not downloaded!');
            }
            $picturesCount = $this->getPicturesCount();

            $pastPicPath = $this->_picturesFolder . 'weather_cache_file' . $picturesCount % self::PICTURES_NUM . '.png';
            if (file_exists($pastPicPath)) {
                if ($result === file_get_contents($pastPicPath)) {
                    return false;
                }
            }
            if ($picturesCount >= 10000 || $picturesCount < -1) $picturesCount = -1;
            $picturesCount += 1;
            file_put_contents($this->_picturesFolder . 'temp', $picturesCount);
            file_put_contents($this->_picturesFolder . 'weather_cache_file' . $picturesCount % self::PICTURES_NUM . '.png', $result);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function savePicture()
    {
        $result = $this->_processPicture();

//        $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'weather_pictures' . DIRECTORY_SEPARATOR . 'weather_picture_log.txt';
        date_default_timezone_set('Europe/Kiev');
        if ($result === true) {
            $text = date("H:i:s") . " - Created\n";
        } elseif ($result === false) {
            $text = date("H:i:s") . " - Duplicated\n";
        } else {
            $text = date("H:i:s") . " - " . $result . "\n";
        }

//        file_put_contents($filePath, $text, FILE_APPEND);
    }
}