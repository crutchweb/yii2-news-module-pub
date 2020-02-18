<?

namespace gtd\modules\news\modules\frontend\widgets;

use Yii;
use gtd\modules\news\models\NewsGroup;
use yii\bootstrap\Widget;

/**
 * Class NewsWidget
 * @package gtd\modules\news\modules\frontend\widgets
 */
class NewsWidget extends Widget
{

    public function run()
    {
        $model = Yii::$app->cache->get('all-news-for-widget');

        if (!$model) {
            $model = NewsGroup::find()
                ->where(['is_active' => 1])
                ->with(['newsToGroup' => function ($query) {
                    $query->where(['not in', 'news_group_id', 1])->orderBy(['timestamp_start' => SORT_DESC]);
                }])
                ->asArray()
                ->limit(12)
                ->all();
        }

        Yii::$app->cache->set('all-news-for-widget', $model, 3600*12);

        return $this->render('main', [
            'model' => $model
        ]);
    }
}