<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\ScheduleRule $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="schedule-rule-form">

<?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'schedule_id'=>['type'=> Form::INPUT_WIDGET, 
            'widgetClass'=>Select2::classname(),
            'options'=>[
                'initValueText'=>$model->schedule ? $model->schedule->user->username : null,
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['/calendar/ajax/user-schedule']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(schedule) { return schedule.text; }'),
                    'templateSelection' => new JsExpression('function (schedule) { return schedule.text; }'),
                ],
            ],
            'hint'=>Yii::t('backend/patient-form', 'Type and select a user account')
        ],
        'type'=>['type'=> Form::INPUT_DROPDOWN_LIST, 
                'items'=>\common\models\ScheduleRule::getTypeOptions(),
                'options'=>[
                    'prompt'=>'',
                ]
        ],
    ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 6,
    'attributes' => [
        'availability'=>[
            'columnOptions'=>['colspan'=>1],
            'type'=> Form::INPUT_WIDGET,
            'widgetClass'=> SwitchInput::className(),
            'options'=>[
                    'pluginOptions'=>[
                        'handleWidth'=>60,
                        'onText'=>Yii::t('common','Available'),
                        'offText'=>Yii::t('common','Unavailable')
                    ]
                ]
        ],
        'label'=>[
            'columnOptions'=>['colspan'=>5],
            'type'=> Form::INPUT_TEXT,
            'options'=>[
                'placeholder'=>'Enter Label...',
                'maxlength'=>20
            ]
        ],
    ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'start_date'=>[
            'type'=> Form::INPUT_WIDGET,
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
        'end_date'=>[
            'type'=> Form::INPUT_WIDGET,
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
        'start_at'=>[
            'type'=> Form::INPUT_WIDGET,
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
        'end_at'=>['type'=> Form::INPUT_WIDGET,
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
        'weight'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Weight...']], 

        'day_of_year'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Day Of Year...']], 

        'week_number'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Week Number...']], 

        'holiday'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Holiday...']], 

        'day_of_week'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Day Of Week...', 'maxlength'=>0]], 


    ]
]);
echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();
?>

</div>
