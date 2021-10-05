<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%octouz_transactions}}`.
 */
class m210117_083803_create_octouz_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%octouz_transactions}}', [

            'id' => $this->primaryKey(),
            'shop_transaction_id' => $this->string(),
            'octo_payment_UUID' => $this->string(),
            'octo_pay_url' => $this->string(),
            'status' => $this->string(),
            'error' => $this->smallInteger(),
            'errorMessage' => $this->string(),
            'transfer_sum' => $this->string(),
            'refunded_sum' => $this->string(),
            'created_at' => $this->bigInteger()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%octouz_transactions}}');
    }
}
