<?php

namespace backend\models;

use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\Kurs;
use common\models\User;
use kartik\mpdf\Pdf;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "certificate".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $kurs_id
 * @property int|null $downloads_count
 * @property int|null $created_at
 * @property int|null $type
 * @property int|null $status
 *
 * @property Kurs $kurs
 * @property-read int $isGeneral
 * @property User $user
 * @property-read Enroll $enroll
 * @property-read string $finishedDate
 * @property int $date [int(11)]  Sertifikat berilgan sana
 */
class Certificate extends ActiveRecord
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * Barcha kurslar uchun sertifikat turi
     */
    public const TYPE_GENERAL = 1;

    /**
     * Kompyuter savodxonligi uchun sertifikat turi
     */
    public const TYPE_COMPUTER_COURSE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'kurs_id', 'downloads_count', 'type', 'status', 'date'], 'integer'],
            ['type', 'in', 'range' => [self::TYPE_GENERAL, self::TYPE_COMPUTER_COURSE]],
            ['type', 'default', 'value' => self::TYPE_GENERAL],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['downloads_count', 'default', 'value' => 0],
            [['kurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['kurs_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'kurs_id' => 'Kurs ID',
            'downloads_count' => 'Downloads Count',
            'created_at' => 'Created At',
            'start_date' => 'Start Date',
            'finish_date' => 'Finish Date',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Kurs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getEnroll()
    {
        return $this->hasOne(Enroll::class, ['user_id' => 'user_id', 'kurs_id' => 'kurs_id']);
    }

    public function getIsGeneral()
    {
        return $this->type = self::TYPE_GENERAL;
    }

    /**
     * Generates a Certificate
     */
    public function generateCertificate($destination = null)
    {

        if ($destination == null) {
            $destination = Pdf::DEST_BROWSER;
        }

        $content = Yii::$app->controller->renderPartial($this->templateView(), ['model' => $this]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => $destination,
            'content' => $content,
            'cssFile' => '@frontend/web/certificate_vd/style/main.css',
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginTop' => 0,
            'marginBottom' => 0,
            'defaultFont' => 'GilroyBold',
        ]);
        return $pdf->render();

    }

    public function templateView()
    {
//        $viewName = $this->isGeneral ? '_general_template' : '_computer_template';
        $viewName = '_general_template';
        return '@backend/views/certificate/' . $viewName;
    }


    public function getFinishedDate()
    {
        return date('d.m.Y', $this->date) . 'y.';
    }
}
