<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%octouz}}`.
 */
class m210117_054750_create_octouz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%octouz}}', [
            'id' => $this->primaryKey(),
            'secret' => $this->string(),
            'shop_id' => $this->integer(),
            'auto_capture' => $this->integer(),
            'test' => $this->integer(),
            'return_url' => $this->string(),
            'notify_url' => $this->string(),
            'currency' => $this->string(),
            'ttl' => $this->integer(),
            'status' => $this->integer(),

        ]);


        $this->batchInsert('octouz', ['secret', 'shop_id', 'auto_capture', 'test', 'return_url', 'notify_url', 'currency', 'ttl', 'status'], [
            ['secret', 123, true, true, 'return_url', 'notify_url', 'UZS', 3, true],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%octouz}}');
    }
}
