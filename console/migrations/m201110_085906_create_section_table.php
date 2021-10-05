<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%section}}`.
 */
class m201110_085906_create_section_table extends \soft\db\SMigration
{


    public $tableName = 'section';

    public $authorId = 'user_id';

    public $foreignKeys = [
        [
            'columns' => 'kurs_id',
            'refTable' => 'kurs',
        ]
    ];

    public function attributes()
    {
        return [
            'title' => $this->string()->notNull(),
            'slug' => $this->string(),
            'kurs_id' => $this->integer(),
        ];
    }

}
