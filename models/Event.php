<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $created_at
 * @property string $goal
 * @property string $price
 * @property int $supplier_consumer_id
 * @property int $status
 *
 * @property SupplierConsumer $supplierConsumer
 */
class Event extends \yii\db\ActiveRecord
{
    public const STATUS_CREATED = 0;
    public const STATUS_APPROVED = 1;

    public const STATUSES = [
        self::STATUS_CREATED => 'Создано',
        self::STATUS_APPROVED => 'Подтверждено',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goal', 'price', 'supplier_consumer_id'], 'required'],
            [['created_at'], 'safe'],
            [['supplier_consumer_id', 'status'], 'integer'],
            [['goal', 'price'], 'string', 'max' => 255],
            [['supplier_consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierConsumer::class, 'targetAttribute' => ['supplier_consumer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'goal' => 'Goal',
            'price' => 'Price',
            'supplier_consumer_id' => 'Supplier Consumer ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[SupplierConsumer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierConsumer()
    {
        return $this->hasOne(SupplierConsumer::class, ['id' => 'supplier_consumer_id']);
    }

    public function beforeSave($insert)
    {
        if($insert) {
            $this->status = self::STATUS_CREATED;
            $this->created_at = (new \DateTime("NOW"))->format("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    public function getStatus()
    {
        return self::STATUSES[$this->status];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->status == self::STATUS_APPROVED) {
            $this->notifySupplierConsumer();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    private function notifySupplierConsumer()
    {
        $mapping = explode(';', $this->supplierConsumer->mapping);
        $data = [];
        foreach($mapping as $row) {
            $pair = explode('=>', $row);
            $data[$pair[0]] = $this->{$pair[1]};
        }

        $c = curl_init($this->supplierConsumer->endpoint . ($this->supplierConsumer->method == 'GET' ? '?'.http_build_query($data) : ''));
        if($this->supplierConsumer->method == 'POST') {
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        }
        curl_setopt($c, CURLOPT_HEADER, false);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($c);
        curl_close($c);
    }
}