<?php

namespace backend\modules\botmanager\models;

use soft\db\SActiveRecord;
use Yii;

/**
 * This is the model class for table "bot_user_action".
 *
 * @property int $id
 * @property int|null $bot_user_id
 * @property int|null $kurs_id
 */
class BotUserAction extends SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bot_user_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_user_id', 'kurs_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bot_user_id' => Yii::t('app', 'Bot User ID'),
            'kurs_id' => Yii::t('app', 'Kurs ID'),
        ];
    }
}
