<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\dynagrid\DynaGrid;
use yii\widgets\Pjax;
\edgardmessias\assets\nprogress\NProgressAsset::register($this);
\nirvana\showloading\ShowLoadingAsset::register($this);
\backend\assets_b\AppointmentAsset::register($this);
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('calendar', 'Appointments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
//    ['class' => 'yii\grid\SerialColumn'],
//    'id',
//    [
//        'attribute'=>'patient_name',
//        'filter'=>Html::activeTextInput($searchModel, 'patient_name',['class'=>'form-control','prompt'=>''])
//    ],
    [
        'attribute'=>'assigned_to_username',
        'filter'=>Html::activeTextInput($searchModel, 'assigned_to_username',['class'=>'form-control','prompt'=>''])
    ],
    [
        'attribute' => 'appointment_type',
        'filter' => Html::activeDropDownList($searchModel, 'appointment_type', 
                yii\helpers\ArrayHelper::map(\derekisbusy\calendar\models\AppointmentType::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt'=>'']),
        
    ],
    [
        'attribute' => 'appointment_status',
        'filter' => Html::activeDropDownList($searchModel, 'appointment_status', 
                yii\helpers\ArrayHelper::map(\derekisbusy\calendar\models\AppointmentStatus::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt'=>'']),
        
    ],
    ['attribute'=>'start_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
    ['attribute'=>'end_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
    [
        'attribute'=>'created_by_username',
        'visible'=>false,
        'filter'=>Html::activeTextInput($searchModel, 'created_by_username',['class'=>'form-control','prompt'=>''])
    ],
    [
        'attribute'=>'updated_by_username',
        'visible'=>false,
        'filter'=>Html::activeTextInput($searchModel, 'created_by_username',['class'=>'form-control','prompt'=>''])
    ],
    [
        'attribute'=>'created_at',
        'visible'=>false,
        'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']
    ],
    [
        'attribute'=>'updated_at',
        'visible'=>false,
        'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'buttons' => [
        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['appointment/view','id' => $model->id,'edit'=>'t']), [
                                            'title' => Yii::t('yii', 'Edit'),
                                          ]);}

        ],
    ],
];

Html::beginTag('div',['class'=>'schedule-appointment-index']);
Pjax::begin();
echo DynaGrid::widget([
    'options'=>['id'=>'dynagrid-schedule-appointment'],
    'columns' => $columns,
    'allowThemeSetting'=>false,
    'gridOptions'=>[
        'id'=>'grid-schedule-appointment',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover'=>true,
        'resizableColumns'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'toolbar'=>[
            [
                'content' => 
                    Html::button('<i class="glyphicon glyphicon-calendar"></i>', [
                        'type'=>'a',
                        'href'=>Url::toRoute('schedule/index'),
                        'title'=>Yii::t('backend', 'View appointments in calendar'), 
                        'class'=>'btn btn-default'
                    ])
            ],
            [
                'content'=>
//                        Html::button('<i class="glyphicon glyphicon-plus"></i>', [
//                            'type'=>'button', 
//                            'title'=>Yii::t('backend', 'Add Patient Application'), 
//                            'class'=>'btn btn-success'
//                        ]) . ' '
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default', 
                        'title' => Yii::t('backend', 'Reset')
                    ]),
            ],
            '{dynagrid}',
            '{dynagridFilter}',
            '{dynagridSort}',
            '{export}',
            '{toggleData}'
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Appointment', ['create'], ['class' => 'btn btn-success']),
//                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
//                'showFooter'=>true
        ],
    ]
]);
Pjax::end();
Html::endTag('div');
?>

</div>
