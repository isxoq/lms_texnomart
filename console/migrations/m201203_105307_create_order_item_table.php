<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m201203_105307_create_order_item_table extends \soft\db\SMigration
{

    public $tableName = 'order_item';

    public $foreignKeys = [
      [
          'columns' => 'order_id',
          'refTable' => 'order',
      ]
    ];

    public function attributes()
    {
        return [

            'owner_id' => $this->integer()->notNull(),

            'type' => $this->string(100),

            'price' => $this->integer(),

            'order_id' => $this->integer(),


        ];
    }

}
