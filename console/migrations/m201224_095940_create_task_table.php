<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m201224_095940_create_task_table extends \soft\db\SMigration
{

    public $tableName = 'task';

    public $foreignKeys = [
        [
            'columns' => 'lesson_id',
            'refTable' => 'lesson',
        ]
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'file' => $this->string(),
            'status' => $this->boolean(),
            'lesson_id' => $this->integer(),
            'sort' => $this->integer(3)->defaultValue(100)
        ];
    }

}
