<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%faq_category}}`.
 */
class m210125_030823_create_faq_category_table extends \soft\db\SMigration
{


    public $tableName = 'faq_category';

    public $multilingiualAttributes = ['title'];

    public function attributes()
    {
        return [
            'title' => $this->string()->notNull(),
            'sort' => $this->smallInteger(3)->defaultValue(99),
        ];
    }


}
