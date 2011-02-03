{content name="main"}
{loop name="news"}
<div class="post">
<div class="post_h">

</div>

<div class="postcontent">
<span class="date">{date.$news.insert_date} {lang.blog_by} <a href="{qg.url_base}blog/author/{$news.insert_user_id}/{$news.username}">{$news.username}</a></span>
<h2><a href="{qg.url_base}blog/{$news.id}/{Tools::parseTitle.[$news.title]}">{$news.title}</a></h2>
{$news.article}
</div>
<div class="post_b">
<span class="permalink"><a href="{qg.url_base}blog/{$news.id}/{Tools::parseTitle.[$news.title]}#more">{lang.blog_art_more}</a></span> <span class="category">{$news.categorieshtml}</span> <span class="comment"><a href="{qg.url_base}blog/{$news.id}/{Tools::parseTitle.[$news.title]}#comments" class="comments">{if condition="[$news.comments] == 1"}{$news.comments} {lang.blog_comment}{else}{$news.comments} {lang.blog_comments}{/if}</a></span>
</div>
</div>
{/loop}
{/content}
