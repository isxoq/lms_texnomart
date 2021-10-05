<?php

namespace backend\modules\postmanager\models;

use soft\behaviors\CyrillicSlugBehavior;
use Yii;

/**
 *
 * @property int $id [int(11)]
 * @property string $slug [varchar(127)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property int $status [smallint(2)]
 * @property int $user_id [int(5)]
 * @property int $category_id [int(3)]
 * @property string $image [varchar(255)]
 * @property int $view [int(11)]
 * @property int $like [int(11)]
 * @property-read mixed $category
 * @property int $published_at [int(11)]
 * @property string $image_small [varchar(255)]
 * @property string $title
 * @property string $content
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property-read mixed $formattedPublishedDate
 * @property-read string $metaTitle @see getMetaTitle()
 * @property-read string $metaDescription
 * @property-read mixed $shortContent
 * @property string $tags
 */
class Post extends \soft\db\SActiveRecord
{

    public $publishedField;
    public $tagsField;

    public static function tableName()
    {
        return '{{%post}}';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => CyrillicSlugBehavior::className(),
            'attribute' => 'title',
        ];
        return $behaviors;
    }

    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status', 'user_id', 'category_id', 'view', 'like', 'published_at'], 'integer'],
            [['slug'], 'string', 'max' => 127],
            [['image', 'image_small'], 'string', 'max' => 255],

            [['title',  'meta_title'], 'string', 'max' => '255'],
            [['content', 'meta_description', 'meta_keywords'], 'string'],
            [['title', 'category_id'] , 'required'],

            ['tags', 'safe'],
            ['tagsField', 'safe'],

            ['published_at', 'integer'],
            ['publishedField', 'safe'],

            ['view', 'default', 'value' => 0],

            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category'),
            'view' => Yii::t('app', 'View'),
            'like' => Yii::t('app', 'Like'),
            'published_at' => "E'lon qilish sanasi",
            'publishedField' => "E'lon qilish sanasi",
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(PostCategory::className(), ['id' => 'category_id']);
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'tags'],
            'invalidateCacheTags' => ['post'],
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'createdByAttribute' => 'user_id',
        ];
    }

    public function incViewsCount()
    {
        $session = Yii::$app->session;
        $key = 'post_view_'.$this->id;
        if (!$session->has($key)){

            $this->view ++;
            $this->save(false);
            $session->set($key, true);
        }

    }

    public static function find()
    {
        $query = new \backend\modules\postmanager\models\query\PostQuery(get_called_class());
        return $query->multilingual();
    }

    public function getFormattedPublishedDate()
    {
        return Yii::$app->formatter->asDateUz($this->published_at);
    }

    public function getShortContent()
    {
        return Yii::$app->formatter->asShortText($this->content, 200);
    }

    public function getMetaTitle()
    {
        return empty($this->meta_title) ? $this->title : $this->meta_title;
    }

    public function getMetaDescription()
    {
        return empty($this->meta_description) ? $this->shortContent : $this->meta_description;
    }

}
