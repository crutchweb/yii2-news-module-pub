<?php

namespace gtd\modules\news\modules\frontend;

use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package gtd\modules\news\modules\frontend
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'gtd\modules\news\modules\frontend\controllers';
    public $defaultRoute        = 'news';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $rules = [
            '/news' => '/news/default/index',
            '/news/<url:[a-z0-9\-_\.]+$>' => '/news/default/group',
            '/news/<category:[a-z0-9\-_\.]+>/<url:[\/\w\.\-]+$>' => '/news/default/view',
            '/ajax-news-cards' => '/news/default/ajax-news-cards',
        ];
        $app->getUrlManager()->addRules($rules, false);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}