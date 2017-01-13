<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Schedule $model
 */

$this->title = Yii::t('backend/schedule', 'Update {modelClass}: ', [
    'modelClass' => 'Schedule',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/schedule', 'Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/schedule', 'Update');
?>
<div class="schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
