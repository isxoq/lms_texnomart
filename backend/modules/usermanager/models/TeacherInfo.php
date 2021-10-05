<?php

namespace backend\modules\usermanager\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "teacher_info".
 *
 * @property int $id
 * @property string|null $skill
 * @property string|null $telegram
 * @property string|null $facebook
 * @property string|null $youtube
 * @property string|null $instagram
 * @property string|null $education_story
 * @property string|null $experience_story
 * @property int|null $user_id
 *
 * @property-read null|array $edcutaionStoryAsArray
 * @property-read mixed $experienceStoryAsArray
 * @property User $user
 */
class TeacherInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['education_story', 'experience_story'], 'safe'],
            [['skill', 'telegram', 'facebook', 'youtube', 'instagram'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'skill' => 'Mutaxassislik',
            'telegram' => 'Telegram',
            'facebook' => 'Facebook',
            'youtube' => 'Youtube',
            'instagram' => 'Instagram',
            'education_story' => "Ta'lim olgan joylar",
            'experience_story' => "Mehnat faoliyati",
        ];
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

    public function getEdcutaionStoryAsArray()
    {
        return Json::decode($this->education_story);
    }
    public function getExperienceStoryAsArray()
    {
        return Json::decode($this->experience_story);
    }
}
