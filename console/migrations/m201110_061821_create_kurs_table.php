<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kurs}}`.
 */
class m201110_061821_create_kurs_table extends \soft\db\SMigration
{

    public $tableName = 'kurs';
    public $authorId = 'user_id';

    public $foreignKeys = [
        [
            'columns' => 'category_id',
            'refTable' => 'sub_category',
        ]
    ];

    public function attributes()
    {
        return [
            'title' => $this->string()->notNull(),
            'short_description' => $this->text(),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'level' => $this->string(100),
            'language' => $this->string(50),
            'is_best' => $this->boolean()->defaultValue(false),
            'is_free' => $this->boolean()->defaultValue(false),
            'price' => $this->integer(),
            'discount' => $this->integer(3)->defaultValue(0),
            'preview_host' => $this->string(),
            'preview_link' => $this->string(),
            'image' => $this->string(),
            'meta_keywords' => $this->text(),
            'meta_description' => $this->text(),

        ];
    }


}
