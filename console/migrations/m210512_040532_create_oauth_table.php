<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%oauth}}`.
 */
class m210512_040532_create_oauth_table extends Migration
{
    public function up()
    {

        $this->createTable('oauth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'oauth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('oauth');
    }
}
