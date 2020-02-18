<?php

namespace gtd\modules\news\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use backend\components\MainController;
use gtd\modules\news\models\NewsGroup;
use gtd\modules\news\models\NewsGroupSearch;
use gtd\modules\news\models\NewsGroupForm;

/**
 * Class NewsGroupController
 * @package gtd\modules\news\controllers
 */
class NewsGroupController extends MainController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => false,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => [1, 8],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $cookiePanel  = (isset(Yii::$app->request->cookies["panel-action"])) ? Yii::$app->request->cookies["panel-action"]->value : NULL;
        $searchModel  = new NewsGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelForm    = new NewsGroupForm();

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'modelForm' => $modelForm,
                'cookiePanel' => $cookiePanel,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionView(int $id = 0)
    {
        if (!$id) {
            $model = new NewsGroupForm();
            $model->save(false);
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/view', 'id' => $model->id]));
        }

        $model = NewsGroupForm::findOne(['id' => $id]);
        if ($model && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Элемент сохранен.');
        }

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $group_model = new NewsGroup();
        $group_model = $group_model::findAll(['is_active' => 1]);

        return $this->render('view', [
            'model'       => $model,
            'group_model' => $group_model
        ]);
    }

    /**
     * Delete category
     * @return bool
     */
    public function actionDelete()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $selectModels               = Yii::$app->request->post('gridSelected');

        foreach ($selectModels as $id) {
            $model = NewsGroup::findOne(['id' => (int) $id]);
            $model->delete();
        }
        Yii::$app->getSession()->setFlash('danger', 'Выбранные элементы удалены.');
        return true;
    }
}