<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_types}}`.
 */
class m210121_060837_create_payment_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_types}}', [

            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'name' => $this->string()

        ]);

        $this->batchInsert('payment_types', ['type', 'name'], [
            ['plastik', 'Plastikka tushirish'],
            ['click', 'CLICK'],
            ['payme', 'PAYME'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_types}}');
    }
}
