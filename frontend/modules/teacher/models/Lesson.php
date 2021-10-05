<?php

namespace frontend\modules\teacher\models;

use Yii;


/**
 * Lesson class for teacher module
 * @property-read Kurs $kurs
 * @property-read Section $section
 */
class Lesson extends \backend\modules\kursmanager\models\Lesson
{

    //<editor-fold desc="Parent Methods" defaultstate="collapsed">

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['teacher-form'] = ['title', 'status', 'description', 'media_poster', 'is_open', 'type', 'media_stream_src'];
        return $scenarios;
    }

    /**
     * @param string $id
     * @return Lesson
     * @throws \yii\web\NotFoundHttpException
     */
    public static function findOwnModel($id = '')
    {
        $model = self::find()->id($id)->one();

        /** @var Lesson|null $model */
        if ($model == null) {
            not_found();
        }

        /** @var Lesson $model */
        if ($model->kurs->user_id != Yii::$app->user->identity->id) {
            forbidden();
        }
        return $model;
    }

    public static function find()
    {
        return parent::find()->nonDeleted();
    }

    // </editor-fold>

    //<editor-fold desc="Has one" defaultstate="collapsed">

    /**
     * Teacher moduldagi Section classi orqali sectionni olish
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * Teacher moduldagi Kurs classi orqali kurs olish
     * @return \yii\db\ActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id'])
            ->via('section');
    }

    /**
     * Current user tomonidan ushbu mavzuni o'zlashtirish bo'yicha ma'lumotlar
     * Agar uning qiymati nullga teng bo'lsa, mavzu user uchun yopiq bo'ladi
     * User biror mavzuni o'zlashtirsa, keyingi mavzu ochiladi
     * @return yii\db\ActiveQuery|null
     */

    public function getUserLearnedLesson()
    {
        return $this->hasOne(LearnedLesson::class, ['lesson_id' => 'id'])->andWhere(['user_id' => user('id')]);
    }

    // </editor-fold>


}