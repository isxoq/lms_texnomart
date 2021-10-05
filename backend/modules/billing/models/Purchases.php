<?php

namespace backend\modules\billing\models;

use backend\modules\kursmanager\models\Kurs;
use common\models\User;
use soft\db\SActiveRecord;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "purchases".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $course_id
 * @property int|null $created_at
 * @property float|null $amount
 * @property int|null $order_id
 * @property float|null $teacher_fee
 * @property float|null $platform_fee
 * @property int|null $cancelled_time
 * @property string|null $payment_type
 * @property int|null $transaction_id
 * @property-read User $user
 * @property-read Kurs $course
 * @property int|null $status
 */
class Purchases extends SActiveRecord
{


    const PURCHASE_ACCEPTED = 4;
    const PURCHASE_CANCELLED = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id', 'created_at', 'order_id', 'cancelled_time', 'transaction_id', 'status'], 'integer'],
            [['amount', 'teacher_fee', 'platform_fee'], 'number'],
            [['payment_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'amount' => Yii::t('app', 'Amount'),
            'order_id' => Yii::t('app', 'Order ID'),
            'teacher_fee' => Yii::t('app', 'Teacher Fee'),
            'platform_fee' => Yii::t('app', 'Platform Fee'),
            'cancelled_time' => Yii::t('app', 'Cancelled Time'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }


    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Kurs::class, ['id' => 'course_id']);
    }


    /**
     * @param false $isPlatform
     * @param null $user_id
     * @param null $course_id
     * @return bool|int|mixed|string|null
     */
    public static function totalRevenue($isPlatform = false, $course_id = null)
    {
        $purchases = parent::find();

        if ($course_id) {
            $purchases->andWhere(['course_id' => $course_id]);
        }

        if ($isPlatform) {
            return $purchases->sum('platform_fee');
        } else {
            $purchases->andWhere(['user_id' => user()->id]);
            return $purchases->sum('teacher_fee');
        }


    }
}
