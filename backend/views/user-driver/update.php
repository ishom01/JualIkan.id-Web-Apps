<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserDriver */

$this->title = $model->driver_full_name;
// $this->params['breadcrumbs'][] = ['label' => 'User Drivers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->driver_id, 'url' => ['view', 'id' => $model->driver_id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-driver-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
