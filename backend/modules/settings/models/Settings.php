<?php

namespace backend\modules\settings\models;

use Yii;
use soft\db\SActiveRecord;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $type
 * @property string $section
 * @property string $key
 * @property string $description [varchar(255)]
 * @property bool $is_multilingual [tinyint(1)]
 * @property string $value
 */
class Settings extends SActiveRecord
{

    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_ELFINDER = 'elfinder';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_TEXT_EDITOR = 'text-editor';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'safe'],
            [['type', 'section', 'key', 'description'], 'string', 'max' => 255],
            [['type', 'section', 'key', 'description'], 'required'],
            ['is_multilingual', 'integer'],
            ['is_multilingual', 'default', 'value' => 0],
            ['key', 'unique', 'targetAttribute' => ['section', 'key']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'section' => 'Section',
            'key' => 'Kalit so`z',
            'value' => 'Qiymati',
            'description' => "Izoh",
            'is_multilingual' => "Ko'p tilli",
        ];
    }

    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios['create']  = ['type', 'is_multilingual', 'key', 'description', 'section'];
        return $scenarios;
    }


    /**
     * Gets all a combined map of all the settings.
     * @return array
     */
    public function getSettings()
    {
        $settings =  Yii::$app->db->cache( function ($db){
            return static::find()->asArray()->all();
        }, 30*24*3600, new TagDependency(['tags' => ['settings']]));

        return array_merge_recursive(
            ArrayHelper::map($settings, 'key', 'value', 'section'),
            ArrayHelper::map($settings, 'key', 'type', 'section'),
            ArrayHelper::map($settings, 'key', 'is_multilingual', 'section')
        );
    }

    /**
     * Saves a setting
     *
     * @param $section
     * @param $key
     * @param $value
     * @param $type
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function setSetting($section, $key, $value, $type = null)
    {
        $model = static::findOne(['section' => $section, 'key' => $key]);
        if ($model === null) {
            $model = new static();
        }
        $model->section = $section;
        $model->key = $key;
        $model->value = strval($value);
        if ($type !== null) {
            $model->type = $type;
        } else {
            $model->type = gettype($value);
        }
        return $model->save();
    }

    /**
     * Deletes a settings
     *
     * @param $key
     * @param $section
     * @return boolean True on success, false on error
     */
    public function deleteSetting($section, $key)
    {
        $model = static::findOne(['section' => $section, 'key' => $key]);
        if ($model) {
            return $model->delete();
        }
        return true;
    }

    /**
     * Deletes all settings! Be careful!
     * @return boolean True on success, false on error
     */
    public function deleteAllSettings()
    {
        return static::deleteAll();
    }

    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => false,
            'createdAtAttribute' => false,
            'updatedAtAttribute' => false,
            'invalidateCacheTags' => ['settings'],

        ];
    }

    public static function getTypes()
    {
        return [

            self::TYPE_STRING => 'Qisqa matn',
            self::TYPE_TEXT => 'Katta matn - Textarea',
            self::TYPE_TEXT_EDITOR => 'Katta matn - CKEditor',
            self::TYPE_IMAGE => 'Rasm',
            self::TYPE_ELFINDER => 'Fayl yuklash',
            self::TYPE_BOOLEAN => 'Checkbox (True/False)',

        ];
    }


    public function prepareToSave()
    {
        if ($this->is_multilingual && is_array($this->value)){

            $this->value = Json::encode($this->value);

        }
    }

    public function prepareForActiveForm()
    {

        if ($this->is_multilingual){

            try {
                $this->value = Json::decode($this->value);
            } catch (\Exception $e) {
            }
        }

    }


    public function getFormattedValue()
    {
        if ($this->type == self::TYPE_IMAGE){
            if (!$this->is_multilingual){
                return Yii::$app->formatter->asThumbnail($this->value, '100px');
            }
        }
        return Yii::$app->formatter->asShortText($this->value);
    }

}
