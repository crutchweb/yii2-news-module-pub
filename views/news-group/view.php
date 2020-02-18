<?

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
?>

<? $this->title                   = 'Группы новостей'; ?>
<? $this->params['breadcrumbs'][] = ["label" => $this->title, "url" => Url::toRoute([Yii::$app->controller->id.'/index'])]; ?>

<? if ($model): ?>
    <? $this->params['breadcrumbs'][] = $model->name; ?>
<? endif; ?>

<?=
Breadcrumbs::widget([
    'homeLink' => [
        'label' => Yii::t('yii', 'Главная'),
        'url' => Yii::$app->homeUrl,
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?>

<h3>Рубрика "<?= $model->name ?>"</h3>
<div class="tab-content">
    <div class="tab-pane fade in active" id="tab-main">
        <?
        $form = ActiveForm::begin([
                'id' => 'action-form',
                'method' => 'POST',
                'action' => Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]),
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
                'enableAjaxValidation' => false,
                'enableClientValidation' => true
        ]);
        ?>
        <div class="hidden">
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-md-6">
                <?=
                $form->field($model, 'timestamp')->widget(DateTimePicker::classname(), [
                    'options' => [
                        'value' => (!$model->timestamp || $model->timestamp == "0000-00-00 00:00:00") ? date('Y-m-d H:i:s') : $model->timestamp,
                    ],
                    'pluginOptions' => [
                        'startDate' => date('Y-m-d H:i:s'),
                        'format' => 'yyyy-mm-dd hh:ii:ss',
                        'autoclose' => true,
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'alias'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'url'); ?>
            </div>
        </div>
        <h4>SEO атрибуты</h4>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'meta_title'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'meta_keywords')->textarea(); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'meta_description')->textarea(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($model, 'is_active', ["template" => "{input}{label}"])
                    ->checkbox(["class" => "checkbox"], false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'action-button']) ?>
        </div>
        <? ActiveForm::end(); ?>
    </div>
</div>

