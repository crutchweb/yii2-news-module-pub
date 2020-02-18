<?

use gtd\modules\news\modules\frontend\assets\NewsIndexAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = $model->name;
$this->params['header']        = ($this->params['header']) ? $this->params['header'] : $model->name;
$this->params['breadcrumbs'][] = ["label" => "Новости", "url" => "/news"];
$this->params['breadcrumbs'][] = ["label" => $model_group->name, "url" => Url::toRoute(['/news/default/group', 'url' => $model_group->url])];
$this->params['breadcrumbs'][] = $this->params['header'];

NewsIndexAsset::register($this);
?>

<div class="news__page view__news" itemscope itemtype="http://schema.org/NewsArticle">
    <!--shema-->
    <span class="hidden" itemprop="datePublished"><?= explode(' ', $model->timestamp_start)[0]; ?></span>
    <span class="hidden" itemprop="dateModified"><?= explode(' ', $model->timestamp_update)[0]; ?></span>
    <span class="hidden" itemprop="author"><?= Yii::$app->name; ?></span>
    <span class="hidden" itemprop="mainEntityOfPage"><?= Yii::$app->request->absoluteUrl; ?></span>
    <div  class="hidden" itemtype="https://schema.org/Organization" itemscope="itemscope" itemprop="publisher">
        <link itemprop="url" href="<?= $domain; ?>">
        <span itemprop="name"><?= Yii::$app->name; ?></span>
        <span itemprop="address"><?= isset(Yii::$app->geography->mainAddress["value"]) ? Yii::$app->geography->mainAddress["value"] : 'ул. 8 Марта, 269'; ?></span>
        <span itemprop="telephone"><?= isset(Yii::$app->geography->phone->value) ? Yii::$app->geography->phone->value : '8 800 234-59-60'; ?></span>
        <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <span href="<?= $image; ?>" itemprop="thumbnail"><?= $image; ?></span>
            <span href="<?= $image; ?>" itemprop="url"><?= $image; ?></span>
            <meta itemprop="width" content="750">
            <meta itemprop="height" content="291">
        </span>
        <a itemprop="url" href="<?= $domain; ?>" target="_blank" itemprop="sameAs" rel="noopener"><?= Yii::$app->name; ?></a>
    </div>
    <div class='hidden' itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
        <p itemprop="caption"><?= $this->params['header']; ?></p>
        <span href="<?= $image ?>" itemprop="thumbnail"><?= $image; ?></span>
        <span href="<?= $image ?>" itemprop="url"><?= $image; ?></span>
    </div>
    <div class="content">
        <!--heading-->
        <div class="row">
            <div class="col-md-6">
                <div class="title__h3 set--bold" itemprop="headline"><?= $this->title; ?></div>
            </div>
            <div class="col-md-6">
                <ul class="socials__ul ul--reset li--line">
                    <li>Поделиться:</li>
                    <li>
                        <a href="http://vk.com/share.php?url=<?= Yii::$app->request->absoluteUrl; ?>&title=<?= $this->title; ?>&image=<?= $model->getSrc(); ?>&noparse=true" target="_blank" rel="nofollow">
                            <i class="fa fa-vk fa-1x t--clr" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://connect.ok.ru/offer?url=<?= Yii::$app->request->absoluteUrl; ?>&title=<?= $this->title; ?>&imageUrl=<?= $model->getSrc(); ?>" target="_blank" rel="nofollow">
                            <i class="fa fa-odnoklassniki fa-1x t--clr" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?= Yii::$app->request->absoluteUrl; ?>&p[title]=<?= $this->title; ?>&p[images][0]=<?= $model->getSrc(); ?>" target="_blank" rel="nofollow">
                            <i class="fa fa-facebook fa-1x t--clr" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--end heading-->
        <div class="row">
            <div class="col-md-6">
                <div class="wysiwyg__block" itemprop="description">
                    <?= $model->text ?>
                </div>
                <div class="wysiwyg__actions">
                    <div class="left">
                        <?= Html::a($model_group->name, Url::toRoute(['/news/default/group', 'url' => $model_group->url]), [
                                'class'=> 'category__href'
                        ])?>
                    </div>
                    <div class="right news__timestamp">
                        <?= Yii::$app->formatter->asDate($model->timestamp_start, 'd MMMM yyyy'); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-md-6">
                <?= Html::img($image, [
                        'class' => 'img-responsive',
                        'alt'   => $this->title,
                        'title' => $this->title
                ]); ?>
            </div>
        </div>
        <div class="page__actions">
            <div class="row">
                <div class="col-md-offset-5 col-md-2">
                    <?= Html::a('Назад', '/news', ['class'=> 'btn btn--md s--bg set--block'])?>
                </div>
            </div>
        </div>
    </div>
</div>