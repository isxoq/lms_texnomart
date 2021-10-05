<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m201029_052402_create_category_table extends \soft\db\SMigration
{


    public $tableName = 'category';
    public $multilingiualAttributes = ['title'];

    public function attributes()
    {
        return [

            'title' => $this->string()->notNull(),
            'icon' => $this->string(),
            'image' => $this->string(),
            'slug' => $this->string(),
            'status' => $this->integer(2),

        ];
    }

}
