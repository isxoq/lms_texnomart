<?php

namespace backend\modules\faqmanager\models;

use Yii;
use soft\db\SActiveRecord;
use yii\caching\TagDependency;

/**
 * This is the model class for table "faq_category".
 *
 * @property int $id
 * @property int|null $sort
 * @property int|null $status
 *
 * @property Faq[] $faqs
 */

class FaqCategory extends SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'string', 'max' => 255],
            ['title', 'required'],
            [['sort', 'status'], 'integer'],
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title'],
            'invalidateCacheTags' => 'faqCategory',
        ];
    }

    public function setAttributeLabels()
    {
       return [

           'title' => 'Kategoriya nomi',

       ];
    }


    /**
     * Gets query for [[Faqs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaqs()
    {
        return $this->hasMany(Faq::className(), ['category_id' => 'id']);
    }

    public static function find()
    {
        return parent::find()->multilingual()->orderBy(['faq_category.sort' => SORT_ASC]);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public static function getDataForFaqPage()
    {
        return Yii::$app->db->cache( function(){

           return static::find()
               ->active()
               ->asArray()
               ->forceLocalized()
               ->with(['faqs' => function($query){
                return $query->forceLocalized()->active();
            }])
               ->all()
               ;

        } , null, new TagDependency(['tags' => ['faq', 'faqCategory']]) );

    }
}
