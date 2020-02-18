<?php
use yii\helpers\Url;
use yii\helpers\Html;
use gtd\helpers\text\TextHelper;
?>

<div class="col-md-3">
    <div class="cart__block">
        <a href="<?= Url::toRoute(['/news/default/view', 'category'=>$model->news_group_url, 'url' => $model->url]) ?>">
            <? if ($model->getSrc()): ?>
                <?=
                Html::img($model->getSrc(), [
                    'alt'           => $model->name,
                    'title'         => $model->name,
                    'class'         => 'img-responsive'
                ])
                ?>
            <? endif; ?>
            <div class="cart__desc">
                <div class="title__h4 set--bold">
                    <?= TextHelper::cut($model->name, 45, '...') ?>
                </div>
                <p class="t--clr">
                    <? if (strip_tags($model->text_announcement)): ?>
                        <?= TextHelper::cut($model->text_announcement, 100, '...') ?>
                    <? elseif ($model->text): ?>
                        <?= TextHelper::cut($model->text, 100, '...') ?>
                    <? endif; ?>
                </p>
            </div>
        </a>
        <div class="cart__attr">
            <div class="left">
                <? if($model->newsGroup->alias): ?>
                    <a href="<?= Url::toRoute(['/news/default/group', 'url' => $model->newsGroup->url]); ?>">
                        <?= $model->newsGroup->alias; ?>
                    </a>
                <? endif; ?>
            </div>
            <div class="right">
                <?= Yii::$app->formatter->asDate($model->timestamp_start, 'd MMMM yyyy'); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>