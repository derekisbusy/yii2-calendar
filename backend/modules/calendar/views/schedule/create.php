<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Schedule $model
 */

$this->title = Yii::t('backend/schedule', 'Create {modelClass}', [
    'modelClass' => 'Schedule',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/schedule', 'Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
