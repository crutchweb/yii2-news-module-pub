<?php

namespace gtd\modules\news\models;

use yii\db\ActiveRecord;
use Yii;
use gtd\modules\news\models\News;
use gtd\helpers\text\TextHelper;

/**
 * This is the model class for table "{{%news_group}}".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $url
 * @property bool $is_active
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $timestamp
 * @property string $timestamp_update
 */
class NewsGroup extends ActiveRecord
{
    const ACTIVE   = 1;
    const DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'url', 'alias', 'meta_title', 'meta_keywords', 'meta_description'], 'trim'],
            [['name', 'url', 'alias'], 'string', 'min' => 1, 'max' => 255],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'min' => 0, 'max' => 255],
            [['is_active'], 'default', 'value' => self::DISABLED],
            [['is_active'], 'in', 'range' => [self::ACTIVE, self::DISABLED]],
            [['timestamp', 'timestamp_update'], 'date', 'format' => 'php:Y-m-d H:i:s']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'id',
            'name'             => 'Название рубрики',
            'alias'            => 'Алиас рубрики',
            'url'              => 'Ссылка рубрики',
            'is_active'        => 'Активность',
            'meta_title'       => 'Заголовок SEO',
            'meta_description' => 'meta description',
            'meta_keywords'    => 'meta keywords',
            'timestamp'        => 'Дата создания',
            'timestamp_update' => 'Дата обновления',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsToGroup()
    {
        return $this->hasMany(News::className(), ['news_group_id' => 'id'])
            ->andOnCondition([News::tableName().'.is_active' => News::ACTIVE]);
    }

    /**
     * @param $insert
     * @return mixed
     */
    public function beforeSave($insert)
    {
        if (empty($this->url)) {
            $this->url = TextHelper::slug($this->name, '-', true);
        } else {
            $this->url = TextHelper::slug($this->url, '-', true);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->id == 1) {
            return false;
        }

        $model = new News();
        $newsQuery = $model->find(['news_group_id' => $this->id])
            ->select('id, name, news_group_id')
            ->all();

        foreach ($newsQuery as $news) {
            $news->news_group_id = 1;
            $news->save();
        }

        return parent::beforeDelete();
    }

}