<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%lesson}}`.
 */
class m210129_034415_add_stream_percentage_column_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lesson', 'stream_percentage', 'integer(3)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
