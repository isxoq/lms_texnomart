<?php

use yii\db\Migration;

/**
 * Class m210507_065616_create_yii2_acf_field_tables
 */
class m210507_065616_create_yii2_acf_field_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%acf_field_type}}', [

            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'is_widget' => $this->boolean()->defaultValue(false),
            'widget_class' => $this->string(),
            'options' => $this->text(),
            'is_file_upload' => $this->boolean()->defaultValue(false)

        ]);

        $this->insertFieldTypes();

        $this->createTable('{{%acf_field}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'name' => $this->string(100)->notNull()->unique(),
            'type_id' => $this->integer(),
            'description' => $this->string(),
            'options' => $this->text(),
            'is_required' => $this->boolean()->defaultValue(false),
            'is_multilingual' => $this->boolean()->defaultValue(false),
            'placeholder' => $this->string(),
            'prepend' => $this->string(),
            'append' => $this->string(),
            'character_limit' => $this->smallInteger()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(true),
            'view_type' => $this->string(20)->defaultValue('text'),

        ]);

        $this->createTable('{{%acf_field_value}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(),
            'value' => $this->text(),
            'language' => $this->string(20),
        ]);

        $this->addForeignKey('fk_field_value_to_field', 'acf_field_value', 'field_id', 'acf_field', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_field_value_to_field', 'acf_field_value');
        $this->dropTable('{{%acf_field_value}}');
        $this->dropTable('{{%acf_field}}');
        $this->dropTable('{{%acf_field_type}}');
    }

    private function insertFieldTypes()
    {
        $this->batchInsert(
            '{{%acf_field_type}}',
            ['name', 'is_widget', 'widget_class', 'options', 'is_file_upload'],
            [
                ['Text input', false, '', '{ "type" : "text", "class" : "form-control" }', false],
                ['Email input', false, '', '{ "type" : "email", "class" : "form-control" }', false],
                ['Number input', false, '', '{ "type" : "number", "class" : "form-control" }', false],
                ['Textarea', false, '', '{ "type" : "textarea", "class" : "form-control" }', false],
                ['File input', false, '', '{ "type" : "file" }', true],
                ['Phone number input', true, 'yii\widgets\MaskedInput', '{"mask":"+\\9\\98\\(99\\) 999-99-99"}', false],
            ]
        );
    }
}
