<?php

namespace derekisbusy\calendar\widgets\fullcalendar;

use yii\web\AssetBundle;

class FullCalendarPrintAsset extends AssetBundle
{
    public $sourcePath = '@npm/fullcalendar/dist';
    public $cssOptions = ['media'=>'print'];
    public $css = [
        'fullcalendar.print.css',
    ];
    public $depends = [
        'derekisbusy\calendar\widgets\fullcalendar\FullCalendarAsset',
    ];
}