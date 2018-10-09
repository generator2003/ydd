<?php

require __DIR__ . '/vendor/autoload.php';

class getMediaByUserName {

    const USER_NAME = 'zapashny.ru';

    protected $instagramm;

    protected $postsCount = 100;

    public function __construct() {
        $this->instagramm = new \InstagramScraper\Instagram();
        $this->accUsername = self::USER_NAME;
    }

    public function execute()
    {
        $medias = $this->instagramm->getMedias($this->accUsername, $this->postsCount);

        $aa = 0;

        foreach ($medias as $media) {

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
    }


    protected function getPostsByPeriod($startPeriod, $endPeriod) {

    }

}


$ss = new getMediaByUserName();
$ss->execute();


