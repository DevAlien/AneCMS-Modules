{content name="breadcrumb"}
  <h1>{lang.modules}</h1>
  <span><a href="?=cfg" title="Layout Options">{lang.blog_articles}</a> &raquo; <a href="#" class="active">{lang.blog_newarticle}</a></span>
{/content}
{content name="main"}
<script type="text/javascript" src="./skins/admintasia/js/tablesorter.js"></script>
<script type="text/javascript" src="./skins/admintasia/js/tablesorter-pager.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  /* Table Sorter */
  $("#sort-table")
  .tablesorter({
    widgets: ['zebra'],
    headers: {
                // assign the secound column (we start counting zero)
                3: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },
                
            }
  })

  

  $(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');


});

</script>

<div class="inner-page-title">
    <h2>{lang.blog_newarticle}</h2>
</div>
<div class="hastable">
<div class="content-box">
    <form name="myform" class="pager-form" method="post" action="?p=mod&mod=blog&i={$geti}">
            <fieldset><p><label>{lang.blog_title}:</label><input type="text" class="text-long" name="title" value="{$title}"/></p></fieldset>
                            

                            <textarea id="notes" name="article">{$article}</textarea>
              <h3>{lang.blog_setcategories}</h3>
<fieldset><p><label>{lang.blog_categories}:</label><input type="text" class="text-long" name="categories" value="{$categories}"/></p>
              <p>{lang.blog_catseparator}</p>
              </fieldset>
                            <h3>{lang.twitter}</h3>
                            <fieldset><p><label>{lang.twitter_post}:</label><input type="checkbox" class="text-long" name="twitter"/></p></fieldset>
              <input type="submit" value="{lang.submit}" />
</form>
</div>
</div>
{/content}