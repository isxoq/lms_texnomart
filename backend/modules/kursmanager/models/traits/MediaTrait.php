<?php

namespace backend\modules\kursmanager\models\traits;

use Yii;
use backend\modules\kursmanager\models\Lesson;
use Monolog\Logger;
use Streaming\FFMpeg;
use Streaming\Format\X264;
use yii\base\ErrorException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Trait MediaStreamTrait for Lesson class
 * @property string $orgSrcPath
 * @property string $streamPath
 * Lesson classi uchun videoni stream qilishga mo'ljallangan method(lar)
 * @package backend\modules\kursmanager\models\traits
 */
trait MediaTrait
{

    //<editor-fold desc="Original source methods" defaultstate="collapsed">

    /**
     * Yuklanayotgan video uchun random url generatsiya qilish va shu url bo'yicha papka hosil qilish
     * @return string[]
     * @throws \yii\base\Exception
     */

    public function generateUrl()
    {
        $security = Yii::$app->security;
        $mediaUrl = '/media/org_src/' . $security->generateRandomString(10) . "_" . uniqid();
        $directory = Yii::getAlias('@frontend/web/') . $mediaUrl;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, 0777);
        }
        return [
            'mediaUrl' => $mediaUrl,
            'directory' => $directory,
        ];
    }


    /**
     * Lessonning original videosining diskdagi joylashgan manzilini topish
     * @return string original videoning diskdagi manzili
     */
    public function getOrgSrcPath()
    {

        if ($this->media_org_src == null) {
            return false;
        }
        return Yii::getAlias('@frontend/web') . $this->media_org_src;
    }

    /**
     * Medianing original videosini va shu video joylashgan papkani o'chirib tashlaydi jfnv
     * @return bool
     */
    public function deleteOrgSrc()
    {
        /** @var Lesson $this */

        $filePath = $this->orgSrcPath;

        if (empty($filePath) || !is_file($filePath)) {
            return true;
        }

        unlink($filePath);
        $directory = dirname($filePath);
        try {
            FileHelper::removeDirectory($directory);
        } catch (ErrorException $e) {
            return true;
        }

        return true;
    }


    // </editor-fold>

    //<editor-fold desc="Stream methods" defaultstate="collapsed">


    /**
     * Mediani stream qilish uchun url generatsiya qilish va shu url bo'yicha papka hosil qilish
     * @return string[]
     * @throws yii\base\Exception
     */
    public function generateStreamPath()
    {
        /** @var Lesson $this */

        $security = Yii::$app->security;
        $path = '/media/stream/' . $this->kurs->id . '/' . $this->id . md5(microtime() . time()) . '/' . $security->generateRandomString(32);
        $keyUrl = $path . DIRECTORY_SEPARATOR . $security->generateRandomString(15) . "/key.key";
        $streamUrl = $path . "/stream";
        $streamDirectory = Yii::getAlias('@frontend/web') . $path . "/stream";
        $keyDirectory = Yii::getAlias('@frontend/web') . $keyUrl;

        return [
            'streamUrl' => $streamUrl,
            'keyUrl' => $keyUrl,
            'keyDirectory' => $keyDirectory,
            'streamDirectory' => $streamDirectory,
        ];

    }

    /**
     * Mediadagi orgiginal videoni stream qilish
     * @throws Yii\base\Exception
     */
    public function createStream()
    {

        $osName = Yii::$app->help->osName;

        if ($osName == 'WIN') {
            $ffmpegPath = "/FFmpeg/bin/ffmpeg.exe";
            $ffprobePath = "/FFmpeg/bin/ffprobe.exe";
        } else {
            $ffmpegPath = "/FFmpegLinux/ffmpeg";
            $ffprobePath = "/FFmpegLinux/ffprobe";
        }

        $config = [
            'ffmpeg.binaries' => Yii::getAlias('@common/lib') . $ffmpegPath,
            'ffprobe.binaries' => Yii::getAlias('@common/lib') . $ffprobePath,
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12,   // The number of threads that FFmpeg should use
        ];

        $log = new Logger('FFmpeg_Streaming');

        $ffmpeg = FFMpeg::create($config, $log);

        /** @var Lesson $this */

        $mediaSrc = $this->getOrgSrcPath();
        $streamPath = $this->generateStreamPath();
        $video = $ffmpeg->open($mediaSrc);
        $format = new X264();

//        $format->on('progress', function ($video, $format, $percentage) {
//            TODO: Must create  Socket here
//        });

        $hls = $video->hls();
        $metadata = $hls->metadata();
        $duration = intval($metadata->getFormat()->get('duration'));
        $this->media_stream_src = $streamPath['streamUrl'] . ".m3u8";
        $this->media_duration = $duration;
        /*    $streamMetadata = $hls
                ->setFormat($format)
                ->autoGenerateRepresentations([720])
                ->metadata()->getStreamsMetadata();*/

//        $this->stream_metadata = Json::encode($streamMetadata);
        $this->save();

        set_time_limit(0);

        $hls->setFormat($format)
            ->encryption($streamPath['keyDirectory'], $streamPath['keyUrl'], 5)
            ->autoGenerateRepresentations([720])
            ->save($streamPath['streamDirectory']);
        return true;
    }

    /**
     * Medianing stream qilingan videosining diskdagi joylashgan manzilini topish
     * @return string  stream qilingan videoning diskdagi manzili
     */
    public function getStreamPath()
    {
        if ($this->media_stream_src == null) {
            return false;
        }
        return Yii::getAlias('@frontend/web') . $this->media_stream_src;
    }


    /**
     * Medianing  stream qilingan videosini va shu video joylashgan papkalarni (agar shu papkalar bo'sh bo'lsa )
     * o'chirib tashlaydi
     * @return bool
     * @throws \yii\base\ErrorException
     */
    public function deleteStream()
    {
        $filePath = $this->streamPath;
        $this->clearMediaData();
        if ($filePath == false || !is_file($filePath)) {
            return true;
        }

        $directory = dirname($filePath);
        $parentDirectory = dirname($directory);

        try {
            FileHelper::removeDirectory($directory);
        } catch (ErrorException $e) {

        }

        try {
            FileHelper::removeDirectory($parentDirectory);
        } catch (ErrorException $e) {

        }

        return true;
    }

    public function getHasStreamedVideo()
    {
        return !empty($this->media_stream_src);
    }

    // </editor-fold>

    //<editor-fold desc="Additional" defaultstate="collapsed">

    public function getHasMedia(): bool
    {
        return $this->media_stream_src != null;
    }

    public function clearMediaData()
    {
        $this->media_stream_src = null;
        $this->media_org_src = null;
        $this->media_size = 0;
        $this->media_duration = 0;
        $this->media_extension = null;
        //        $this->status = 0;
        $this->stream_status = Lesson::NO_MEDIA;
        $this->save();
    }


    public function getYoutubeVideoDuration()
    {
        return Yii::$app->help->getYoutubeVideoDuration($this->media_stream_src, 'AIzaSyC96-oYXkK6TCzUmw9MbmubQH1GZNlUTrU');
    }


    //</editor-fold>

    //<editor-fold desc="Upload Media" defaultstate="collapsed">

    public function uploadMedia()
    {

        $mediaFile = UploadedFile::getInstance($this, 'src');

        if (!$mediaFile) {
            return $this->uploadError("Yuklash uchun media fal topilmadi!");
        }

        $generatedUrl = $this->generateUrl();
        $mediaUrl = $generatedUrl['mediaUrl'];
        $directory = $generatedUrl['directory'];

        $allowedExtensions = settings('upload', 'allowed_video_types');
        $allowedExtensionsAsArray = explode(',', $allowedExtensions);

        if (!in_array($mediaFile->extension, $allowedExtensionsAsArray)) {
            return $this->uploadError("Faqat quyidagi kengaytmali fayllarni yuklashga ruxsat berilgan: $allowedExtensions");
        }

        $uid = uniqid(time(), true);
        $fileName = $uid . '.' . $mediaFile->extension;
        $filePath = $directory . '/' . $fileName;

        if (!$mediaFile->saveAs($filePath)) {
            return $this->uploadError($this->uploadErrorMessage($mediaFile->error));
        }

        $path = $mediaUrl . DIRECTORY_SEPARATOR . $fileName;

        $this->deleteOrgSrc();
        $this->deleteStream();

        $this->media_org_src = $path;
        $this->media_size = $mediaFile->size;
        $this->media_extension = $mediaFile->extension;
        $this->stream_status = Lesson::MUST_BE_STREAMED;

        if (!$this->save(false)) {
            return $this->uploadError($this->error);
        }

        return [
            'status' => 200,
            'message' => "Video muvaffaqiyatli yuklandi! Yuklangan videoni birozdan so'ng ko'rishingiz mumkin",
            'data' => [],
        ];

    }

    public function uploadError($message = "Xatolik yuz berdi", $status = 500)
    {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    public function uploadErrorMessage($error_code)
    {
        $errors = [
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        ];

        return $errors[$error_code] ?? 'Unknown error';

    }


    //</editor-fold>
}