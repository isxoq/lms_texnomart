<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kurs_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%kurs}}`
 * - `{{%user}}`
 */
class m210722_101754_create_junction_table_for_kurs_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kurs_user}}', [
            'id' => $this->primaryKey(),
            'kurs_id' => $this->integer(),
            'user_id' => $this->integer(),
            'is_admin' => $this->boolean()->defaultValue(false),
        ]);

        // creates index for column `kurs_id`
        $this->createIndex(
            '{{%idx-kurs_user-kurs_id}}',
            '{{%kurs_user}}',
            'kurs_id'
        );

        // add foreign key for table `{{%kurs}}`
        $this->addForeignKey(
            '{{%fk-kurs_user-kurs_id}}',
            '{{%kurs_user}}',
            'kurs_id',
            '{{%kurs}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-kurs_user-user_id}}',
            '{{%kurs_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-kurs_user-user_id}}',
            '{{%kurs_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%kurs}}`
        $this->dropForeignKey(
            '{{%fk-kurs_user-kurs_id}}',
            '{{%kurs_user}}'
        );

        // drops index for column `kurs_id`
        $this->dropIndex(
            '{{%idx-kurs_user-kurs_id}}',
            '{{%kurs_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-kurs_user-user_id}}',
            '{{%kurs_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-kurs_user-user_id}}',
            '{{%kurs_user}}'
        );

        $this->dropTable('{{%kurs_user}}');
    }
}
