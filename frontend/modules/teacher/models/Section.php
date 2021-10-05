<?php

namespace frontend\modules\teacher\models;

use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read mixed $activeLessonsDuration
 * @property-read mixed $formattedActiveLessonsDuration
 * @property-read Kurs $kurs
 */
class Section extends \backend\modules\kursmanager\models\Section
{

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['teacher-form'] = ['title', 'status'];
        return $scenarios;
    }

    public static function find()
    {
        return parent::find()->nonDeleted();
    }

    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), ['activeLessons']);
    }


    /**
     * @param string $id
     * @return array|Section|\yii\db\ActiveRecord|null
     * @throws \yii\web\NotFoundHttpException
     */
    public static function findOwnModel($id='')
    {
        /** @var Section|null $model */
        $model = self::find()->id($id)->one();

        if ($model == null){
            not_found();
        }

        if ($model->kurs->user_id != Yii::$app->user->identity->id){
            forbidden();
        }
        return $model;
    }

    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    public function getLessons()
    {
        return Yii::$app->db->cache( function ($db){
            return  $this->hasMany(Lesson::class, ['section_id' => 'id']);
        }, null, new TagDependency(['tags' => 'lesson']));
    }

    public function getActiveLessons()
    {
        return Yii::$app->db->cache( function ($db){
            return $this->getLessons()->active();
        }, null, new TagDependency(['tags' => 'lesson']));
    }


}