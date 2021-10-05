<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course_slider}}`.
 */
class m210109_152225_create_course_slider_table extends \soft\db\SMigration
{

    public $tableName = 'course_slider';

    public $foreignKeys = [
      [
          'columns' => 'course_id',
          'refTable' => 'kurs',
      ]
    ];

    public $multilingiualAttributes = ['title', 'text'];

    public function attributes()
    {
        return [

            'title' => $this->string()->notNull(),
            'text' => $this->string(),
            'course_id' => $this->integer()->notNull(),
            'image' => $this->string(),
            'little_image' => $this->string(),

        ];
    }



}
