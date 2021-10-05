<?php

namespace backend\models;

use backend\modules\kursmanager\models\Kurs;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rating".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $kurs_id
 * @property int $rate
 * @property int|null $created_at
 *
 * @property Kurs $kurs
 * @property User $user
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rating';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'kurs_id', 'created_at'], 'integer'],
            ['rate', 'integer', 'min' => 0, 'max' => 5],
//            [['kurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['kurs_id' => 'id']],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['rating'] = ['rate'];
        return $scenarios;
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
            'rate' => 'Rate',
            'created_at' => 'Created At',
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

    public static function findOrCreateModel($kurs_id)
    {
        $user_id = Yii::$app->user->getId();

        $model = static::findOne(['kurs_id' => $kurs_id, 'user_id' => $user_id]);

        if ($model == null) {
            $model = new Rating([
                'kurs_id' => $kurs_id,
                'user_id' => $user_id
            ]);
        }
        $model->scenario = 'rating';

        return $model;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->rate = intval($this->rate);
        return true;
    }
}
