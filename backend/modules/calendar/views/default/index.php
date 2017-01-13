<?php
/* @var $this yii\web\View */


$this->registerJs('var appointmentUrl = "' . yii\helpers\Url::to('/backend/appointment') . '";', yii\web\View::POS_HEAD);
derekisbusy\calendar\backend\assets\ScheduleAsset::register($this);

echo \derekisbusy\calendar\widgets\fullcalendar\FullCalendarWidget::widget(['id'=>'calendar',
    'pluginOptions'=>[
        'events'=>\yii\helpers\Url::toRoute('calendar-events'),
        'eventClick'=>new yii\web\JsExpression('calendarEventClick')]]);

?>
