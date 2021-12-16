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

//$accName   = $argv[1];
//$startDate = convertStartDateToTimestamp($argv[2]);
//$EndDate   = convertEndDateToTimestamp($argv[3]);

//
//https://instagram.com/animonda.ru   C 1го Янаваря и по сегодня
//https://instagram.com/evercleanru   C 1го Янаваря и по сегодня
//https://instagram.com/naturaltrainerru C 1го июня

//


$accName   = 'oleg_molekulo';
$startDate = convertStartDateToTimestamp('01.06.2021');
$EndDate   = convertEndDateToTimestamp('17.12.2021');
print_r($startDate);
echo "\nAAAA\n";
print_r($EndDate);




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
    $dateTime = DateTime::createFromFormat('d.m.Y', $date, new DateTimeZone("UTC"));
    if (!$dateTime) {
        echo 'bad date format use d.m.y example 21.10.2018';
    }
    return $dateTime->setTime(0,0,0)->getTimestamp();
}

function convertEndDateToTimestamp($date)
{
    $dateTime = DateTime::createFromFormat('d.m.Y', $date, new DateTimeZone("UTC"));
    if (!$dateTime) {
        echo 'bad date format use d.m.y example 21.10.2018';
    }
    return $dateTime->setTime(23,59,59)->getTimestamp();
}