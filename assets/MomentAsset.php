<?php
namespace derekisbusy\calendar\assets;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{
    public $sourcePath = '@bower/moment';
    public $css = [
    ];
    public $js = [
        'moment.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
