<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner}}`.
 */
class m201229_071617_create_partner_table extends \soft\db\SMigration
{

    public $tableName = 'partner';

    public function attributes()
    {

        return [

            'image' => $this->string()->notNull(),
            'link' => $this->string(),

        ];

    }

}
