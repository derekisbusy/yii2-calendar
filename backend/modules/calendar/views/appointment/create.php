<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var derekisbusy\calendar\models\Appointment $model
 */

$this->title = Yii::t('calendar', 'Create {modelClass}', [
    'modelClass' => 'Schedule Appointment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('calendar', 'Schedule Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'appointment' => $appointment,
    ]) ?>

</div>
