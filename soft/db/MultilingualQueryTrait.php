<?php


namespace soft\db;

use Yii;

/**
 *  MultilingualQueryTrait for SActiveQuery
 * @package soft\db
 * @var SActiveQuery $this
 */
trait MultilingualQueryTrait
{
    /**
     * @var string the name of the lang field of the translation table. Default to 'language'.
     */
    public $languageField = 'language';

    /**
     * Scope for querying by languages.
     *
     * @param $language
     * @param $abridge
     * @return $this
     */
    public function localized($language = null)
    {
        if (!$language) {
            $language = Yii::$app->language;
        }

        if (!isset($this->with['translations'])){
            $this->with(['translation' => function ($query) use ($language) {
                $query->where([$this->languageField => $language]);
            }]);
        }


        return $this;
    }

    /**
     * Scope for querying by languages.
     *
     * @param $language
     * @param $abridge
     * @return $this
     */
    public function forceLocalized($language = null)
    {
        if (!$language) {
            $language = Yii::$app->language;
        }

        if (isset($this->with['translations'])) {
            unset($this->with['translations']);
        }

        $this->with(['translation' => function ($query) use ($language) {
            $query->where([$this->languageField => $language]);
        }]);

        return $this;
    }

    /**
     * Scope for querying by all languages
     * @return $this
     */
    public function multilingual()
    {
        if (isset($this->with['translation'])) {
            unset($this->with['translation']);
        }


        $this->with(['translations' => function ($query) {

            $query->indexBy($this->languageField);

        }]);
        return $this;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    abstract public function with();
}