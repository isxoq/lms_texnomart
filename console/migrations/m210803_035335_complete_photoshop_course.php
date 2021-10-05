<?php

use frontend\models\Kurs;
use frontend\modules\teacher\models\LearnedLesson;
use yii\db\Migration;

/**
 * Class m210803_035335_complete_photoshop_course
 */
class m210803_035335_complete_photoshop_course extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $course = Kurs::findModel(2);

        /** @var \frontend\modules\mbapp\models\Lesson[] $lessons */
        $lessons = $course->lessons;

        foreach ($lessons as $lesson) {

            $ll = LearnedLesson::findOne([
                'lesson_id' => $lesson->id,
                'user_id' => 2,
            ]);

            if (!$ll) {
                $ll = new LearnedLesson([
                    'lesson_id' => $lesson->id,
                    'user_id' => 2,
                ]);
            }

            $ll->is_completed = 1;
            $ll->watched_seconds = $lesson->media_duration;
            $ll->current_time = 0;

            if (!$ll->save()) {

                print_r($ll->errors);
                return false;

            }

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210803_035335_complete_photoshop_course cannot be reverted.\n";

        return false;
    }
    */
}
