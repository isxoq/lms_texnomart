<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rating}}`.
 */
class m210504_110729_create_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rating}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'kurs_id' => $this->integer(),
            'rate' =>$this->tinyInteger(1)->unsigned()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_rating_user_id', '{{%rating}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_rating_kurs_id', '{{%rating}}', 'kurs_id', '{{%kurs}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_rating_user_id', '{{%rating}}');
        $this->dropForeignKey('fk_rating_kurs_id', '{{%rating}}');
        $this->dropTable('{{%rating}}');
    }
}
