<?php
require __DIR__ . '/../vendor/autoload.php';

// If account is public you can query Instagram without auth

$instagram = new \InstagramScraper\Instagram();
//$medias = $instagram->getMedias('buzova86', 25);
$medias = $instagram->getMedias('zapashny.ru', 25);

$aa = 0;
// Let's look at $media
foreach ($medias as $media) {


 //   $media = $medias[0];

    echo "Media info:\n";
    echo "Id: {$media->getId()}\n";
    echo "Shotrcode: {$media->getShortCode()}\n";
    echo "Created at: {$media->getCreatedTime()}\n";
    echo "Caption: {$media->getCaption()}\n";
    echo "Number of comments: {$media->getCommentsCount()}\n";
    echo "Number of likes: {$media->getLikesCount()}\n";
    echo "Get link: {$media->getLink()}\n";
    echo "High resolution image: {$media->getImageHighResolutionUrl()}\n";
    echo "Media type (video or image): {$media->getType()}\n";

    $aa++;
    if ($aa >= 1) {
        exit;
    }
}
/*$account = $media->getOwner();
echo "Account info:\n";
echo "Id: {$account->getId()}\n";
echo "Username: {$account->getUsername()}\n";
echo "Full name: {$account->getFullName()}\n";
echo "Profile pic url: {$account->getProfilePicUrl()}\n";*/


// If account private you should be subscribed and after auth it will be available
//$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
//$instagram->login();
//$medias = $instagram->getMedias('private_account', 100);
