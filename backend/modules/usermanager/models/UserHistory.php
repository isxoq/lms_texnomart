<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 30.04.2021, 9:53
 */

namespace backend\modules\usermanager\models;

use common\models\User;
use soft\db\SActiveRecord;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "user_history".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $url
 * @property string|null $prev_url
 * @property string|null $page_title
 * @property int|null $date
 * @property string|null $ip
 * @property string|null $device
 *
 * @property User $user
 * @property-read mixed $deviceTypeName
 * @property-read mixed $formattedDate
 * @property bool $device_type [tinyint(3)]
 */
class UserHistory extends SActiveRecord
{

    public const DEVICE_MOBILE = 1;
    public const DEVICE_TABLET = 2;
    public const DEVICE_DESCTOP = 3;
    public const DEVICE_APP = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date', 'device_type'], 'integer'],
            [['url', 'prev_url', 'page_title', 'device'], 'string'],
            [['ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'url' => 'Url',
            'prev_url' => 'Prev Url',
            'page_title' => 'Page Title',
            'date' => 'Date',
            'ip' => 'Ip',
            'device' => 'Device',
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

    public function getFormattedDate()
    {
        return Yii::$app->formatter->asDatetime($this->date);
    }

    public static function deviceTypes()
    {
        return [

            self::DEVICE_MOBILE => 'Mobile',
            self::DEVICE_TABLET => 'Tablet',
            self::DEVICE_DESCTOP => 'Desctop',
            self::DEVICE_APP => 'App'

        ];
    }

    public function getDeviceTypeName()
    {
        return ArrayHelper::getValue(self::deviceTypes(), $this->device_type);
    }

}
