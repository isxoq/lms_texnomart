<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payouts}}`.
 */
class m210121_055931_create_payouts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payouts}}', [

            'id' => $this->primaryKey(),
            'document_file' => $this->string()->notNull(),
            'teacher_id' => $this->integer()->notNull(),
            'payment_type' => $this->string()->notNull(),
            'payout_time' => $this->bigInteger(),
            'amount' => $this->float()->notNull(),
            'description' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'cancelled_time' => $this->bigInteger(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payouts}}');
    }
}
