<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_consumer}}`.
 */
class m221020_013725_create_supplier_consumer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_consumer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'mapping' => $this->string()->notNull(),
            'endpoint' => $this->string()->notNull(),
            'method' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
          'event-supplier_consumer-fk',
          'event',
          'supplier_consumer_id',
          'supplier_consumer',
          'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('event-supplier_consumer-fk', 'event');
        $this->dropTable('{{%supplier_consumer}}');
    }
}
