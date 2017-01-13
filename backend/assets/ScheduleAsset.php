<?php

namespace derekisbusy\calendar\backend\assets;

use yii\web\AssetBundle;


class ScheduleAsset extends AssetBundle
{
    public $sourcePath = '@vendor/derekisbusy/yii2-calendar/backend/assets';
    public $css = [
//        'css/patientApplication.css',
    ];
    public $js = [
        'js/schedule.js'
    ];
    public $depends = [
        'backend\assets_b\AppAsset',
    ];
}
