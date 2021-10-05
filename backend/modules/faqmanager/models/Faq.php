<?php

namespace backend\modules\faqmanager\models;

use soft\db\SActiveRecord;
use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property int|null $sort
 * @property int|null $category_id
 * @property int|null $status
 *
 * @property FaqCategory $category
 */
class Faq extends SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['title', 'string', 'max' => 255],
            ['text', 'string'],
            [['text', 'title', 'category_id'], 'required'],

            [['sort', 'category_id', 'status'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaqCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => "Savol",
            'text' => "Javob",
            'category_id' => 'Kategoriya',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'text'],
            'invalidateCacheTags' => 'faq',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(FaqCategory::className(), ['id' => 'category_id']);
    }

    public static function find()
    {
        return parent::find()->multilingual()->orderBy(['faq.sort' => SORT_ASC]);
    }


}
