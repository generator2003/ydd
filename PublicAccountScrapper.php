<?php

use InstagramScraper\Instagram;

require __DIR__ . '/vendor/autoload.php';

class PublicAccountScrapper {

    const USER_NAME = 'zapashny.ru';
    const FILE_DIR = 'media/';

    protected $instaScrapper;

    /**
     *  Start Date Больше чем END Date по timestamp число Едем от нынешнего числа вниз
     * @var int
     */
    protected $startDate = 1540425600; // 25 октября

    protected $endDate = 1541001314; // 31 октября
//    protected $endDate = 1538352000;  // Начало октября

    protected $postsCount = Settings::POST_COUNT;

    // Array medias to save to csv
    protected $mediasToCsv = [];

    public function __construct() {
//        $this->instaScrapper = new \InstagramScraper\Instagram();
        $this->instaScrapper =Instagram::withCredentials('oleg_molekulo', 'Landau009!', '/home/oleg/projects/ydd2/cache'); ;
        //$this->postsCount = Settings::POST_COUNT;
    }

    /**
     * @param $userName
     * @param $startDate
     * @param $endDate
     * @throws \InstagramScraper\Exception\InstagramException
     * @throws \InstagramScraper\Exception\InstagramNotFoundException
     */
    public function getPostsByPeriod($userName, $startDate, $endDate)
    {
        $medias = $this->instaScrapper->getMedias($userName, $this->postsCount);

        $mediaByDateArray = [];
        foreach ($medias as $media) {
            if($this->checkMediaByDatePeriod($media, $startDate, $endDate)) {
                $mediaByDateArray[] = $media;
                $this->prepareMediaToCsv($media);
            }
        }

        $this->writeToCsvFile($this->mediasToCsv, $userName, $startDate, $endDate);
    }

    /**
     * @return array
     */
    protected function getCsvHeader()
    {
//        $mediaCsv['link'] = 'Cсылка';
//        $mediaCsv['comment_number'] = 'Количество коментариев';
//        $mediaCsv['likes_number'] = 'Количество лайков';
//        $mediaCsv['media_type'] = 'Медиа тип';
//        $mediaCsv['created_at'] = 'Пост создан';
//        $mediaCsv['caption'] = "Заголовок";

        $mediaCsv['link'] = 'Cсылка';
        $mediaCsv['comment_number'] = 'Количество коментариев';
        $mediaCsv['likes_number'] = 'Количество лайков';
        $mediaCsv['media_type'] = 'Медиа тип';
        $mediaCsv['video_view'] = 'Просмотры видео';
        $mediaCsv['created_at'] = 'Пост создан';
        $mediaCsv['actions_summ'] = 'Сумма действий';
        $mediaCsv['caption'] = "Заголовок";

        return $mediaCsv;
    }

    /**
     * @param $datas
     */
    protected function writeToCsvFile($datas, $userName, $startDate, $endDate)
    {
        $fileName = self::FILE_DIR . $userName ."_". $startDate ."_". $endDate . ".csv";
        $output = fopen($fileName,'w') or die("Can't open file: " .  $fileName);
        fputcsv($output, $this->getCsvHeader());

        foreach($datas as $data) {
            fputcsv($output, $data);
        }

        fclose($output) or die("Can't close php://output");
        echo 'Скачиваем Файл:</br><a href="'.$fileName.'">' . $fileName . '</a></br>';
    }


    /**
     * @param \InstagramScraper\Model\Media $media
     */
    protected function prepareMediaToCsv(\InstagramScraper\Model\Media $media)
    {
        $mediaCsv['link'] = $media->getLink();
        $mediaCsv['comment_number'] = $media->getCommentsCount();
        $mediaCsv['likes_number'] = $media->getLikesCount();
        $mediaCsv['media_type'] = $media->getType();
        $mediaCsv['video_view'] = $media->getVideoViews();
        $mediaCsv['created_at'] = date("Y-m-d H:i:s", $media->getCreatedTime());
        $mediaCsv['actions_summ'] = (int) $media->getLikesCount() + (int) $media->getCommentsCount();
        $mediaCsv['caption'] = $media->getCaption();

        $this->mediasToCsv[] = $mediaCsv;
    }

    /**
     * @param \InstagramScraper\Model\Media $media
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    protected function checkMediaByDatePeriod(\InstagramScraper\Model\Media $media, $startDate, $endDate)
    {
//        if (!($media->getCreatedTime() <= $startDate && $media->getCreatedTime() >= $endDate)) {
//            return false;
//        }

        // TODO использовать эту проверку позднее START DATE должен быть меньше чем END DATE
        if (!($media->getCreatedTime() <= $endDate && $media->getCreatedTime() >= $startDate)) {
            return false;
        }

        return true;
    }


//    public function execute()
//    {
//        $medias = $this->instaScrapper->getMedias($this->accUsername, $this->postsCount);
//
//        $aa = 0;
//
//        foreach ($medias as $media) {
//
////            echo "Media info:\n";
////            echo "Id: {$media->getId()}\n";
////            echo "Shotrcode: {$media->getShortCode()}\n";
////            echo "Created at: {$media->getCreatedTime()}\n";
////            echo "Created at: " . date("Y-m-d  H:i:s ", $media->getCreatedTime()). " :: " .  $media->getCreatedTime() . " \n";
////            echo "Caption: {$media->getCaption()}\n";
////            echo "Number of comments: {$media->getCommentsCount()}\n";
////            echo "Number of likes: {$media->getLikesCount()}\n";
////            echo "Get link: {$media->getLink()}\n";
////            echo "High resolution image: {$media->getImageHighResolutionUrl()}\n";
////            echo "Media type (video or image): {$media->getType()}\n";
//
////            $aa++;
////            if ($aa >= 1) {
////                exit;
////            }
//        }
//        /*$account = $media->getOwner();
//        echo "Account info:\n";
//        echo "Id: {$account->getId()}\n";
//        echo "Username: {$account->getUsername()}\n";
//        echo "Full name: {$account->getFullName()}\n";
//        echo "Profile pic url: {$account->getProfilePicUrl()}\n";*/
//
////        echo "Media info:\n";
////        echo "Id: {$media->getId()}\n";
////        echo "Shotrcode: {$media->getShortCode()}\n";
////        echo "Created at: " . date("Y-m-d  H:i:s ", $media->getCreatedTime()). " :: " .  $media->getCreatedTime() . " \n";
////        echo "Caption: {$media->getCaption()}\n";
////        echo "Number of comments: {$media->getCommentsCount()}\n";
////        echo "Number of likes: {$media->getLikesCount()}\n";
////        echo "Get link: {$media->getLink()}\n";
////        echo "High resolution image: {$media->getImageHighResolutionUrl()}\n";
////        echo "Media type (video or image): {$media->getType()}\n";
//
//
//// If account private you should be subscribed and after auth it will be available
////$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
////$instagram->login();
////$medias = $instagram->getMedias('private_account', 100);
//    }
}
