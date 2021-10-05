<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offline_payments}}`.
 */
class m210120_085107_create_offline_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offline_payments}}', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'course_id' => $this->integer(),
            'amount' => $this->float(),
            'document_file' => $this->string()->comment("To'lovni tasdiqlovchi hujjat yoki rasm"),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
            'cancelled_at' => $this->bigInteger()->comment("Bekor qilingan vaqt"),
            'status' => $this->integer(),
            'type' => $this->string()->comment("click,payme....  cash")

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%offline_payments}}');
    }
}
