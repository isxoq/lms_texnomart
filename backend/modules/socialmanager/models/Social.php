<?php

namespace backend\modules\socialmanager\models;

use Yii;
use soft\db\SActiveQuery;
use yii\caching\TagDependency;
use yii\helpers\Html;

/**
 *
 * @property-read mixed $iconField
 * @property int $id [int(11)]
 * @property string $icon [varchar(255)]
 * @property string $name [varchar(255)]
 * @property string $url [varchar(255)]
 * @property int $status [int(2)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Social extends \soft\db\SActiveRecord
{
    #region ActiveRecord methods

    public static function tableName()
    {
        return 'social';
    }

    public function rules()
    {
        return [
            [['icon', 'url'], 'required'],
            [['status'], 'integer'],
            [['icon', 'name', 'url'], 'string', 'max' => 255],
        ];
    }

    #endregion

    #region SActiveRecord methods

    public function setAttributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Icon',
            'name' => 'Name',
            'url' => 'Url',
            'status' => 'Status',
            'iconField' => t('Icon'),
        ];
    }

    public function setAttributeNames()
    {
        return [
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
//            'multilingualAttributes' => ['title', 'text'],
            'invalidateCacheTags' => 'social',

        ];
    }

    public function getIconField()
    {
        return Html::tag("i", "", ['class' => "{$this->icon}"]);
    }


    public static function getDataForClientSide()
    {
        return Yii::$app->db->cache( function ($db){
          return static::find()->active()->select('icon,url,status')->asArray()->all();
        }, null, new TagDependency(['tags' => 'social']));
    }
}
