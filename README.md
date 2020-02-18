# yii2-news-module
<p>
<h2>Add in your config/main</h2><br>
&nbsp;&nbsp;'modules' => [<br>
&nbsp;&nbsp;&nbsp;&nbsp;...<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'news' => [<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class' => 'gtd\modules\news\Module',<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],<br>
&nbsp;&nbsp;&nbsp;&nbsp;...<br>
&nbsp;&nbsp;],<br>

<h2>Add in composer</h2>

&nbsp;&nbsp;"repositories": [<br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"type": "vcs",<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"url": "https://github.com/tkgtd/yii2-news-module"<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
&nbsp;&nbsp;]
<br>
<h2>Install</h2>
<b>composer require "tkgtd/yii2-news-module":"*"</b>
<h2>How to use?</h2>
Links for admin<br>
http://back.DOMAIN.com/news/news-group/index - List of category<br>
http://back.DOMAIN.com/news/news-group/view?id=1 - Add/Edit category<br>
http://back.DOMAIN.com/news/default/index - List of news<br>
http://back.DOMAIN.com/news/default/view?id=1 - Add/Edit news
<br>
<br>
Links for frontend:<br>
http://DOMAIN.com/news - List of news<br>
http://DOMAIN.com/news/<CAT_URL> - News category<br>
http://DOMAIN.com/news/<NEWS_URL> - Single news<br>
