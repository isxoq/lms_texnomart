<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $image
 * @property string|null $link
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class Partner extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'partner';
    }

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['status'], 'integer'],
            [['image', 'link'], 'string', 'max' => 255],
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


    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query;
    }

    public static function getDataForIndexPage()
    {
        return static::find()->active()->asArray()->select('image,link,status')->all();
    }
}
