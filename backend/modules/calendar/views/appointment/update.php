<?php
/**
 * @var yii\web\View $this
 * @var derekisbusy\calendar\models\Appointment $model
 */

use yii\helpers\Html;


$this->title = Yii::t('calendar', '{update} {appointment}: ', [
    'update' => \Yii::t('common','Update'),
    'appointment' => \Yii::t('common','Appointment'),
]) . ' ' . $appointment->patient->getLastNameFirst();
$this->params['breadcrumbs'][] = ['label' => Yii::t('calendar', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $appointment->id, 'url' => ['view', 'id' => $appointment->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="schedule-appointment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'appointment' => $appointment,
    ]) ?>

</div>
