<?php

use yii\db\Migration;

/**
 * Class m201224_110755_update_user_short_title_column
 */
class m201224_110755_update_user_short_title_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user','short_title', 'position');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user','position', 'short_title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201224_110755_update_user_short_title_column cannot be reverted.\n";

        return false;
    }
    */
}
