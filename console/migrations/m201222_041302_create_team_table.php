<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team}}`.
 */
class m201222_041302_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team}}', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string()->notNull(),
            'postion' => $this->string()->notNull(),
            'status' => $this->boolean()->defaultValue(true),
            'image' => $this->string(),
            'socials' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%team}}');
    }
}
