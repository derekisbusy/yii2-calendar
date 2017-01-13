<?php
/**
 * @var yii\web\View $this
 * @var common\models\ScheduleAppointment $model
 */

use yii\helpers\Html;


$this->title = Yii::t('backend/schedule/appointment', '{update} {appointment}: ', [
    'update' => \Yii::t('common','Update'),
    'appointment' => \Yii::t('common','Appointment'),
]) . ' ' . $appointment->patient->getLastNameFirst();
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/schedule/appointment', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $appointment->id, 'url' => ['view', 'id' => $appointment->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/schedule/appointment', 'Update');
?>
<div class="schedule-appointment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'appointment' => $appointment,
    ]) ?>

</div>
