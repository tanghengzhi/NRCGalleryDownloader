<?php 

class NRCGalleryDownloader {
    public $baseURL = 'http://runclub.nike.com.cn/api/nrc/gallery/';
    public $id;
    public $title;
    public $photos;

    public function __construct ($id) {
        $this->id = $id;
    }

    public function run() {
        $url = $this->baseURL . $this->id;
        $result = json_decode(file_get_contents($url));

        $this->title = date("Y-m-d", $result->when / 1000) . ' ' . $result->typeText;
        $this->photos = $result->photos;

        echo '<h1>' . $this->title . '</h1>';

        foreach ($this->photos as $photo) {
            echo '<p>' . $photo->original . '</p>';
        }
    }
}

try {
    $id = trim($_GET['id']);
    $NRCGalleryDownloader = new NRCGalleryDownloader($id);
    $NRCGalleryDownloader->run();
} catch (Exception $e) {

}

