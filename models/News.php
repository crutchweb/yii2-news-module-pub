<?
namespace gtd\modules\news\models;

use common\models\debitor\DebitorLog;
use gtd\modules\news\models\NewsGroup;
use Yii;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;
use gtd\helpers\text\TextHelper;

/**
 * This is the model class for table "{{%news_text}}".
 *
 * @property integer $id
 * @property string $image
 * @property string $name
 * @property string $url
 * @property string $news_group_url
 * @property bool $is_active
 * @property string $text_announcement
 * @property string $text
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $timestamp
 * @property int $news_group_id
 * @property string $timestamp_update
 * @property string $timestamp_start
 *
 * @property object $imageFile
 */
class News extends ActiveRecord
{
    const ACTIVE   = 1;
    const DISABLED = 0;

    public $_imagesPath = '/text/news/';
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'news_group_id'], 'integer'],
            [['name', 'url', 'news_group_url', 'meta_title', 'meta_keywords', 'meta_description', 'image'], 'trim'],
            [['name', 'timestamp_start', 'text', 'text_announcement'], 'required'],
            [['name', 'url', 'news_group_url', 'image'], 'string', 'min' => 1, 'max' => 255],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'min' => 0, 'max' => 255],
            [['is_active'], 'default', 'value' => self::DISABLED],
            [['is_active'], 'in', 'range' => [self::ACTIVE, self::DISABLED]],
            [['timestamp', 'timestamp_update', 'timestamp_start'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['text', 'text_announcement'], 'string'],
            [['imageFile'], 'file', 'extensions' => 'jpg, png', 'maxSize' => 512000, 'tooBig' => 'Максимальный размер изображения 500KB']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'image' => 'Изображение',
            'name' => 'Название',
            'url' => 'Ссылка',
            'news_group_url' => 'Ссылка категории',
            'is_active' => 'Активность',
            'text_announcement' => 'Текст анонса',
            'text' => 'Содержание',
            'meta_title' => 'Заголовок SEO',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'timestamp' => 'Дата создания',
            'news_group_id' => 'Рубрика новости',
            'timestamp_update' => 'Дата обновления',
            'timestamp_start' => 'Дата начала показа',
            'imageFile' => 'Изображение',
        ];
    }

    /**
     * Get directory path for save image
     * @param bool $withWebroot
     * @return string
     */

    public function getDirPath(bool $withWebroot = false)
    {
        if ($withWebroot) {
            return Yii::getAlias('@webroot').Yii::$app->params["imageDir"].'/dynamic'.$this->_imagesPath.$this->id;
        }

        return Yii::$app->params["imageDir"].'/dynamic'.$this->_imagesPath.$this->id;
    }

    /**
     * Get image path
     * @param bool $withWebroot
     * @return string
     */
    public function getImagePath(bool $withWebroot = false)
    {
        if ($withWebroot) {
            return $this->getDirPath($withWebroot).'/'.$this->image;
        }

        return $this->getDirPath($withWebroot).'/'.$this->image;
    }

    /**
     * This method checks the image for existence
     * @param bool $getNoImage
     * @return null|string
     */
    public function getSrc($getNoImage = true)
    {
        if ($this->image && file_exists($this->getImagePath(true))) {
            return $this->getImagePath(false);
        }

        if ($getNoImage) {
            return Yii::$app->params["noImage"];
        }

        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsGroup()
    {
        return $this->hasOne(NewsGroup::className(), ['id' => 'news_group_id']);
    }

    /**
     * Root news url
     * @return string
     */
    public function getPath()
    {
        return '/news/'.$this->url;
    }

    /**
     * This method deletes images
     * @return void
     */
    private function delImage()
    {
        if (mb_strlen($this->image) > 0) {
            $path  = $this->getDirPath(true);
            $thumb = $path.'/'.$this->image;
            if (file_exists($thumb)) {
                unlink($thumb);
            }
            $originalFileName = explode('-thumb.', $this->image);
            if (isset($originalFileName[0]) && isset($originalFileName[1])) {
                $original = $path.'/'.$originalFileName[0].'.'.$originalFileName[1];
                if (file_exists($original)) {
                    unlink($original);
                }
            }
        }
    }

    /**
     * This method uploads and cropped images
     * @return void
     */
    private function upload()
    {
        if ($this->imageFile) {
            $this->delImage();
            if ($this->validate()) {
                $modelName = md5($this->imageFile->baseName.time());
                $path      = $this->getDirPath(true).'/';
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $this->imageFile->saveAs($path.$modelName.'.'.$this->imageFile->extension);
                $file        = $path.$modelName.'.'.$this->imageFile->extension;
                $this->image = $modelName.'-thumb.'.$this->imageFile->extension;

                if (mime_content_type($file) === 'image/jpeg') {
                    Image::thumbnail($path.$modelName.'.'.$this->imageFile->extension, 426, 283)
                        ->save(Yii::getAlias($path.$modelName.'-thumb.'.$this->imageFile->extension), ['quality' => 80]);
                }
                if (mime_content_type($file) === 'image/png') {
                    Image::thumbnail($path.$modelName.'.'.$this->imageFile->extension, 426, 283)
                        ->save(Yii::getAlias($path.$modelName.'-thumb.'.$this->imageFile->extension), ['png_compression_level' => 9]);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function beforeDelete()
    {
        \yii\helpers\FileHelper::removeDirectory($this->getDirPath(true));
        return parent::beforeDelete();
    }

    /**
     * @param $insert
     * @return mixed
     */
    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->upload();

        if (!$this->meta_description) {
            $this->meta_description = TextHelper::cut($this->name, 150);
        }

        if (empty($this->url)) {
            $this->url = TextHelper::slug($this->name, '-', true);
        } else {
            $this->url = TextHelper::slug($this->url, '-', true);
        }

        $news_group = NewsGroup::findOne(['id' => $this->news_group_id]);
        $this->news_group_url = $news_group['url'];

        return parent::beforeSave($insert);
    }
}