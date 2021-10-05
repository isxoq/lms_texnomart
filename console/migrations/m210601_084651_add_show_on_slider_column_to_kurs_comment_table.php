<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%kurs_comment}}`.
 */
class m210601_084651_add_show_on_slider_column_to_kurs_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%kurs_comment}}', 'show_on_slider', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%kurs_comment}}', 'show_on_slider');
    }
}
