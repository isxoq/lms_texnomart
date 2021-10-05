<?php

namespace backend\modules\octouz\models;

use Yii;

/**
 * This is the model class for table "octouz".
 *
 * @property int $id
 * @property string|null $secret
 * @property int|null $shop_id
 * @property int|null $auto_capture
 * @property int|null $test
 * @property string|null $return_url
 * @property string|null $notify_url
 * @property string|null $ttl
 * @property int|null $status
 */
class Octouz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'octouz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'auto_capture', 'test', 'ttl', 'status'], 'integer'],
            [['secret', 'return_url', 'notify_url','currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'secret' => Yii::t('app', 'Secret'),
            'shop_id' => Yii::t('app', 'Shop ID'),
            'auto_capture' => Yii::t('app', 'Auto Capture'),
            'test' => Yii::t('app', 'Test'),
            'return_url' => Yii::t('app', 'Return Url'),
            'notify_url' => Yii::t('app', 'Notify Url'),
            'ttl' => Yii::t('app', 'Ttl'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}