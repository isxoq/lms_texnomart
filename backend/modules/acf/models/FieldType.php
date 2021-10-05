<?php

namespace backend\modules\acf\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "acf_field_type".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $is_widget
 * @property string|null $widget_class
 * @property-read mixed $optionsAsArray
 * @property string|null $options
 * @property bool $is_file_upload [tinyint(1)]
 */
class FieldType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acf_field_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_widget'], 'integer'],
            [['options'], 'string'],
            ['is_file_upload', 'boolean'],
            ['is_file_upload', 'default', 'value' => false],
            [['name', 'description', 'widget_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'is_widget' => Yii::t('app', 'Is Widget'),
            'widget_class' => Yii::t('app', 'Widget Class'),
            'options' => Yii::t('app', 'Options'),
            'is_file_upload' => Yii::t('app', 'Is file upload'),
        ];
    }

    /**
     * @return array
     */
    public function getOptionsAsArray()
    {
        if (empty($this->options)){
            return [];
        }
        $options = Json::decode($this->options);
        return is_array($options) ? $options : [];
    }
}
