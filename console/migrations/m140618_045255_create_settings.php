<?php

use yii\db\Schema;


class m140618_045255_create_settings extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable(
            'settings',
            [
                'id' => Schema::TYPE_PK,
                'type' => Schema::TYPE_STRING,
                'section' => Schema::TYPE_STRING,
                'key' => Schema::TYPE_STRING,
                'value' => Schema::TYPE_TEXT,               
            ]
        );
    }

    public function down()
    {
        $this->dropTable('settings');
        return true;
    }
}
