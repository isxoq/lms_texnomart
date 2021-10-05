<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%teacher_application}}`.
 */
class m210722_045032_add_comment_column_to_teacher_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%teacher_application}}', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%teacher_application}}', 'comment');
    }
}
