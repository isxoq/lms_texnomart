<?php

use soft\db\SMigration;

/**
 * Handles the creation of table `{{%certificate}}`.
 */
class m210428_080624_create_certificate_table extends SMigration
{

    public $tableName = 'certificate';

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'kurs_id' => $this->integer(),
            'downloads_count' => $this->integer()->defaultValue(0),
            'date' => $this->integer()->comment('Sertifikat berilgan sana'),
            'created_at' => $this->integer(),
            'type' => $this->boolean()->defaultValue(1),
        ];
    }

    /**
     * @inheritdoc
     */
    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'delete' => 'NO ACTION',    // defaults to 'CASCADE'
            'update' => 'CASCADE',    // defaults to 'CASCADE'
        ],
        [
            'columns' => 'kurs_id',
            'refTable' => 'kurs',
            'delete' => 'NO ACTION',    // defaults to 'CASCADE'
            'update' => 'CASCADE',    // defaults to 'CASCADE'
        ],
    ];


}
