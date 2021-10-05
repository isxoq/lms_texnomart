<?php

namespace frontend\modules\teacher\models;

use Yii;
use frontend\modules\teacher\models\query\KursQuery;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;


/**
 *
 * @property-read null|Lesson $lastActiveLesson
 */
class Kurs extends \backend\modules\kursmanager\models\Kurs
{

    public static function find()
    {
        $query = new KursQuery(get_called_class());
        return $query->nonDeleted();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['teacher-form'] = [
            'title', 'short_description', 'description', 'category_id',
            'level', 'language', 'is_best', 'requirements', 'benefits',
            'is_free', 'price', 'old_price', 'preview_host', 'preview_link',
            'image', 'meta_keywords', 'meta_description', 'duration', 'free_duration'
        ];
        return $scenarios;
    }

    /**
     * Teacherga tegishli bo'lgan kursni topadi,
     * Agar kurs teacherga tegishli bo'lmasa, not_found() error qaytaradi
     * @param string $id
     * @return Kurs
     * @throws yii\web\NotFoundHttpException
     * @throws yii\web\ForbiddenHttpException
     */
    public static function findOwnModel($id = '')
    {
        /** @var Kurs|null $model */
        $model = self::find()->id($id)->one();
        if ($model == null){
            not_found();
        }

        /** @var Kurs $model */
        if ($model->user_id != Yii::$app->user->identity->id){
            forbidden();
        }
        return $model;
    }




}