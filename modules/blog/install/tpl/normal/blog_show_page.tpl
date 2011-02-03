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

{if condition="[$news.comments] < 1"}
    <h3>{lang.blog_no_comments}</h3>
  {else}
    <h3 id="comments">{lang.blog_total_comments}{$news.comments}</h3>
    
{loop name="comments"}
<div id="comments" name="comment-{$comments.id}">
<div id="commentop">
  
</div>
<div id="commentcontent">
  <img alt='' src='http://gravatar.com/avatar/<?php echo md5($comments['email']);?>.png' height='40' width='40' /><br />
  <span class="date"><a href="{$comments.web}">{$comments.user}</a> | <a href="{qg.url_base}blog/{$news.id}/{Tools::parseTitle.[$news.title]}#comment-{$comments.id}" title="Direct link to this comment">{date.$comments.dateinsert}</a> </span>
  <br /><br />
  {Tools::bbcode.$comments['comment']}
  {IFADMIN}
 <br /><br />
   <span class="edit"><a href="{qg.url_base}blog/delete/{$comments.id}/{$news.id}">{lang.delete}</a></span>            {/IFADMIN}
</div>

<div id="commentbtm">
</div>

</div>
{/loop}
{/if}
<h3>{lang.blog_leave_reply}</h3>
<div id="comments">
<div id="commentop">
</div>
<div id="commentcontent">
  <form action="{qg.url_base}blog/{$news.id}/{Tools::parseTitle.[$news.title]}/c" method="post" id="commentform" onsubmit="if (url.value == 'Website (optional)') {url.value = '';}">
    {IFLOGGED}
            <div class="gravatar">
              <img src="http://gravatar.com/avatar/<?php echo md5($user->getValues('email'));?>.png" alt="" class="avatar"/>
            </div>
        {/if}
            
        {IFLOGGED}
            <label>{lang.blog_personalused}</label>
      {else}
    <p>
        <label for="author">{lang.blog_yname}</label>

      <input class="text" name="username" id="author" value="" size="22" tabindex="1" type="text" />
    </p>
    <p>
        <label for="email">{lang.blog_yemail}</label>

      <input class="text"  name="email" id="email" value="" size="22" tabindex="2" type="text" />
    </p>
    <p>
        <label for="url">{lang.blog_yweb}</label>

      <input class="text"  name="web" id="url" value="" size="22" tabindex="3" type="text" />
    </p>
   {/if}
    <p>
      <label for="web">{lang.blog_ycomment}</label>
      <textarea  name="comment" id="comment" cols="40" rows="10" tabindex="4"></textarea>
    </p>
    <p>
      <input name="submit" alt="submit" src="{qg.url_base}skins/default/images/submit.jpg" id="submit" tabindex="5" value="{lang.blog_submit_comment}" type="image" />
    </p>
  </form>
</div>

<div id="commentbtm">
</div>
</div>
{/content}
