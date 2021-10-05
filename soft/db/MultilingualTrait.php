<?php


namespace soft\db;

use Yii;
use soft\helpers\SArray;
use yii\base\InvalidArgumentException;


/**
 *  MultilingualTrait for SActiveRecord
 * @package soft\db
 * @var SActiveRecord $this
 */
trait MultilingualTrait
{

    /**
     * languages list for multilingual widget. For more details refer
     *  [[yeesoft/multilingual]] extension
     * */
    public function languages()
    {
       return Yii::$app->site->languages();
    }

    public function getMultilingualAttributes()
    {
        return SArray::getValue($this->getAttributeNames(),'multilingualAttributes', []);
    }

    public function getHasMultilingualAttributes()
    {
        return !empty($this->getMultilingualAttributes());
    }

    public function isMultilingualAttribute($attribute)
    {
        return in_array($attribute, $this->getMultilingualAttributes());
    }

    /**
     * Generates multilingual attributes with language prefix by given attribute.
     * For instance, if $attribute value is 'name', result would be ['name_uz', 'name_en', ...]
     * @param mixed $attribute multilingual attribute
     * @return array|false multilingual attributes with language prefix
     */

    public function generateMultilingualAttributes($attribute)
    {
        if (!$this->isMultilingualAttribute($attribute)) {
            throw new InvalidArgumentException("Attribute '". $attribute ."' is not multilingual attribute");
        }

        $result = [];
        foreach ($this->languages() as $key => $value){
            $result[] = $attribute."_".$key;
        }

        return $result;
    }

}