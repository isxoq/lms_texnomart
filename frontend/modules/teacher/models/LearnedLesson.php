<?php


namespace frontend\modules\teacher\models;

/**
 *
 * @property-read Lesson $lesson
 * @property-read Section $section
 * @property-read Kurs $kurs
 */
class LearnedLesson extends \backend\modules\kursmanager\models\LearnedLesson
{

    public function getLesson()
    {
        return $this->hasOne(Lesson::class, ['id' => 'lesson_id']);
    }

    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id'])->via('lesson');
    }

    public function getKurs()
    {
        return $this->hasOne(Kurs::class, ['id' => 'kurs_id'])->via('section');
    }
}