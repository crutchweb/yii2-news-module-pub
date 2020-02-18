<?php

namespace gtd\modules\news\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $depends = [
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init()
    {
        $min = (YII_DEBUG) ? "" : ".min";

        $this->includeJs($min);
        $this->includeCss($min);

        $this->sourcePath = __DIR__."";
        parent::init();
    }

    private function includeCss($min)
    {
        // custom initialization assets goes here
    }

    private function includeJs($min)
    {
        // custom initialization assets goes here
    }
}