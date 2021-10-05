<?php

use yii\db\Migration;

/**
 * Class m201228_095656_alter_order_table
 */
class m201228_095656_alter_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropTable('order_item');
        $this->addColumn('order', 'kurs_id', 'integer');
        $this->addForeignKey('fbk_order_kurs', 'order', 'kurs_id', 'kurs', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201228_095656_alter_order_table cannot be reverted.\n";

        return false;
    }


}
