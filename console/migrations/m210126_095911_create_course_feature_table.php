<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course_feature}}`.
 */
class m210126_095911_create_course_feature_table extends \soft\db\SMigration
{


    public $tableName = 'course_feature';

    public $multilingiualAttributes = ['title', 'text'];

    public function attributes()
    {
        return [

            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'icon' => $this->string(),
            'url' => $this->string()->defaultValue('#'),

        ];
    }




}
