<?php

use yii\db\Migration;

/**
 * Class m200129_075829_news_module
 */
class m200129_075829_news_module extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        //news_txt
        $this->createTable('{{%news_text}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->tinyInteger(1)->unsigned()->defaultValue(0),
            'url' => $this->char(255),
            'news_group_id' => $this->integer(11)->defaultValue(1),
            'news_group_url' => $this->char(255)->defaultValue('uncategorize'),
            'name' => $this->char(255)->defaultValue(NULL),
            'text_announcement' => $this->text(),
            'text' => $this->text()->defaultValue(NULL),
            'image' => $this->char(255)->defaultValue(NULL),
            'meta_title' => $this->char(255),
            'meta_description' => $this->char(255),
            'meta_keywords' => $this->char(255),
            'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'timestamp_update' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'timestamp_start' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('url', '{{%news_text}}', 'url', false);
        $this->createIndex('news_group_url', '{{%news_text}}', 'news_group_url', false);
        $this->createIndex('timestamp_start', '{{%news_text}}', 'timestamp_start', false);
        $this->createIndex('is_active', '{{%news_text}}', 'is_active', false);

        //news group
        $this->createTable('{{%news_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(255)->defaultValue(NULL),
            'alias' => $this->char(255)->defaultValue(NULL),
            'url'  => $this->char(255),
            'is_active' => $this->tinyInteger(1)->unsigned()->defaultValue(0),
            'meta_title' => $this->char(255),
            'meta_description' => $this->char(255),
            'meta_keywords' => $this->char(255),
            'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'timestamp_update' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('is_active', '{{%news_group}}', 'is_active', false);

        $this->insert('{{%news_group}}', ['name' => 'Без категории', 'url' => 'uncategorize', 'is_active' => 1]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_text}}');
        $this->dropTable('{{%news_group}}');
    }
}
