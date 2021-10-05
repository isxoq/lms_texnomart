<?php

namespace backend\modules\acf\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * This is the model class for table "acf_field".
 *
 * @property int $id
 * @property string|null $title
 * @property string $name
 * @property string|null $description
 * @property string|null $options
 * @property int|null $is_required
 * @property int|null $is_multilingual
 * @property string|null $placeholder
 * @property string|null $prepend
 * @property string|null $append
 * @property int|null $character_limit
 * @property int $type_id [int(11)]
 * @property bool $is_active [tinyint(1)]
 * @property-read FieldValue $fieldValue
 * @property-read FieldValue[] $fieldValues
 * @property-read FieldType $fieldType
 * @property-read string|null $fieldTypeName
 * @property-read bool $isFileUpload
 * @property-read array $optionsAsArray
 * @property string $view_type [varchar(20)]
 */
class Field extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acf_field';
    }

    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'match', 'pattern' => '/^[0-9a-zA-Z_\/]*$/', 'message' => Yii::t('app', 'Only numbers, word characters and dashes are allowed.')],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],

            [['options'], 'string'],

            [['is_required', 'is_multilingual', 'is_active'], 'boolean'],

            [['type_id'], 'integer'],
            [['title', 'description', 'placeholder', 'prepend', 'append'], 'string', 'max' => 255],

            ['character_limit', 'integer', 'min' => 0],
            ['character_limit', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'type_id' => Yii::t('app', 'Type'),
            'fieldTypeName' => Yii::t('app', 'Type'),
            'options' => Yii::t('app', 'Options'),
            'is_required' => Yii::t('app', 'Is Required'),
            'is_multilingual' => Yii::t('app', 'Is Multilingual'),
            'placeholder' => Yii::t('app', 'Placeholder'),
            'prepend' => Yii::t('app', 'Prepend'),
            'append' => Yii::t('app', 'Append'),
            'character_limit' => Yii::t('app', 'Character Limit'),
            'is_active' => Yii::t('app', 'Is active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldType()
    {
        return $this->hasOne(FieldType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldValues()
    {
        return $this->hasMany(FieldValue::className(), ['field_id' => 'id']);
    }

    /**
     * @param string $lang
     * @return null|\backend\modules\acf\models\FieldValue
     */
    public function getFieldValueByLang($lang)
    {
        return $this->getFieldValues()->andWhere(['language' => $lang])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldValue()
    {
        return $this->hasOne(FieldValue::className(), ['field_id' => 'id']);
    }

    /**
     * @param null|string $lang
     * @return string|null
     */
    public function value($lang = null)
    {
        if ($lang == null) {
            return isset($this->fieldValue) ? $this->fieldValue->value : null;
        } else {
            $fieldValue = $this->getFieldValueByLang($lang);
            return $fieldValue == null ? null : $fieldValue->value;
        }
    }

    /**
     * @return string|null
     */
    public function getFieldTypeName()
    {
        return isset($this->fieldType) ? $this->fieldType->name : null;
    }

    /**
     * Generates self options as array
     * @return array
     */
    public function getOptionsAsArray()
    {
        $options = Json::decode($this->options);
        return is_array($options) ? $options : [];
    }

    /**
     * Whether file must be uploaded
     * @return bool
     */
    public function getIsFileUpload()
    {
        return $this->fieldType ? $this->fieldType->is_file_upload : false;
    }

    /**
     * Generates input field according to field $params and self properties
     * @param array $params Params for input. The following settings are supported:
     * - `label`: _string_, Label text for input. If set to 'false' label will not be rendered.
     * Defaults to self::$title
     * - `hint`: _string_, Hint text for input. If set to 'false' hint will not be rendered.
     * Defaults to self::$description
     *  - 'options' : _array_ options for input
     *
     * @return string
     * @throws \Exception
     */
    public function field($params = [])
    {
        $prepend = $this->prepend();
        $append = $this->append();
        $inputField = $this->renderInput($params);
        return $prepend . "\n" . $inputField . "\n" . $append;
    }

    /**
     * Renders a single input or multiple inputs if $is_multilingual property equals to true
     * @param array $params Params for input. The following settings are supported:
     * - `label`: _string_, Label text for input. If set to 'false' label will not be rendered.
     * Defaults to self::$title
     * - `hint`: _string_, Hint text for input. If set to 'false' hint will not be rendered.
     * Defaults to self::$description
     *  - 'options' : _array_ options for input
     *
     * @return string
     */
    public function renderInput($params = [])
    {

        $labelText = ArrayHelper::remove($params, 'label');
        $hintText = ArrayHelper::remove($params, 'hint');
        $fieldType = $this->fieldType;
        $configs = [];

        $options = ArrayHelper::getValue($params, 'options', []);
        $selfOptions = $this->generateSelfOptions();
        $typeOptions = $fieldType->optionsAsArray;
        $options = ArrayHelper::merge($typeOptions, $selfOptions, $options);
        $configs['isWidget'] = $fieldType->is_widget;
        $configs['widgetClass'] = $fieldType->widget_class;
        $configs['type'] = ArrayHelper::remove($options, 'type', 'text');
        $configs['options'] = $options;
        if ($this->is_multilingual) {

            $inputs = '';
            $languages = Yii::$app->getModule('acf')->languages;
            foreach ($languages as $languageKey => $languageLabel) {

                $label = $this->renderLabel($labelText, $languageLabel);
                $hint = $this->renderHint($hintText, $languageLabel);
                $configs['name'] = $this->inputName($languageKey);
                $configs['value'] = $this->value($languageKey);
                $input = $this->input($configs);
                $content = $label . "\n" . $input . "\n" . $hint;
                $inputs .= Html::tag('div', $content, ['class' => 'form-group']);
            }
            return $inputs;
        } else {

            $label = $this->renderLabel($labelText);
            $hint = $this->renderHint($hintText);
            $configs['name'] = $this->inputName();
            $configs['value'] = $this->value();
            $input = $this->input($configs);

            $content = $label . "\n" . $input . "\n" . $hint;
            return Html::tag('div', $content, ['class' => 'form-group']);

        }
    }

    /**
     * Generates input according to configs[]
     * @param array $configs Configs
     * The following settings are supported: <br>
     * - `type` : _string_ Input type <br>
     * - `name` : _string_ Input name (required) <br>
     * - `value`: _string_ Input value <br>
     * - 'options' : _array_ options for input <br>
     * - `isWidget` : _boolean_ Defaults to 'false' <br>
     * - `widgetClass` : _string_ Widget class name, required when `isWidget` equals to true <br>
     * @return string
     * @throws \Exception
     */
    private function input($configs)
    {
        $name = ArrayHelper::getValue($configs, 'name', []);
        $value = ArrayHelper::getValue($configs, 'value');
        $isWidget = ArrayHelper::getValue($configs, 'isWidget', false);
        $options = ArrayHelper::getValue($configs, 'options', []);
        if ($isWidget) {
            $widgetClass = ArrayHelper::getValue($configs, 'widgetClass');
            $options['name'] = $name;
            $options['value'] = $value;

            return $widgetClass::widget($options);
        }

        $type = ArrayHelper::getValue($configs, 'type', 'text');
        if ($type == 'textarea') {
            return Html::textarea($name, $value, $options);
        }
        return Html::input($type, $name, $value, $options);
    }


    public function append()
    {
        return $this->prepend ? Html::tag('p', $this->append) : '';
    }

    public function prepend()
    {
        return $this->prepend ? Html::tag('p', $this->prepend) : '';
    }

    public function inputName($lang = null)
    {
        if ($lang == null) {
            return "AcfField[$this->name]";
        } else {
            return "AcfField[$this->name][$lang]";
        }
    }

    /**
     * @return array
     */
    public function generateSelfOptions()
    {
        $selfOptions = $this->optionsAsArray;
        $isWidget = $this->fieldType->is_widget;
        $options = [];
        if ($this->is_required) {
            $options['required'] = true;
        }
        if ($this->placeholder) {
            $options['placeholder'] = $this->placeholder;
        }

        $character_limit = intval($this->character_limit);
        if ($character_limit > 0) {
            $options['maxlength'] = $character_limit;
        }

        if ($isWidget){
            if (isset($selfOptions['options'])){
                return ArrayHelper::merge($options, $selfOptions['options']);
            }
            else{
                $selfOptions['options'] = $options;
                return $selfOptions;
            }
        }

        return ArrayHelper::merge($options, $selfOptions);

    }

    /**
     * @param string|null $labelText
     * @return string
     */
    public function renderLabel($labelText = null, $lang = null)
    {
        if ($labelText === false) {
            return '';
        }
        if ($labelText === null) {
            $labelText = $this->title;
        }
        if ($lang != null) {
            $labelText .= " [" . $lang . "]";
        }
        return Html::label($labelText, $this->inputName(), ['class' => 'control-label']);
    }

    /**
     * @param string|null $hintText
     * @return string
     */
    public function renderHint($hintText = null, $lang = null)
    {

        if ($hintText === false) {
            return '';
        }

        if ($hintText === null && empty($this->description)){
            return '';
        }

        if ($hintText === null) {
            $hintText = $this->description;
        }
        if ($lang != null) {
            $hintText .= " [" . $lang . "]";
        }
        return Html::tag('div', $hintText, ['class' => 'hint-block']);
    }


}
