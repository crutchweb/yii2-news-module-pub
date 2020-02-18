<?

use yii\helpers\Html;
use yii\helpers\Url;
use gtd\modules\news\modules\frontend\assets\NewsIndexAsset;
use gtd\modules\news\modules\frontend\widgets\CardItem;

$this->title                   = "Новости в категории - " . $model_group->name;
$this->params['breadcrumbs'][] = ["label" => "Новости", "url" => "/news"];
$this->params['breadcrumbs'][] = $model_group->name;

NewsIndexAsset::register($this);
?>

<div class="content news__page">
    <div class="title__h3 set--bold"><?= $this->title; ?></div>
    <!--nav-->
    <div class="row">
        <div class="col-md-3">
            <a href="<?= Url::to('/news')?>" class="grid__cell set--valign">
                <span>Все новости</span>
            </a>
        </div>
        <? foreach ($models_group as $news_group): ?>
            <? if (count($news_group['newsToGroup']) > 0 && $news_group['id'] != 1): ?>
                <div class="col-md-3">
                    <a href="<?= Url::toRoute(['/news/default/group', 'url' => $news_group['url']]) ?>"
                       class="grid__cell set--valign <? if ($model_group->id == $news_group['id']) { echo 'in'; } ?>">
                        <span><?= $news_group->name; ?></span>
                    </a>
                </div>
            <? endif; ?>
        <? endforeach; ?>
    </div>

    <!--carts-->
    <div class="row carts news">
        <? if ($models_news): ?>
            <? foreach ($models_news as $news): ?>
                <?= CardItem::widget(['model' => $news]) ?>
            <? endforeach; ?>
        <? else: ?>
            <div class="title__h3 set--bold set-tcenter">Новостей не найдено...</div>
        <? endif; ?>
    </div>
    <div class="page__actions">
        <? if (count($models_news) >= 12): ?>
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <?= Html::a('Загрузить еще...', '#', [
                    'class'             => 'btn btn--md s--bg set--block',
                    'data-cat_id'       => $model_group->id,
                    'data-loading-text' => "Загрузка <i class='fa fa-circle-o-notch fa-spin'></i>",
                    'data-error-text'   => "Произошла ошибка <i class='fa fa-exclamation-triangle' aria-hidden='true'></i>",
                    'id'                => 'load_more'
                ])?>
            </div>
        </div>
        <? endif; ?>
    </div>
</div>

<?= frontend\widgets\fastLink\fastLink::widget(); ?>


