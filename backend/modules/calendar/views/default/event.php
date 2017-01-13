<?php
/**
 * @var yii\web\View $this
 * @var common\models\ScheduleAppointment $appointment
 * @var yii\widgets\ActiveForm $form
 */
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use yii\web\JsExpression;
use kartik\widgets\Select2;

$appointment->status_id=null;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
'model' => $appointment,
'form' => $form,
'columns' => 2,
'attributes' => [
    'assigned_to'=>['type'=> Form::INPUT_WIDGET, 
            'widgetClass'=>Select2::classname(),
            'hint'=>Yii::t('backend/schedule/appointment', 'Type and select an employee\'s user account'),
            'options'=>[
//                    'value'=>\Yii::$app->user->isGuest ? null : \Yii::$app->user->identity->getId(),
//                    'initValueText'=>\Yii::$app->user->identity->username,
                'options' => [
//                        'id' => 'assignedTo',
                    ],
                'pluginOptions' => [
                    'allowClear' => true,
//                    'placeholder' => 'Search for user...',
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
            ],
    ],
    'status_id'=>['type'=> Form::INPUT_WIDGET, 
        'widgetClass'=>Select2::classname(),
//            'hint'=>'',
        'options'=>[
            'options'=>[
            'prompt'=>'Select status',],
            'data'=>  \common\models\ScheduleAppointmentStatus::getStatuses(),
        ],
    ],
    'start_date'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>DateControl::classname(),
        'options'=>['type'=>DateControl::FORMAT_DATE,
            'options'=>[
                'type'=> \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
                'value'=>date_format(date_create($appointment->start_at),'m/d/Y'),
                'pluginOptions'=>[
                    'startDate'=>'today',
                    'endDate'=>'+3m',
                    'todayHighlight'=>true,
                    'stepping'=>30,
                    'autoclose' => true,
                ],
                'options'=>[
                    'placeholder'=>'mm/dd/yyyy'
                ],
            ],
        ],
    ],
    'start_time'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>DateControl::classname(),
        'options'=>['type'=>DateControl::FORMAT_TIME,
            'options'=>[
                'pluginOptions'=>[
                    'defaultTime'=>date_format(date_create($appointment->start_at),'H:i A'),
                    'showSeconds'=>false,
                    'modalBackdrop'=>true,
                ],
            ],
        ],
    ],
    'end_date'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>DateControl::classname(),
        'options'=>['type'=>DateControl::FORMAT_DATE,
            'options'=>[
                'type'=> \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
                'value'=>date_format(date_create($appointment->end_at),'m/d/Y'),
                'pluginOptions'=>[
                    'startDate'=>'today',
                    'endDate'=>'+3m',
                    'todayHighlight'=>true,
                    'stepping'=>30,
                    'autoclose' => true,
                ],
                'options'=>[
                    'placeholder'=>'mm/dd/yyyy'
                ],
            ],
        ],
    ],
    'end_time'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>DateControl::classname(),
        'options'=>[
            'type'=>DateControl::FORMAT_TIME,
            'options'=>[
                'pluginOptions'=>[
                    'defaultTime'=>date_format(date_create($appointment->end_at),'H:i A'),
                    'showSeconds'=>false,
                    'modalBackdrop'=>true,
                ],
            ],
        ],
    ],
]]);
    
//    echo Form::widget([
//    'model' => $model,
//    'form' => $form,
//    'columns' => 2,
//    'attributes' => [
//        
//        ]
//    ]);
