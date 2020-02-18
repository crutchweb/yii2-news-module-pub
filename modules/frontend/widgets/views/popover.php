<?

use gtd\modules\news\modules\frontend\widgets\NewsWidgetsAssets;
use yii\helpers\Html;
use yii\helpers\Url;

NewsWidgetsAssets::register($this);
?>
<li class="popover__link set--tleft">
    <?= Html::a('Новости', Url::to('/news'), ['data-count' => '', 'class' => 'counter__link nobefore fr--clr']); ?>
    <div class="popover__widget news__popover">
        <div class="widget__title">Непрочитанные новости</div>
        <div class="widget__body">
            <div class="scroller">      
                <? foreach ($model as $news): ?>
                    <a href="<?= Url::toRoute(['/news/default/view', 'url' => $news['url']]); ?>" data-news-id="<?= $news['id']; ?>" class="widget__item">
                        <div class="widget__data">
                            <p><?= \gtd\helpers\text\TextHelper::cut($news['text'], 107, '...') ?></p>
                            <div class="left widget__tag"><?= $news['newsGroup']['name'] ?></div>
                            <div class="right widget__date"><?= Yii::$app->formatter->asDate($news['timestamp_start'], 'dd.MM.yyyy'); ?></div>
                            <div class="clear"></div>
                        </div>
                    </a>
                <? endforeach; ?>
                <div class="scroller__bar" style="top: 36px; height: 324.662px;"></div>
            </div>
        </div>
    </div>
</li>

 