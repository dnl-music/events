<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m221019_164911_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->notNull(),
            'goal' => $this->string()->notNull(),
            'price' => $this->string()->notNull(),
            'supplier_consumer_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
