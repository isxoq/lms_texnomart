<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sub_category}}`.
 */
class m201029_094043_create_sub_category_table extends \soft\db\SMigration
{
    public $tableName = 'sub_category';
    public $multilingiualAttributes = ['title'];

    public $foreignKeys = [
        [
            'columns' => 'category_id',
            'refTable' => 'category',
        ]
    ];

    public function attributes()
    {
        return [

            'title' => $this->string()->notNull(),
            'icon' => $this->string(),
            'image' => $this->string(),
            'slug' => $this->string(),
            'category_id' => $this->integer(),

        ];
    }
}
