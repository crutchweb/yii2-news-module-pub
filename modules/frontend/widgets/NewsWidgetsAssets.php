<?php

namespace gtd\modules\news\modules\frontend\widgets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class NewsWidgetsAssets
 * @package gtd\modules\news\modules\frontend\widgets
 */
class NewsWidgetsAssets extends AssetBundle
{
    public $sourcePath     = __DIR__.'/assets';
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
    public $cssOptions = [
        'onload' => "if(media!='all') media='all'"
    ];
    public $css            = [
        'css/popover'.((YII_DEBUG) ? '' : '.min').'.css?v1.02',
    ];
    public $js             = [
        "js/popover".((YII_DEBUG) ? '' : '.min').".js?v1.00",
    ];
    public $depends        = [
        'yii\web\JqueryAsset'
    ];

}
