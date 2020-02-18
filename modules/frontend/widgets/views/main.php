<?

use gtd\helpers\text\TextHelper;
use yii\helpers\Html;
use yii\helpers\Url;

\gtd\modules\news\assets\AppAsset::register($this);

Yii::$app->formatter->locale = 'ru-RU';
?>

<div class="content">
    <div class="title__h3 set--bold">Новости по темам</div>
    <div class="row widget--vtabs">
        <div class="col-sm-4">
            <?=
            yii\helpers\Html::a('Все новости', '/news', [
                'title' => 'Все новости',
                'class' => 'widget__nav'
            ]);
            ?>
            <? $i = 0; ?>
            <? foreach ($model as $news_group): ?>
                <? if (count($news_group['newsToGroup']) > 0 && $news_group['id'] != 1): ?>
                    <div class="widget__nav <?= ($i == 0) ? 'in' : '' ?>" id="nav-<?= $news_group['id'] ?>">
                        <?= $news_group['name'] ?>
                    </div>
                    <? $i++; ?>
                <? endif; ?>
            <? endforeach; ?>
        </div>
        <div class="col-md-8">
            <div class="shadow-wrap">
                <div class="widget__body">
                    <div class="scroller">
                        <? $q = 0; ?>
                        <? foreach ($model as $news_group): ?>
                            <? if (count($news_group['newsToGroup']) > 0 && $news_group['id'] != 1): ?>
                                <div class="widget__tab <?= ($q == 0) ? 'in' : '' ?>" data-parent="nav-<?= $news_group['id']; ?>">
                                    <? foreach ($news_group['newsToGroup'] as $news): ?>
                                        <div class="widget__item">
                                            <div class="title__h4 set--bold"><?= $news['name']; ?></div>
                                            <p class="s--clr"><?= TextHelper::cut(strip_tags($news['text'], '<p>'), 200, '...') ?></p>
                                            <div class="left">
                                                <?=
                                                yii\helpers\Html::a('Подробнее', Url::toRoute(['/news/default/view', 'category' => $news['news_group_url'], 'url' => $news['url']]), [
                                                    'title' => 'Подробнее',
                                                    'class' => 'btn btn--wht btn--sm'
                                                ]);
                                                ?>
                                            </div>
                                            <div class="right">
                                                <span class="set--bold uppercase s--clr">
                                                    <?= Yii::$app->formatter->asDate($news['timestamp_start'], 'd MMMM yyyy'); ?>
                                                </span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                                <? $q++; ?>
                            <? endif; ?>
                        <? endforeach; ?>
                    </div>
                    <div class="scroller__bar"></div>
                </div>
            </div>
        </div>
    </div>
</div>