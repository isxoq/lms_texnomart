<?php

namespace backend\modules\pagemanager\models;

use Yii;
use soft\db\SActiveQuery;
use soft\db\SActiveRecord;
use soft\web\SUrlManager;
use yii\helpers\Html;

/**
 *
 * @property-read mixed $pageIcon
 * @property-read mixed $url
 * @property int $id [int]
 * @property string $title [varchar(255)]
 * @property string $description [text]
 * @property string $slug [varchar(127)]
 * @property string $icon_class [varchar(127)]
 * @property int $middle [int]
 * @property int $status [int]
 * @property int $created_at [int]
 * @property int $updated_at [int]
 * @property bool $deletable [tinyint]
 * @property string $idn [varchar(255)]
 */
class Page extends SActiveRecord
{


    public static function tableName()
    {
        return 'page';
    }

    public function rules()
    {
        return [
            [['created_at', 'updated_at','middle','status'], 'integer'],
            [['slug', 'icon_class', 'idn'], 'string', 'max' => 127],
            [['title', 'description', 'sub_title', 'image'], 'string'],
            ['title', 'required'],

            ['idn', 'trim'],
            ['idn', 'required'],
            ['idn', 'unique'],
        ];
    }

    public function scenarios()
    {
        $s = parent::scenarios();
        $s['update'] = ['middle', 'status', 'slug', 'icon_class', 'title', 'description', 'sub_title', 'image'];
        return $s;
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'icon_class' => Yii::t('app', 'Icon'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'title' => Yii::t('app', 'Title'),
            'sub_title' => Yii::t('app', 'Subtitle'),
            'description' => Yii::t('app', 'Content'),
            'idn' => Yii::t('app', 'Identifikator'),
            'image' => Yii::t('app', 'Image'),
            'middle' => t('Show on index page'),
        ];
    }

    public static function find()
    {
        $query = new SActiveQuery(get_called_class());
        return $query->multilingual();
    }

    public function setAttributeNames()
    {
        return [

            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'multilingualAttributes' => ['title', 'sub_title', 'description', 'image'],
            'createdByAttribute' => false,
            'invalidateCacheTags' => ['page'],

        ];
    }

    public function deleteConditions()
    {
        return $this->deletable;
    }


    public function getUrl()
    {
        $urlManager = new SUrlManager([
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                '<language:\w+>/page/<id>' => 'site/page',
            ],
        ]);
        $urlManager->baseUrl = '/';
        return $urlManager->createAbsoluteUrl(['/site/page', 'id' => $this->idn], true);
    }



}
