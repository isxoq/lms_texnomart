<?php

namespace backend\modules\usermanager\models;

use soft\behaviors\DeleteFileBehavior;
use soft\db\SActiveQuery;
use soft\db\SActiveRecord;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "teacher_application".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $message
 * @property string|null $comment
 * @property string|null $doc
 * @property string|null $filePath
 * @property bool $hasFile
 * @property int|null $status
 * @property int|null $created_at
 * @property string $speciality [varchar(255)]
 * @property bool $is_ready [tinyint(1)]
 *
 * @property User $user
 * @property-read mixed $statusLabel
 * @property-read string $downloadFileButton
 * @property-read bool $isConfirmed
 * @property-read bool $isNew
 * @property-read bool $isCancelled
 * @property-read mixed $acceptedLabel
 * @property mixed|null $fileUrl
 */
class TeacherApplication extends SActiveRecord
{

    public const STATUS_NEW = 5;
    public const STATUS_WAITING = 7;
    public const STATUS_ACCEPTED = 10;
    public const STATUS_CANCELLED = 0;

    public static function tableName()
    {
        return 'teacher_application';
    }

    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at'], 'integer'],
            [['message', 'comment'], 'string'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            [['doc', 'speciality'], 'string', 'max' => 255],
            ['is_ready', 'boolean'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            [
                'class' => DeleteFileBehavior::class,
                'attributes' => 'doc',
            ]

        ]);
    }


    public function setAttributeLabels()
    {
        return [
            'user_id' => 'User',
            'status' => 'Status',
            'downloadFileButton' => 'Fayl',
            'message' => "Xabar",
            'comment' => "Izoh",
            'approveButton' => "Tasdiqlash",
            'speciality' => "Yo'nalish",
            'is_ready' => 'Kurs tayyormi?'
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => [],
            'createdByAttribute' => 'user_id',
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => false,
            'invalidateCacheTags' => 'teacherApplication',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function find()
    {
        return new SActiveQuery(get_called_class());
    }

    public function getFilePath()
    {
        if ($this->doc == '') {
            return '';
        }
        $file = Yii::getAlias('@frontend/web/') . $this->doc;
        return $file;
    }

    public function getFileUrl()
    {
        return Yii::getAlias('@homeUrl') . $this->doc;
    }

    public function getHasFile()
    {
        return is_file($this->filePath);
    }

    public function getDownloadFileButton()
    {
        if (!$this->hasFile) {
            return '<span class="not-set">-</span>';
        }
        return a("<i class='fa fa-download'></i> ", ['teacher-application/download-file', 'id' => $this->id], ['data-pjax' => 0, 'title' => 'Faylni yuklab olish']);
    }

    public function getApproveButton($options = [])
    {
        $options = ArrayHelper::merge($options, [
            'data-pjax' => 0,
            'title' => "Tasdiqlash",
            'visible' => !$this->isConfirmed,
            'data' => [
                'toggle' => 'tooltip',
                'method' => 'post',
                'confirm' => "Rostdanham tasqilaysizmi? Yana bir o'ylab ko'ring ... :)",
                'confirm-title' => "Ishonchingiz komilmi???",
                'confirm-message' => "Rostdanham tasqilaysizmi? Yana bir o'ylab ko'ring ... :)",
            ],
        ]);
        return a("<i class='fa fa-check-circle'></i> Tasdiqlash", ['teacher-application/approve', 'id' => $this->id], $options);
    }

    //<editor-fold desc="Labels" defaultstate="collapsed">

    public function getStatusLabel()
    {
        if ($this->status == self::STATUS_ACCEPTED) {
            return $this->acceptedLabel;
        }
        if ($this->status == self::STATUS_WAITING) {
            return Html::tag('span', 'Kutmoqda', ['class' => 'badge badge-round badge-warning']);
        }
        if ($this->status == self::STATUS_NEW) {
            return Html::tag('span', 'Yangi', ['class' => 'badge badge-round badge-danger']);
        }
        if ($this->status == self::STATUS_CANCELLED) {
            return Html::tag('span', 'Bekoq qilindi', ['class' => 'badge badge-round badge-light']);
        }
    }

    public function getAcceptedLabel()
    {
        return Html::tag('span', 'Tasdiqlandi', ['class' => 'badge badge-round badge-success']);
    }

    //</editor-fold>
    public function approve()
    {
        $user = $this->user;
        if ($user == null) {
            not_found("Foydalanuvchi topilmadi!!!");
        }

        if ($user->makeTeacher()) {
            TeacherApplication::updateAll(['status' => TeacherApplication::STATUS_ACCEPTED], ['user_id' => $user->id, 'status' => TeacherApplication::STATUS_NEW]);
            Yii::$app->session->setFlash('success', "Ariza tasdiqlandi!!!");
        } else {
            Yii::$app->session->setFlash('error', "Xatolik yuz berdi");

        }

    }

    public function getIsConfirmed()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    public function getIsNew()
    {
        return $this->status == self::STATUS_NEW;
    }

    public function getIsCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }


    public static function newAppliesCount()
    {
        return static::find()->andWhere(['status' => self::STATUS_NEW])->count();
    }

}
