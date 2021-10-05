<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cource_slider}}`.
 */
class m210527_064729_add_icon_column_to_cource_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%course_slider}}', 'icon', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%course_slider}}', 'icon');
    }
}
