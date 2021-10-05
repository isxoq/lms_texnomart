<?php

namespace backend\modules\billing\models;

use Yii;

/**
 * This is the model class for table "payouts".
 *
 * @property int $id
 * @property string $document_file
 * @property int $teacher_id
 * @property string $payment_type
 * @property int|null $payout_time
 * @property float $amount
 * @property string|null $description
 * @property int $status
 * @property int|null $cancelled_time
 */
class Payouts extends \soft\db\SActiveRecord
{


    const STATUS_SUCCESS = 1;
    const STATUS_CANCELLED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payouts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_file', 'teacher_id', 'payment_type', 'amount'], 'required'],
            [['teacher_id', 'payout_time', 'status', 'cancelled_time'], 'integer'],
            [['amount'], 'number'],
            [['document_file', 'payment_type', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'document_file' => Yii::t('app', 'Document File'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'payout_time' => Yii::t('app', 'Payout Time'),
            'amount' => Yii::t('app', 'Amount'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'cancelled_time' => Yii::t('app', 'Cancelled Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getUserPayouts()
    {
        $query = Payouts::find()
                ->andWhere(['status' => Payouts::STATUS_SUCCESS])
                ->andWhere(['teacher_id' => user('id')])
                ->sum('amount') ?? 0;
        return $query;
    }
}
