<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Event $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'goal',
            'price',
            [
                'attribute' => 'supplier_consumer_id',
                'label' => 'Поставщик',
                'value' => function($model) {
                    return $model->supplierConsumer->name;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus();
                }
            ]
        ],
    ]) ?>

    <p>
        <?= Html::a('Подтвердить', ['approve', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
