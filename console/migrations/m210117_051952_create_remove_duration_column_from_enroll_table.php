<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%remove_duration_column_from_enroll}}`.
 */
class m210117_051952_create_remove_duration_column_from_enroll_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('enroll', 'duration');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%remove_duration_column_from_enroll}}');
    }
}
