<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%faq}}`.
 */
class m210125_030833_create_faq_table extends \soft\db\SMigration
{
    public $tableName = 'faq';

    public $multilingiualAttributes = ['title', 'text'];


    public $foreignKeys = [
        [
            'columns' => 'category_id',
            'refTable' => 'faq_category',
        ]
    ];

    public function attributes()
    {
        return [
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'sort' => $this->smallInteger(3)->defaultValue(99),
            'category_id' => $this->integer(),
        ];
    }

}
