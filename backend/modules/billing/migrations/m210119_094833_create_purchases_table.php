<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchases}}`.
 */
class m210119_094833_create_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%purchases}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'course_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'amount' => $this->float(),
            'order_id' => $this->integer(),
            'teacher_fee' => $this->float(),
            'platform_fee' => $this->float(),
            'cancelled_time' => $this->integer(),
            'payment_type' => $this->string(),
            'transaction_id' => $this->integer(),
            'status' => $this->smallInteger()


        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%purchases}}');
    }
}
