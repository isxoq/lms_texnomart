<?php

namespace backend\modules\acf\components;

use Yii;
use backend\modules\acf\models\Field;
use backend\modules\acf\models\FieldValue;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Component for Acf module
 * @package backend\modules\acf\components
 *
 * @property-read mixed $values
 * @property-read array $languages
 */
class Acf extends \yii\base\Component
{


    /**
     * @var
     */
    private $_values;

    public $fileBasePath = '@webroot/uploads/acf';

    public $fileBaseUrl = '@web/uploads/acf';


    /**
     * Renders field(s) by given name(s)
     * @param string|array $name field name(s)
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
    public function fields($name, $params = [])
    {
        $name = (array)$name;
        $models = Field::find()->andWhere(['name' => $name])->all();
        $result = '';
        if (!empty($models)) {
            foreach ($models as $model) {
                $result .= $model->field($params) . "\n";
            }
        }
        return $result;
    }

    /**
     * Saves field values comes from $data.
     * @param array $data the data array to save, if not set `$_POST` is used.
     * @return bool whether all data successfully saved
     * @throws \Exception
     */
    public function save(array $data = [])
    {
        if (empty($data)) {

            if (!Yii::$app->request->post()) {
                return false;
            }

            $data = Yii::$app->request->post();
        }

        $flag = $this->uploadFiles();

        if ($data) {
            $fields = ArrayHelper::getValue($data, 'AcfField', []);

            if ($fields) {

                foreach ($fields as $name => $field) {
                    $model = Field::findByName($name);
                    if ($model != null) {

                        if ($model->is_multilingual && is_array($field)) {

                            foreach ($field as $languageKey => $value) {

                                $fieldValue = $model->getFieldValueByLang($languageKey);
                                if ($fieldValue == null) {
                                    $fieldValue = new FieldValue();
                                    $fieldValue->field_id = $model->id;
                                    $fieldValue->language = $languageKey;
                                }
                                $fieldValue->value = $value;
                                $flag = $flag && $fieldValue->save();
                            }
                        } else {

                            $fieldValue = $model->fieldValue;
                            if ($fieldValue == null) {
                                $fieldValue = new FieldValue();
                                $fieldValue->field_id = $model->id;
                            }
                            $fieldValue->value = $field;
                            $flag = $flag && $fieldValue->save();
                        }
                    }
                }
                return $flag;
            }
        }
        return $flag;
    }

    private function uploadFiles()
    {

        $flag = true;

        $files = ArrayHelper::getValue($_FILES, 'AcfField');

        if ($files) {

            $fieldNames = array_keys($files['name']);

            $fieldModels = Field::find()->andWhere(['name' => $fieldNames])->all();

            if (!empty($fieldModels)) {

                foreach ($fieldModels as $model) {
                    $flag = $flag && $this->uploadFile($model);
                }
            }
        }

        return $flag;
    }

    /**
     * @param $model Field
     * @param bool $strict
     */
    private function uploadFile($model, $strict = false)
    {
        if (!$strict && !$model->isFileUpload) {
            return false;
        }

        $flag = true;

        $basePath = Yii::getAlias($this->fileBasePath);
        $baseUrl = Yii::getAlias($this->fileBaseUrl);

        if ($model->is_multilingual) {
            foreach ($this->getLanguages() as $languageKey => $languageLabel) {

                $uploadedModel = UploadedFile::getInstanceByName("AcfField[$model->name][$languageKey]");
                if ($uploadedModel) {

                    $fileDir = $model->id . "/" . $languageKey;
                    $fileDirPath = $basePath . "/" . $fileDir;

                    if (!is_dir($fileDirPath)) {
                        FileHelper::createDirectory($fileDirPath);
                    }

                    $fileName = strtolower(Yii::$app->security->generateRandomString(16)) . "." . $uploadedModel->extension;

                    $filePath = $fileDirPath . "/" . $fileName;
                    $fileUrl = "/" . $fileDir . "/" . $fileName;
                    if ($uploadedModel->saveAs($filePath)) {
                        $fieldValue = $model->getFieldValueByLang($languageKey);
                        if ($fieldValue == null) {
                            $fieldValue = new FieldValue();
                            $fieldValue->field_id = $model->id;
                            $fieldValue->language = $languageKey;
                        }
                        $this->deleteOldFile($fieldValue->value);
                        $fieldValue->value = $fileUrl;
                        $flag = $flag && $fieldValue->save();
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'An error occured while saving file'));
                        return false;
                    }
                }
            }
        } else {

            $uploadedModel = UploadedFile::getInstanceByName("AcfField[$model->name]");
            if ($uploadedModel) {

                $fileDir = $model->id;
                $fileDirPath = $basePath . "/" . $fileDir;

                if (!is_dir($fileDirPath)) {
                    FileHelper::createDirectory($fileDirPath);
                }

                $fileName = strtolower(Yii::$app->security->generateRandomString(16)) . "." . $uploadedModel->extension;

                $filePath = $fileDirPath . "/" . $fileName;
                $fileUrl = "/" . $fileDir . "/" . $fileName;
                if ($uploadedModel->saveAs($filePath)) {
                    $fieldValue = $model->fieldValue;
                    if ($fieldValue == null) {
                        $fieldValue = new FieldValue();
                        $fieldValue->field_id = $model->id;
                    }
                    $this->deleteOldFile($fieldValue->value);
                    $fieldValue->value = $fileUrl;
                    $flag = $flag && $fieldValue->save();
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'An error occured while saving file'));
                    return false;
                }
            }

        }

        if (!$flag) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'An error occured while saving file'));
        }
        return $flag;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return Yii::$app->getModule('acf')->languages;
    }

    /**
     * Deletes old file after uploading new one
     * @param $value string File url
     */
    private function deleteOldFile($value)
    {
        if ($value) {
            $file = Yii::getAlias($this->fileBasePath) . $value;
            if (is_file($file)) {

                return unlink($file);
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        if ($this->_values == null) {
            $this->setValues();
        }
        return $this->_values;
    }

    /**
     * Fills $values property with data
     */
    public function setValues()
    {
        $fields = Field::find()
            ->select('id,name,title,type_id,is_multilingual,is_active')
            ->with('fieldValue')
            ->with(['fieldValues' => function ($query) {
                return $query->indexBy('language');
            }])
            ->with(['fieldType' => function ($query) {
                return $query->select('id,name,is_file_upload');
            }])
            ->indexBy('name')
            ->asArray()
            ->all();
        $this->_values = $fields;
    }

    /**
     * @throws \Exception
     */
    public function getValue($name, $defaultValue = null, $language = null)
    {
        $values = $this->values;
        $fieldValue = ArrayHelper::getValue($values, $name);

        if ($fieldValue) {

            $is_multilingiual = $fieldValue['is_multilingual'];
            $is_file_input = ArrayHelper::getValue($fieldValue, 'fieldType.is_file_upload', false);
            if ($is_multilingiual) {

                if ($language == null) {
                    $language = Yii::$app->language;
                }
                $value = ArrayHelper::getValue($fieldValue, 'fieldValues.' . $language . '.value');

            } else {
                $value = ArrayHelper::getValue($fieldValue, 'fieldValue.value');
            }
            if ($value !== null) {

                if ($is_file_input) {
                    return Yii::getAlias($this->fileBaseUrl) . $value;
                }
                return $value;
            }
        }
        return $defaultValue;
    }

}