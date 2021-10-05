<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%settings}}`.
 */
class m201230_035638_add_column_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('settings', 'description', 'string');
        $this->addColumn('settings', 'is_multilingual', 'boolean');
    }


}
