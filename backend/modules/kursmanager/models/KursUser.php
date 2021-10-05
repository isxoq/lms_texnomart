<?php

namespace backend\modules\kursmanager\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "kurs_user".
 *
 * @property int $id [int(11)]
 * @property int $kurs_id
 * @property int $user_id
 * @property int|null $is_admin
 *
 * @property Kurs $kurs
 * @property User $user
 */
class KursUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kurs_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kurs_id', 'user_id'], 'required'],
            [['kurs_id', 'user_id', 'is_admin'], 'integer'],
            [['kurs_id', 'user_id'], 'unique', 'targetAttribute' => ['kurs_id', 'user_id']],
            [['kurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['kurs_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kurs_id' => 'Kurs ID',
            'user_id' => 'User ID',
            'is_admin' => 'Is Admin',
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
}
