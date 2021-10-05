<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%watch_history}}`.
 */
class m201212_074333_create_watch_history_table extends \soft\db\SMigration
{
    public $tableName = 'watch_history';

    public $authorId = 'user_id';

    public $statusField = false;

    public $foreignKeys = [
        [
            'columns' => 'media_id',
            'refTable' => 'media',
        ]
    ];

    public function attributes()
    {
        return [
            'media_id' => $this->integer(),
            'user_id' => $this->integer(),
            'watched_seconds' => $this->integer(6)->defaultValue(0)->comment('Number of seconds of watched time'),
            'progress' => $this->text()->comment('History of the watches'),
        ];
    }

}
