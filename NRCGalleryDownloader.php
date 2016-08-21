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
        if ($result = @file_get_contents($url)) {
            $result = json_decode($result);

            $this->title = date("Y-m-d H:i", $result->when / 1000 + 8*60*60) . ' ' . $result->typeText;
            $this->photos = $result->photos;

            echo '<pre><p>' . $this->title . '</p></pre>';

            echo '<pre>';
            foreach ($this->photos as $photo) {
                echo '<p>' . $photo->original . '</p>';
            }
            echo '</pre>';
        } else {
            throw new Exception("Bad Request!", 500);
        }
    }
}

try {
    $id = trim($_GET['id']);
    $NRCGalleryDownloader = new NRCGalleryDownloader($id);
    $NRCGalleryDownloader->run();
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}

