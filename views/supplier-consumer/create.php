<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SupplierConsumer $model */

$this->title = 'Create Supplier Consumer';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Consumers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-consumer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
