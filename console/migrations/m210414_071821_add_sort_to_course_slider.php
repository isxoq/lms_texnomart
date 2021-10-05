<?php

use yii\db\Migration;

/**
 * Class m210414_071821_add_sort_to_course_slider
 */
class m210414_071821_add_sort_to_course_slider extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('course_slider', 'sort_order', 'integer(3) default 99');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210414_071821_add_sort_to_course_slider cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_071821_add_sort_to_course_slider cannot be reverted.\n";

        return false;
    }
    */
}
