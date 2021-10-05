<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%education_level}}`.
 */
class m210108_110038_create_education_level_table extends \soft\db\SMigration
{


    public $tableName = 'education_level';


    public $multilingiualAttributes = ['name'];

    public function attributes()
    {
        return [
            'name' => $this->string()->notNull(),
        ];
    }

}
