<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\CustomerDetail $model
 */

$this->title = 'Update Customer Detail: ' . ' ' . $model->id_customer;
$this->params['breadcrumbs'][] = ['label' => 'Customer Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_customer, 'url' => ['view', 'id' => $model->id_customer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
