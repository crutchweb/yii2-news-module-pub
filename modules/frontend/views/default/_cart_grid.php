<?php
use gtd\modules\news\modules\frontend\widgets\CardItem;
?>

<? if ($models_news): ?>
    <? foreach ($models_news as $news): ?>
        <?= CardItem::widget(['model' => $news]) ?>
    <? endforeach; ?>
<? else: ?>
    <div class="title__h3 set--bold set-tcenter">Новостей не найдено...</div>
<? endif; ?>
