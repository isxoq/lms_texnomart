<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%lesson}}`.
 */
class m210127_150019_add_stream_status_column_to_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('lesson', 'stream_status', 'integer(2)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
