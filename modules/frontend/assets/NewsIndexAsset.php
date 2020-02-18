<?php

namespace gtd\modules\news\modules\frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class NewsIndexAsset
 * @package gtd\modules\news\modules\frontend\assets
 */
class NewsIndexAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    public $css        = [
        'css/news'.((YII_DEBUG) ? '' : '.min').'.css?v1.00',
    ];
    public $cssOptions = [
        'onload' => "if(media!='all') media='all'"
    ];
    public $js         = [
        "js/news".((YII_DEBUG) ? '' : '.min').".js?v1.00",
    ];
    public $depends    = [
        'yii\web\JqueryAsset'
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
