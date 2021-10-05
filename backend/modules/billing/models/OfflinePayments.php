<?php

namespace backend\modules\billing\models;

use backend\modules\kursmanager\models\Kurs;
use common\models\User;
use Yii;

/**
 * This is the model class for table "offline_payments".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $course_id
 * @property float|null $amount
 * @property string|null $document_file To'lovni tasdiqlovchi hujjat yoki rasm
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $cancelled_at Bekor qilingan vaqt
 * @property int|null $status
 * @property-read User $user
 * @property-read Kurs $course
 * @property-read PaymentTypes|null $paymentType
 * @property string|null $type click,payme....  cash
 */
class OfflinePayments extends \soft\db\SActiveRecord
{

    public $end_at;

    public $duration;

    const ACCEPTED = 1;
    const CANCELLED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offline_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['end_at', 'duration'], 'safe'],
            [['amount', 'type', 'user_id', 'course_id', 'created_at', 'updated_at', 'status'], 'required'],
            [['user_id', 'course_id', 'created_at', 'cancelled_at', 'status'], 'integer'],
            [['amount'], 'number'],
            [['document_file', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeLabels()
    {
        return [
            'user_id' => "Talaba",
            'course_id' => "Kurs",
            'amount' => "Summa",
            'document_file' => "Hujjat",
            'type' => "To'lov turi",
            'duration' => "A'zolikning davomiyligi",
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCourse()
    {
        return $this->hasOne(Kurs::class, ['id' => 'course_id']);
    }

    public function getPaymentType()
    {
        return $this->hasOne(PaymentTypes::class, ['type' => 'type']);
    }

    public static function totalAmount()
    {
        return static::find()->sum('amount');
    }
    public static function formattedTotalamount()
    {
        return Yii::$app->formatter->asSum(static::totalAmount());
    }
}
