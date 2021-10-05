<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%kurs}}`.
 */
class m201110_065404_add_columns_to_kurs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('kurs', 'benefits', 'text');
        $this->addColumn('kurs', 'requirements', 'text');

    }


    public function safeDown()
    {
    }
}
