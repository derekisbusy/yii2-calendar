<?php
/**
 * @var yii\web\View $this
 * @var common\models\ScheduleRule $model
 */
use yii\helpers\Html;

$this->title = Yii::t('backend/schedule-rule', 'Create {modelClass}', [
    'modelClass' => 'Schedule Rule',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/schedule-rule', 'Schedule Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-rule-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
