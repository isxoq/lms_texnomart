<?php

namespace backend\modules\acf\models;

use Yii;

/**
 * This is the model class for table "acf_field_value".
 *
 * @property int $id
 * @property int|null $field_id
 * @property string|null $value
 * @property string|null $language
 *
 * @property Field $field
 */
class FieldValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acf_field_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id'], 'integer'],
            [['value'], 'string'],
            [['language'], 'string', 'max' => 20],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_id' => Yii::t('app', 'Field'),
            'value' => Yii::t('app', 'Value'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * Gets query for [[Field]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }
}
