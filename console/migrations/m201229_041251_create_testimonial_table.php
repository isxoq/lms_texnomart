<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%testimonial}}`.
 */
class m201229_041251_create_testimonial_table extends \soft\db\SMigration
{


    public $tableName = 'testimonial';


    public $authorId = 'user_id';

    public $multilingiualAttributes = ['title', 'text'];


    public function attributes()
    {
        return [

            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),

        ];
    }

}
