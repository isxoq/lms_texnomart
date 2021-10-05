<?php


namespace soft\behaviors;

use soft\helpers\SArray;
use Yii;

/**
 *
 * @property-write null $language
 */
class ChangeLanguage extends \yii\base\Behavior
{
    public function events(){
        return [
            \yii\web\Application::EVENT_BEFORE_ACTION => 'changeLanguage',
        ];
    }

    public function changeLanguage()
    {
        $languageParam = SArray::getValue(Yii::$app->params, 'languageParam');
        $language = Yii::$app->request->get($languageParam);
        $this->setLanguage($language);
    }

    public function setLanguage($language=null)
    {
        if ($language == null || !key_exists( $language, Yii::$app->params['languages']))
        {
            $language = Yii::$app->params['defaultLanguage'];
        }
        Yii::$app->language = $language;
    }
}