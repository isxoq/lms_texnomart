<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%enroll}}`.
 */
class m201127_044637_create_enroll_table extends \soft\db\SMigration
{

    public $tableName = 'enroll';

    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
        ],
        [
            'columns' => 'kurs_id',
            'refTable' => 'kurs',
        ],

    ];

    public function attributes()
    {
        return [
            'user_id' => $this->integer(),
            'kurs_id' => $this->integer(),
        ];
    }

}
