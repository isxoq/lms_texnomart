<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kurs_comment}}`.
 */
class m210506_033715_create_kurs_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kurs_comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'kurs_id' => $this->integer(),
            'text' => $this->text()->notNull(),
            'reply_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->tinyInteger(1)->defaultValue(5)
        ]);
        $this->addForeignKey('fk_kurs_comment_kurs',  '{{%kurs_comment}}', 'kurs_id', '{{%kurs}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kurs_comment_user',  '{{%kurs_comment}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kurs_comment_reply_id',  '{{%kurs_comment}}', 'reply_id', '{{%kurs_comment}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_kurs_comment_kurs',  '{{%kurs_comment}}');
        $this->dropForeignKey('fk_kurs_comment_user',  '{{%kurs_comment}}');
        $this->dropForeignKey('fk_kurs_comment_reply_id',  '{{%kurs_comment}}');

        $this->dropTable('{{%kurs_comment}}');
    }
}
