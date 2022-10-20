<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_consumer".
 *
 * @property int $id
 * @property string $name
 * @property string $mapping
 * @property string $endpoint
 *
 * @property Event[] $events
 */
class SupplierConsumer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_consumer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mapping', 'endpoint'], 'required'],
            [['name', 'mapping', 'endpoint', 'method'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mapping' => 'Mapping',
            'method' => 'Method',
            'endpoint' => 'Endpoint',
        ];
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['supplier_consumer_id' => 'id']);
    }
}
