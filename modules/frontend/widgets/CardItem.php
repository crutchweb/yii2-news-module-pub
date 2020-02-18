<?php

namespace gtd\modules\news\modules\frontend\widgets;

use gtd\modules\news\models\News;
use gtd\modules\news\models\NewsGroup;
use yii\bootstrap\Widget;

/**
 * Class CardItem
 * @package gtd\modules\news\modules\frontend\widgets
 */
class CardItem extends Widget
{
    public $model;
    public $group;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('card_item', [
                'model' => $this->model,
                'group' => $this->group
        ]);
    }
}
?>
