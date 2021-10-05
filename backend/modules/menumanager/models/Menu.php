<?php

namespace backend\modules\menumanager\models;

use backend\modules\pagemanager\models\Page;
use soft\behaviors\InvalidateCacheBehavior;
use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read Menu[] $subMenus
 * @property-read Menu[] $activeSubMenus
 * @property-read bool $hasActiveSubMenus
 * @property-read string $title
 * @property-read string $url
 * @property bool $child_allowed [tinyint(1)]
 * @property string $title_uz [varchar(255)]
 * @property string $url_str [varchar(255)]
 * @property string $url_type [varchar(255)]
 * @property string $url_value [varchar(255)]
 * @property string $title_ru [varchar(255)]
 * @property string $title_en [varchar(255)]
 * @property bool $status [tinyint]
 * @property string $idn [varchar(255)]
 */
class Menu extends \kartik\tree\models\Tree
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [

            'class' => InvalidateCacheBehavior::class,
            'tags' => 'menu',

        ];

        return $behaviors;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            [['name', 'title_uz', 'title_ru', /*'url_type', 'url_value'*/], 'required'],
            ['url_str', 'unique'],
            ['status', 'integer'],
            [['idn'], 'string', 'max' => 255],
            [['url_str', 'url_type', 'url_value'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'title_uz' => Yii::t('app', 'Title') . ' [' . Yii::t('app', 'uz') . ']',
            'title_ru' => Yii::t('app', 'Title') . ' [' . Yii::t('app', 'ru') . ']',
            'title_en' => Yii::t('app', 'Title') . ' [' . Yii::t('app', 'en') . ']',
            'url_str' => Yii::t('app', 'Identifikator'),
            'url_type' => Yii::t('app', 'Url Type'),
            'url_value' => Yii::t('app', 'Url Value'),
        ];
    }

    public static function find()
    {
        $query = parent::find();
        return $query->addOrderBy('root, lft');
    }

    public static function getMenu($menuId = '')
    {
        return Yii::$app->db->cache(function ($db) use ($menuId) {
            return static::findOne(['url_str' => $menuId]);
        }, null, new TagDependency(['tags' => 'menu']));
    }

    public function getSubMenus()
    {
        return $this->hasMany(Menu::class, ['root' => 'root'])
            ->andWhere(['lvl' => $this->lvl + 1])
            ->andWhere(['>', 'lft', $this->lft])
            ->andWhere(['<', 'rgt', $this->rgt]);
    }

    public function getActiveSubMenus()
    {
        return $this->getSubMenus()
            ->andWhere(['status' => 1, 'active' => 1, 'disabled' => 0]);
    }

    /**
     * Check if menu has active sub menu
     **/

    public function getHasActiveSubMenus()
    {
        return !empty($this->activeSubMenus);
    }

    public function getTitle()
    {

        if (Yii::$app->language == 'ru')
            return $this->title_ru;
        else  return $this->title_uz;
    }

    public function getUrl()
    {

        $model = $this;
        if ($model->url_type === 'main') return Yii::$app->urlManager->createUrl(['site/index']);
        if ($model->url_type === 'page'){
            $page = Page::findOne($model->url_value);
            if ($page == null){
                return "#";
            }
            return Yii::$app->urlManager->createUrl(['site/page', 'id' => $page->idn]);
        }
        if ($model->url_type === 'category') return Yii::$app->urlManager->createUrl(['blog/detail', 'id' => $model->url_value]);
        if ($model->url_type === 'c-action') return Yii::$app->urlManager->createUrl([$model->url_value]);
        return $model->url_value;

    }

}
