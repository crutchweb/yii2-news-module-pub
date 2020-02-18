<?

namespace gtd\modules\news\modules\frontend\widgets;

use Yii;
use yii\base\Widget;
use gtd\modules\news\models\News;

/**
 * Class NewsWidgetPopover
 * @package gtd\modules\news\modules\frontend\widgets
 */
class NewsWidgetPopover extends Widget
{
 
    public function run()
    {
        $model = News::find()
            ->where(['is_active' => News::ACTIVE])
            ->with(['newsGroup'])
            ->limit(12)
            ->orderBy(['timestamp_start' => SORT_DESC])
            ->all();

        return $this->render('popover', [
            'model' => $model
        ]);
    }
}