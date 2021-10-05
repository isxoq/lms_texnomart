<?php

namespace backend\modules\octouz\models;

use backend\modules\ordermanager\models\Order;

use Yii;

/**
 * This is the model class for table "octouz_transactions".
 *
 * @property int $id
 * @property string|null $shop_transaction_id
 * @property string|null $octo_payment_UUID
 * @property string|null $octo_pay_url
 * @property string|null $status
 * @property int|null $error
 * @property string|null $errorMessage
 * @property string|null $transfer_sum
 * @property string|null $refunded_sum
 * @property-read mixed $order
 * @property int|null $created_at
 */
class OctouzTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'octouz_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['error', 'created_at'], 'integer'],
            [['shop_transaction_id', 'octo_payment_UUID', 'octo_pay_url', 'status', 'errorMessage', 'transfer_sum', 'refunded_sum'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shop_transaction_id' => Yii::t('app', 'Shop Transaction ID'),
            'octo_payment_UUID' => Yii::t('app', 'Octo Payment Uuid'),
            'octo_pay_url' => Yii::t('app', 'Octo Pay Url'),
            'status' => Yii::t('app', 'Status'),
            'error' => Yii::t('app', 'Error'),
            'errorMessage' => Yii::t('app', 'Error Message'),
            'transfer_sum' => Yii::t('app', 'Transfer Sum'),
            'refunded_sum' => Yii::t('app', 'Refunded Sum'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'shop_transaction_id']);
    }
}