<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%teacher_application}}`.
 */
class m210824_123415_add_columns_to_teacher_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%teacher_application}}', 'speciality', $this->string());
        $this->addColumn('{{%teacher_application}}', 'is_ready', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%teacher_application}}', 'speciality');
        $this->dropColumn('{{%teacher_application}}', 'is_ready');
    }
}
