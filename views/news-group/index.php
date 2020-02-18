<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

$this->title = 'Группы новостей';
$this->params['breadcrumbs'][] = ["label" => $this->title];

?>

<?=
Breadcrumbs::widget([
    'homeLink' => [
            'label' => Yii::t('yii', 'Главная'),
            'url'   => Yii::$app->homeUrl,
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>

<div class="panel-group panel-action">
    <div class="panel panel-default">
        <div class="panel-heading cursor-pointer <?= (!$cookiePanel) ? 'collapsed' : '' ?>" data-toggle="collapse" href="#panel-action" aria-expanded="true">
            <h4 class="panel-title">Действия</h4>
        </div>
        <div id="panel-action" class="panel-collapse collapse <?= ($cookiePanel) ? 'in' : '' ?>" aria-expanded="false">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?=
                        Html::a(
                            'Добавить <i class="fa fa-plus"></i>', Url::toRoute([Yii::$app->controller->id.'/view']), [
                            'class' => 'btn btn-success',
                            'data-pjax' => 0,
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-6 text-right">

                        <?=
                        Html::button(
                            '<span class="badge selected-model-counter">0</span> Удалить <i class="fa fa-remove"></i>', [
                            'class' => 'btn btn-danger remove-models',
                            'disabled' => true,
                            'data-toggle' => 'modal',
                            'data-target' => '#delete',
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? Pjax::begin(['timeout' => 50000, 'id' => 'pjax-content']) ?>

<?
$grid_columns = [
    [
        'attribute' => 'name',
        'contentOptions' => ['class' => 'name'],
    ],
    [
        'attribute' => 'url',
        'contentOptions' => ['class' => 'url'],
    ],
    [
        'attribute' => 'is_active',
        'contentOptions' => ['width' => '120', 'class' => 'is_active'],
        'filter' => Html::activeDropDownList($searchModel, 'is_active', [1 => 'Да', 0 => 'Нет'], ['class' => 'form-control', 'prompt' => 'Все']),
        'value' => function($model) {
            return ($model->is_active) ? "<b class='label label-success'>Да</b>" : "<b class='label label-danger'>Нет</b>";
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'timestamp',
        'contentOptions' => ['class' => 'timestamp'],
        'filter' => DatePicker::widget(['model' => $searchModel, 'attribute' => 'timestamp', 'language' => 'ru', 'pluginOptions' => ['format' => 'yyyy-mm-dd']]),
    ],
    [
        'attribute' => 'timestamp_update',
        'contentOptions' => ['class' => 'timestamp_start'],
        'filter' => DatePicker::widget(['model' => $searchModel, 'attribute' => 'timestamp_update', 'language' => 'ru', 'pluginOptions' => ['format' => 'yyyy-mm-dd']]),
    ],
    [
        'label' => 'Редактировать',
        'contentOptions' => ['width' => '130'],
        'value' => function ($model) {
            $return = Html::a('<i class="fa fa-pencil"></i>', Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]), ['title' => 'Редактировать', 'class' => 'btn btn-primary btn-xs  edit-model', 'data-pjax' => 0]);
            return $return;
        },
        'format' => 'raw',
    ],
    [
        'contentOptions' => ['width' => '40'],
        'label' => '',
        'value' => function($model) {
            return '<input type="checkbox" name="gridSelected[]" value="'.$model->id.'" class="grid-selected" id="grid-selected-'.$model->id.'"><label for="grid-selected-'.$model->id.'"></label>';
        },
        'header' => '<input type="checkbox" id="grid-selected-all"><label for="grid-selected-all"></label>',
        'format' => 'raw',
    ],
];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter' => false,
    'summaryOptions' => ['class' => 'pull-right summary'],
    'caption' => $this->title,
    'captionOptions' => ['class' => ''],
    'options' => ['data-pjax' => 1, 'class' => 'grid-view', 'id' => 'grid-view',],
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'data-path-after' => Url::toRoute([Yii::$app->controller->id.'/move-after']),
        'data-path-before' => Url::toRoute([Yii::$app->controller->id.'/move-before']),
    ],
    'columns' => $grid_columns,
]);
?>

<? Pjax::end() ?>

<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <?
            $form = ActiveForm::begin([
                'method' => 'POST',
                'action' => Url::toRoute([Yii::$app->controller->id.'/delete']),
                'options' => ['class' => 'model-action-form']
            ]);
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-remove" aria-hidden="true"></span></button>
                <h4 class="custom_adivgn" id="Heading">Удаление</h4>
            </div>
            <div class="modal-body">
                <h4 class="modal-title custom_adivgn" id="Heading">Вы действительно хотите удалить выбранные элементы?</h4>
            </div>
            <div class="modal-footer ">
                <?= Html::button('Отмена', ['class' => 'btn btn-default cancel', 'data-dismiss' => 'modal', 'aria-hidden' => 'true']) ?>
                <?=
                Html::submitButton('Удалить', [
                    'class' => 'btn btn-danger action',
                    'data-loading-text' => 'Удаление <i class="fa fa-spinner fa-spin"></i>',
                    'data-error-text' => 'Произошла ошибка <i class="fa fa-warning"></i>',
                ])
                ?>
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>
