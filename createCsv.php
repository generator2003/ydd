<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 01.11.18
 * Time: 16:27
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/PublicAccountScrapper.php';
require __DIR__ . '/Settings.php';


$accName   = $_POST['accName'];
$startDate = convertStartDateToTimestamp($_POST['dateStart']);
$EndDate   = convertEndDateToTimestamp($_POST['dateEnd']);

//print_r($_POST);
//exit;

$publicAccountScrapper = new publicAccountScrapper();
try {
    $publicAccountScrapper->getPostsByPeriod($accName, $startDate, $EndDate);
} catch (\InstagramScraper\Exception\InstagramException $e) {
    echo $e->getMessage();
} catch (\InstagramScraper\Exception\InstagramNotFoundException $e) {
    echo $e->getMessage();
}

function convertStartDateToTimestamp($date)
{
//    list($m, $d, $Y) = explode("/",$date);
//    $date = $d . "." . $m . "." . $Y;
//    print_r($date);

    $dateTime = DateTime::createFromFormat('m/d/Y', $date, new DateTimeZone("UTC"));
    if (!$dateTime) {
        echo 'bad date format use d.m.y example 21.10.2018';
    }
    return $dateTime->setTime(0,0,0)->getTimestamp();
}

function convertEndDateToTimestamp($date)
{
//    list($m, $d, $Y) = explode("/",$date);
//    $date = $d . "." . $m . "." . $Y;

    $dateTime = DateTime::createFromFormat('m/d/Y', $date, new DateTimeZone("UTC"));
    if (!$dateTime) {
        echo 'bad date format use d.m.y example 21.10.2018';
    }
    return $dateTime->setTime(23,59,59)->getTimestamp();
}