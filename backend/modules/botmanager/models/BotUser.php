<?php

namespace backend\modules\botmanager\models;

use soft\db\SActiveRecord;
use Yii;

/**
 * This is the model class for table "bot_user".
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $fio
 * @property string|null $phone
 * @property string|null $step
 * @property int|null $temp_kurs_id
 */
class BotUser extends SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['temp_kurs_id', 'user_id'], 'integer'],
            [['fio', 'phone', 'step'], 'string', 'max' => 255],
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
            'fio' => Yii::t('app', 'Fio'),
            'phone' => Yii::t('app', 'Phone'),
            'step' => Yii::t('app', 'Step'),
            'temp_kurs_id' => Yii::t('app', 'Temp Kurs ID'),
        ];
    }
}
