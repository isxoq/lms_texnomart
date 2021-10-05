<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%learned_lesson}}`.
 */
class m201212_091658_create_learned_lesson_table extends \soft\db\SMigration
{
    public $tableName = 'learned_lesson';

    public $authorId = 'user_id';

    public $statusField = false;

    public $foreignKeys = [
        [
            'columns' => 'lesson_id',
            'refTable' => 'lesson',
        ]
    ];

    public function attributes()
    {
        return [
            'lesson_id' => $this->integer(),
            'user_id' => $this->integer(),
            'is_completed' => $this->boolean(),
            'is_open' => $this->boolean(),
        ];
    }
}
