<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_published_column_to_course}}`.
 */
class m210115_054542_create_add_published_column_to_course_table extends Migration
{

    public function safeUp()
    {
       $this->addColumn('kurs', 'published_at', 'integer');
    }


}
