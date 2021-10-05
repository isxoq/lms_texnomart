<?php

namespace backend\models\usermanager\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property string|null $short_title
 * @property string|null $bio
 * @property string|null $telegram
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $address
 * @property int|null $user_id
 *
 * @property User $user
 */
class UserInfo extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'user_info';
    }

    public function rules()
    {
        return [
            [['short_title', 'bio', 'address'], 'string'],
            [['user_id'], 'integer'],
            [['telegram', 'instagram', 'linkedin', 'twitter', 'youtube'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'id' => 'ID',
            'short_title' => 'Short Title',
            'bio' => 'Bio',
            'telegram' => 'Telegram',
            'instagram' => 'Instagram',
            'linkedin' => 'Linkedin',
            'twitter' => 'Twitter',
            'youtube' => 'Youtube',
            'address' => 'Address',
            'user_id' => 'User ID',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => [],
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => false, // 'created_at',
            'updatedAtAttribute' => false, //'updated_at',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query;
    }
}
