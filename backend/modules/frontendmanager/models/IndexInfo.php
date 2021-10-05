<?php

namespace backend\modules\frontendmanager\models;

use yeesoft\multilingual\behaviors\MultilingualBehavior;
use yeesoft\multilingual\db\MultilingualLabelsTrait;
use yeesoft\multilingual\db\MultilingualQuery;
use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "index_info".
 *
 * @property int $id
 * @property string|null $icon
 * @property bool $status [tinyint]
 */
class IndexInfo extends \soft\db\SActiveRecord
{

    public static function tableName()
    {
        return 'index_info';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'icon'], 'required'],
            ['status', 'integer'],
            [['icon'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'icon' => Yii::t('app', 'Icon'),
        ];
    }

    public static function find()
    {
        $query = parent::find();
        return $query->multilingual();
    }

    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => false,
            'createdAtAttribute' => false,
            'updatedAtAttribute' => false,
            'multilingualAttributes' => ['title', 'content'],
            'invalidateCacheTags' => ['indexInfo'],
        ];
    }


    public static function getDataForAboutPage()
    {
        return Yii::$app->db->cache( function ($db){
            return static::find()->active()->asArray()->all();
        }, null, new TagDependency(['tags' => 'indexInfo']));
    }
}
