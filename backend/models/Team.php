<?php

namespace backend\models;

use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $fullname
 * @property int|null $status
 * @property string|null $image
 * @property string|null $socials
 * @property string $position [varchar(255)]
 */
class Team extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'team';
    }

    public function rules()
    {
        return [
            [['fullname', 'position'], 'required'],
            [['status'], 'integer'],
            [['socials'], 'string'],
            [['fullname', 'position', 'image'], 'string', 'max' => 255],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'position' => 'Postion',
            'status' => 'Status',
            'image' => 'Image',
            'socials' => 'Socials',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => [],
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => false, // 'created_at',
            'updatedAtAttribute' => false, //'updated_at',
            'invalidateCacheTags' => 'team',
        ];
    }


    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query;
    }

    public static function getDataAsArray()
    {
        return Yii::$app->db->cache(function ($db) {
            return static::find()->active()->asArray()->all();
        }, null, new TagDependency(['tags' => 'indexInfo']));
    }
}
