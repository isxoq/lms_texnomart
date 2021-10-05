<?php

namespace backend\modules\kursmanager\models;

use backend\modules\usermanager\models\User;
use mohorev\file\UploadBehavior;
use soft\behaviors\DeleteFileBehavior;
use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $title
 * @property int|null $lesson_id
 * @property string|null $src Faylning joylashgan manzil
 * @property string|null $org_name faylning haqiqiy nomi
 * @property string|null $extension
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property string|null $description
 *
 * @property Lesson $lesson
 * @property string $type [varchar(255)]  Mime type of the file
 * @property-read mixed $user
 * @property-read mixed $section
 * @property-read mixed $kurs
 * @property-read string|false $filePath
 * @property-read bool $hasFile
 * @property-read string $downloadFileButton
 * @property-read mixed $downloadLink
 * @property-read mixed $formattedSize
 * @property int $size [int(11)] Fayl o'lchami
 */
class File extends \soft\db\SActiveRecord
{

    public const FILE_MAX_SIZE = 5242880; // 5mb
    public const ALLOWED_FILE_TYPES = ['doc', 'docx', "pdf", "txt", 'png', 'jpg', 'jpeg', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'rar'];

    public static function tableName()
    {
        return 'file';
    }

    public function fields()
    {
        return ['id', 'title', 'lesson_id',  'hasFile', 'src',  'formattedSize', 'extension', 'org_name'];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] =
            [
                'class' => DeleteFileBehavior::class,
                'attributes' => 'src',
            ];

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['title', 'lesson_id'], 'required'],
            [['lesson_id', 'created_at', 'updated_at', 'status', 'size'], 'integer'],
            [['description'], 'string'],
            [['title', 'src', 'org_name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 100],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'id' => 'ID',
            'lesson_id' => 'Mavzu',
            'src' => 'Src',
            'org_name' => 'Haiqiqiy nomi',
            'extension' => 'Extension',
            'downloadFileButton' => "Fayl",
            'size' => 'Fayl hajmi',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'createdByAttribute' => false,
            'invalidateCacheTags' => ['file'],

        ];
    }


    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }

    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id'])->via('lesson');
    }

    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id'])->via('section');
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->via('kurs');
    }

    /**
     * Yuklanadigan faylning diskdagi joylashgan manzilini topish
     * @return string faylning diskdagi manzili
     */
    public function getFilePath()
    {
        if ($this->src == null) {
            return false;
        }
        return Yii::getAlias('@frontend/web') . $this->src;
    }

    /**
     * Ushbu fayl manbasi (src) diskda bormi yoki yo'qligini tekshiradi
     * @return bool
     */
    public function getHasFile()
    {
        if (!$this->filePath) {
            return false;
        }
        return is_file($this->filePath);
    }

    /**
     * Faylni diskdan o'chirib tashlash
     * @param bool $clearData agar true bo'lsa, ushbu faylning ma'lumotlarini bazadan tozalaydi
     * @return null|bool
     */
    public function deleteFile($clearData = false)
    {
        if (!$this->hasFile) {
            return null;
        }

        if (!unlink($this->filePath)) {
            return false;
        }

        if ($clearData) {
            $this->src = null;
            $this->org_name = null;
            $this->extension = null;
            $this->type = null;
            $this->size = null;
            $this->save();
        }

        return true;

    }

    public function getDownloadLink()
    {
        return to(['file/download', 'id' => $this->id]);
    }

    public function getDownloadFileButton()
    {
        if (!$this->hasFile) {
            return '';
        }
        return a("Yuklab olish", $this->downloadLink, ['data-pjax' => 0, 'class' => 'btn btn-warning btn-sm'], 'download');
    }

    public function getFormattedSize()
    {
       return Yii::$app->formatter->asFileSize($this->size);
    }

}
