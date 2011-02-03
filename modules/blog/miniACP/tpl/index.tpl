{if condition="isset($_GET['p'])"}
    <h3 class="dash">{lang.blog_not_approved_commentsfta}</h3>
{else}
<h3 class="dash">{lang.blog_not_approved_comments}</h3>
{/if}
{if condition="[$count]>0"}
<ul class="dash">
{loop name="CNA"}
<li class="dash">
    {$CNA.comment}<a href="#" class="right red">{lang.delete}</a> <span class="right color">-</span> <a href="#" class="right green">{lang.accept}</a>
</li>
{/loop}
</ul>
{else}
{lang.blog_all_comments_approved}
{/if}