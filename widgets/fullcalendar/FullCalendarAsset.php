<?php
namespace derekisbusy\calendar\widgets\fullcalendar;

use yii\web\AssetBundle;


class FullCalendarAsset extends AssetBundle
{
    public $sourcePath = '@npm/fullcalendar/dist';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
        'fullcalendar.min.css',
//        'fullcalendar.print.css',
    ];
    public $js = [
        'fullcalendar.min.js',
        'lang-all.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'derekisbusy\calendar\assets\MomentAsset',
    ];
}