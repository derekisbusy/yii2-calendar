<?php
/**
 * @var yii\web\View $this
 * @var common\models\Schedule $model
 * @var yii\widgets\ActiveForm $form
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use yii\web\JsExpression;

Html::beginTag('div', ['id'=>'patient-form']);
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'user_id'=>['type'=> Form::INPUT_WIDGET, 
            'widgetClass'=>Select2::classname(),
            'options'=>[
                'initValueText'=>\Yii::$app->user->identity->username ? \Yii::$app->user->identity->username : null,
                'options' => [
                    'id' => 'leadOwner',
                    ],
                'pluginOptions' => [
                    'allowClear' => true,
    //                    'placeholder' => 'Search for user...',
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => \yii\helpers\Url::toRoute(['//ajax/admin-user']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],
            ],
            'hint'=>Yii::t('backend/patient-form', 'Type and select an employee\'s user account')
        ], 
        'status'=>['type'=> Form::INPUT_WIDGET, 
            'widgetClass'=>Select2::classname(),
            'options'=>[
                'data'=>  \common\models\Schedule::getStatusOptions(),
            ],
        ],
    ]
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 4,
    'attributes' => [
        'min_advance_schedule'=>['type'=> Form::INPUT_WIDGET,
            'hint'=>Yii::t('common/models/schedule','How many in advance must a person schedule an appointment. 0 days means the person can schedule an appointment the same day.'),
            'widgetClass'=> \kartik\widgets\TouchSpin::className(),
                'placeholder'=>'Enter Min Advance Schedule...',
            'options'=>[
                'pluginOptions' => [
                    'postfix'=>'day(s)',
                    'verticalbuttons' => true
                ],
            ]
        ],
        'max_advance_schedule'=>['type'=> Form::INPUT_WIDGET,
            'hint'=>Yii::t('common/models/schedule','The maximum days in advance a person can schedule an appointment. 0 days means there is no limit.'),
            'widgetClass'=> \kartik\widgets\TouchSpin::className(),
            'options'=>[
                'pluginOptions' => [
                    'postfix'=>'day(s)',
                    'verticalbuttons' => true
                ],
            ]
        ],
        'max_daily_appointments'=>['type'=> Form::INPUT_WIDGET,
            'hint'=>Yii::t('common/models/schedule','Maximum number of appointments that can be scheduled per day. 0 means no limit.'),
            'widgetClass'=> \kartik\widgets\TouchSpin::className(),
            'options'=>[
                'pluginOptions' => [
                    'verticalbuttons' => true
                ],
            ]
        ],
        'max_weekly_appointments'=>['type'=> Form::INPUT_WIDGET,
            'hint'=>Yii::t('common/models/schedule','Maximum number of appointments that can be scheduled per week. 0 means no limit.'),
            'widgetClass'=> \kartik\widgets\TouchSpin::className(),
            'options'=>[
                'pluginOptions' => [
                'defaultValue'=>1,
                    'verticalbuttons' => true
                ],
            ]
        ],

        'require_confirmation'=>['type'=> Form::INPUT_WIDGET, 
            'widgetClass'=>Select2::classname(),
            'options'=>[
                'data'=>  \common\models\Schedule::getConfirmationOptions(),
                'pluginOptions'=>['minimumResultsForSearch'=>'Infinity']
                ],
        ],
    ]
]);

//echo Form::widget([
//'model' => $model,
//'form' => $form,
//'columns' => 1,
//'attributes' => [
//    
//    ]
//    ]);

echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end(); 
Html::endTag('div');
