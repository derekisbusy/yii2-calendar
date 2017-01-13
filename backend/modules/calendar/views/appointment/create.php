<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ScheduleAppointment $model
 */

$this->title = Yii::t('backend/schedule/appointment', 'Create {modelClass}', [
    'modelClass' => 'Schedule Appointment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/schedule/appointment', 'Schedule Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-appointment-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'appointment' => $appointment,
    ]) ?>

</div>
