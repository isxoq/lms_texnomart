<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m201126_063708_create_file_table extends \soft\db\SMigration
{

    public $tableName = 'file';

    public $foreignKeys = [
        [
            'columns' => 'lesson_id',
            'refTable' => 'lesson',
        ]
    ];

    public function attributes()
    {
        return [
            'title' => $this->string()->notNull(),
            'lesson_id' => $this->integer(),
            'src' => $this->string(),
            'org_name' => $this->string(),
            'extension' => $this->string(50),
        ];
    }

}
