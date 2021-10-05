<?php


namespace soft\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * Class DeleteFileBehavior
 * $model ni o'chirgandan keyin shu $model ga tegishli bo'lgan faylni o'chirish uchun mo'ljallangan behavior
 * @package soft\behaviors
 */
class DeleteFileBehavior extends Behavior
{

    /**
     * @var string|array fayl adresi qiymatiga ega bo'lgan attribut yoki attributlar ro'yxati
     */
    public $attributes;

    /**
     * @var string fayl joylashgan asos papka
     */
    public $basePath = '@frontend/web';

    /**
     * If true, old file will be deleted after update if new file uploaded
     * @var bool
     */
    public $unlinkOnUpdate = true;

    protected $_attributes;
    protected $_basePath;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->attributes === null) {
            throw new InvalidConfigException('The "attribute" property must be set.');
        }
        if ($this->basePath === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }
        $this->_basePath = Yii::getAlias($this->basePath);
        $this->_attributes = (array) $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     * Delete file(s) after delete
     */
    public function beforeUpdate()
    {

        if (!$this->unlinkOnUpdate){
            return '';
        }
        /** @var BaseActiveRecord $model */
        $model = $this->owner;
        foreach ($this->_attributes as $attribute){

            $oldFileName = $model->getOldAttribute($attribute);
            $newFileName = $model->$attribute;
            if ($oldFileName != $newFileName){

                $filename = $this->getFilePath($oldFileName);
                if (is_file($filename)){
                    unlink($filename);
                }

            }

        }

    }

     /**
     * Delete file(s) after delete
     */
    public function afterDelete()
    {

        /** @var BaseActiveRecord $model */
        $model = $this->owner;

        foreach ($this->_attributes as $attribute){

            $filename = $this->getFilePath($model->$attribute);
            if (is_file($filename)){
                unlink($filename);
            }

        }

    }

    /**
     * @param $fileUrl string url to file
     * @return string
     */
    protected function getFilePath($fileUrl)
    {
        return $this->_basePath . $fileUrl;
    }


}