<?php
/**
 * @var yii\web\View $this
 * @var biz\purchase\models\PurchaseHdr $model
 */
$this->title = 'Update Transfer: ' . $model->transfer_num;
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transfer_num, 'url' => ['view', 'id' => $model->id_transfer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-hdr-update">
    <?php
    echo $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'masters' => $masters,
    ]);
    ?>

</div>