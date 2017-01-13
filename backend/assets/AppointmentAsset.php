<?php

namespace derekisbusy\calendar\backend\assets;

use yii\web\AssetBundle;


class AppointmentAsset extends AssetBundle
{
    public $sourcePath = '@vendor/derekisbusy/yii2-calendar/backend/assets';
    public $css = [
//        'css/patientApplication.css',
    ];
    public $js = [
        'js/appointments.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
