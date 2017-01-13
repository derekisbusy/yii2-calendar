<?php
/**
 * @var yii\web\View $this
 * @var common\models\ScheduleAppointmentForm $appointment
 * @var yii\widgets\ActiveForm $form
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use yii\web\JsExpression;
use kartik\widgets\Select2;
$start=new DateTime($appointment->start_at);
$end=new DateTime($appointment->end_at);
$appointment->date=$start->format('Y-m-d');
$appointment->start_time=$start->format('H:i A');
$appointment->end_time=$end->format('H:i A');
Html::beginTag('div',['class'=>'schedule-appointment-form']);
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
'model' => $appointment,
'form' => $form,
'columns' => 2,
'attributes' => [
    'patient_id'=>['type'=> Form::INPUT_WIDGET, 
        'widgetClass'=>Select2::classname(),
        'hint'=>Yii::t('common/models/schedule-appointment', 'Type and select an patient\'s user account'),
        'options'=>[
            'initValueText'=>$appointment->patient ? $appointment->patient->getLastNameFirst() : null,
            'pluginOptions' => [
                'placeholder'=>\Yii::t('common/models/schedule-appointment','Select patient').'...',
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
        ],
    ],
    'assigned_to'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>Select2::classname(),
        'hint'=>Yii::t('common/models/schedule-appointment', 'Type and select an employee\'s user account'),
        'options'=>[
            'initValueText'=>$appointment->assignedTo ? $appointment->assignedTo->username : null,
            'pluginOptions' => [
                'allowClear' => true,
                'placeholder' => \Yii::t('common/models/schedule-appointment','Search for user').'...',
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
    'type_id'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>Select2::classname(),
//            'hint'=>'',
        'options'=>[
            'hideSearch'=>true,
            'options'=>[
                'prompt'=>\Yii::t('common/models/schedule-appointment','Select appointment type').'...'
                ],
            'data'=>  \common\models\ScheduleAppointmentType::getTypes(),
        ],
    ],
    'status_id'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>Select2::classname(),
//            'hint'=>'',
        'options'=>[
            'hideSearch'=>true,
            'options'=>[
            'prompt'=>'Select status',],
            'data'=>  \common\models\ScheduleAppointmentStatus::getStatuses(),
        ],
    ],
    'date'=>['type'=> Form::INPUT_WIDGET,
        'widgetClass'=>DateControl::classname(),
        'options'=>['type'=>DateControl::FORMAT_DATE,
            'options'=>[
                'type'=> \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
                'pluginOptions'=>[
                    'startDate'=>'today',
                    'endDate'=>'+3m',
                    'todayHighlight'=>true,
                    'stepping'=>30,
                    'autoclose' => true,
                ],
                'options'=>[
                    'placeholder'=>'mm/dd/yyyy',
                ],
            ],
        ],
    ],
    'timespan'=>['type'=> Form::INPUT_RAW,
        'label'=>false,
        'labelOptions'=>['style'=>'display:none'],
        'attributes'=>[
            'start_time'=>['type'=> Form::INPUT_WIDGET,
                'widgetClass'=>DateControl::classname(),
                'label'=>\Yii::t('common/models/schedule-appointment','Start Time'),
                'options'=>['type'=>DateControl::FORMAT_TIME,
                    'options'=>[
                        'pluginOptions'=>[
//                            'defaultTime'=>date_format(date_create($appointment->start_at),'H:i A'),
                            'showSeconds'=>false,
                        ],
                    ],
                ],
            ],
            'end_time'=>['type'=> Form::INPUT_WIDGET,
                'widgetClass'=>DateControl::classname(),
                'label'=>\Yii::t('backend/schedule/appointment','End Time'),
                'options'=>[
                    'type'=>DateControl::FORMAT_TIME,
                    'options'=>[
                        'pluginOptions'=>[
//                            'defaultTime'=>date_format(date_create($appointment->end_at),'H:i A'),
                            'showSeconds'=>false,
                            'modalBackdrop'=>true,
                        ],
                    ],
                ],
            ],
        ]
    ],
]]);

echo Html::submitButton($appointment->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $appointment->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();

Html::endTag('div');
