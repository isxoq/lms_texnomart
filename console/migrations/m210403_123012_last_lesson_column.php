<?php

use yii\db\Migration;

/**
 * Class m210403_123012_last_lesson_column
 */
class m210403_123012_last_lesson_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('enroll', 'last_lesson_id', 'integer');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_123012_last_lesson_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210403_123012_last_lesson_column cannot be reverted.\n";

        return false;
    }
    */
}
