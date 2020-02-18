<?php

namespace gtd\modules\news\modules\frontend\controllers;

use yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use gtd\modules\news\models\News;
use gtd\modules\news\models\NewsGroup;
use gtd\helpers\domain\DomainHelper;
use gtd\modules\seo\behaviors\OgBehavior;
use gtd\modules\seo\behaviors\SeoBehavior;

/**
 * Class DefaultController
 * @package gtd\modules\news\modules\frontend\controllers
 */
class DefaultController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $models_group = NewsGroup::find()
            ->where(['is_active' => 1])
            ->with(['newsToGroup' => function ($query) {
                $query->where(['not in', 'news_group_id', 1]);
            }])
            ->all();

        $models_news = News::find()
            ->where(['is_active' => 1])
            ->orderBy(['timestamp_start' => SORT_DESC])
            ->limit(12)
            ->all();

        $this->attachBehavior('seo-site', [
            'class' => SeoBehavior::className(),
            'model' => $models_group
        ]);

        return $this->render('index', [
                'models_news'  => $models_news,
                'models_group' => $models_group
        ]);
    }

    /**
     * @param string $url
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionGroup(string $url)
    {

        $model_group = NewsGroup::findOne(['url' => $url, 'is_active' => NewsGroup::ACTIVE]);

        if (!$model_group) {
            if (!$model) {
                throw new \yii\web\NotFoundHttpException();
            }
        }

        $models_news = News::find()
            ->where(['is_active' => 1, 'news_group_id' => $model_group->id])
            ->orderBy(['timestamp_start' => SORT_DESC])
            ->limit(12)
            ->all();

        $models_group = NewsGroup::find()
            ->where(['is_active' => 1])
            ->with(['newsToGroup' => function ($query) {
                $query->where(['not in', 'news_group_id', 1]);
            }])
            ->all();

       
        $this->attachBehavior('og-site', [
            'class' => OgBehavior::className(),
            'model' => $model_group,
        ]);

        return $this->render('group', [
            'models_news' => $models_news,
            'model_group' => $model_group,
            'models_group' => $models_group
        ]);
    }

    /**
     * @param string $category
     * @param string $url
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(string $category, string $url)
    {
        $model = News::findOne(['url' => $url, 'news_group_url'=> $category, 'is_active' => News::ACTIVE]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }

        $domain = DomainHelper::getScheme().'://'.DomainHelper::getSubdomain().'.'.DomainHelper::getBase();
        $image  = $domain.'/images/static/bg/gpl-big-logo.png';

        $imageModel = $domain.$model->getSrc(false);
        $image      = ($imageModel) ? $imageModel : $image;

        $model_group = NewsGroup::findOne(['id' => $model->news_group_id, 'is_active' => NewsGroup::ACTIVE]);

        $this->attachBehavior('seo-site', [
            'class' => SeoBehavior::className(),
            'model' => $model
        ]);

        $this->attachBehavior('og-site', [
            'class' => OgBehavior::className(),
            'model' => $model,
            'image' => $image,
        ]);

        return $this->render('view', [
                'domain'      => $domain,
                'model'       => $model,
                'image'       => $image,
                'model_group' => $model_group
        ]);
    }

    /**
     * @param int|null $offset
     * @param int|null $cat_id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAjaxNewsCards(int $offset = null, int $cat_id = null)
    {
        $offset = Yii::$app->request->post('offset');
        $cat_id = Yii::$app->request->post('cat_id');

        $news_query = News::find()
            ->where(['is_active' => 1])
            ->orderBy(['timestamp_start' => SORT_DESC])
            ->limit(12);

        if ($cat_id) {
            $news_query->andWhere(['news_group_id' => $cat_id]);
        }

        if ($offset) {
            $news_query->offset($offset);
        }

        $models_news = $news_query->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'html'  => $this->renderAjax('_cart_grid', ['models_news'  => $models_news]),
            'count' => count($models_news)
        ];
    }
}
