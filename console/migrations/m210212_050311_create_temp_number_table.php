<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%temp_number}}`.
 */
class m210212_050311_create_temp_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%temp_number}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(100),
            'lastname' => $this->string(100),
            'password' => $this->string(100),
            'phone_number' => $this->string(100)->notNull(),
            'code' => $this->string(10),
            'expired_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temp_number}}');
    }
}
