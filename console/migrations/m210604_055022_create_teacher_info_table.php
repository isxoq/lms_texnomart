<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teacher_info}}`.
 */
class m210604_055022_create_teacher_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%teacher_info}}', [
            'id' => $this->primaryKey(),
            'skill' => $this->string(),
            'telegram' => $this->string(),
            'facebook' => $this->string(),
            'youtube' => $this->string(),
            'instagram' => $this->string(),
            'education_story' => $this->text(),
            'experience_story' => $this->text(),
            'user_id' => $this->integer(),

        ]);
        $this->addForeignKey('fk_teacher_info_user_id', 'teacher_info', 'user_id','user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_teacher_info_user_id', 'teacher_info');

        $this->dropTable('{{%teacher_info}}');
    }
}
