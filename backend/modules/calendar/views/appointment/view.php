<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
/**
 * @var yii\web\View $this
 * @var derekisbusy\calendar\models\Appointment $appointment
 */
$displayDate = date('m/d/Y H:i A',strtotime($appointment->start_at));
$this->title = Yii::t('calendar','{firstNameLast} at {datetime}',['firstNameLast'=>$appointment->patient->getLastNameFirst(true),'datetime'=>$displayDate]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('calendar', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-view">


    <?= DetailView::widget([
            'model' => $appointment,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            ['attribute'=>'id','displayOnly'=>true],
            [
                'attribute'=>'patient_id',
                'value'=>$appointment->patient->getLastNameFirst(),
                'type'=>DetailView::INPUT_SELECT2,
                'widgetOptions'=> [
                    'class'=>Select2::classname(),
                    'initValueText'=>$appointment->patient->getLastNameFirst(),
                    'pluginOptions' => [
                        'placeholder'=>\Yii::t('calendar','Select patient').'...',
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['/ajax/patient']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(user) { return user.text; }'),
                        'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                            
                    ],
                ]
            ],
            [
                'attribute'=>'assigned_to',
                'value'=>$appointment->assignedTo->username,
                'type'=>DetailView::INPUT_SELECT2,
                'widgetOptions'=> [
                    'class'=>Select2::classname(),
                    'initValueText'=>$appointment->assignedTo->username,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'placeholder' => \Yii::t('calendar','Search for user').'...',
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['//ajax/admin-user']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(user) { return user.text; }'),
                        'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                    ],
                ]
            ],
            'type_id',
            [
                'attribute'=>'start_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'end_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            'status_id',
            'created_by',
            'updated_by',
            [
                'attribute'=>'created_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $appointment->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
