{content name="breadcrumb"}
  <h1>{lang.modules}</h1>
  <span><a href="?=cfg" title="Layout Options">{lang.blog_articles}</a></span>
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
    <h2>{lang.blog_articles}</h2>
</div>
<div class="hastable">
<div class="content-box">
    <form name="myform" class="pager-form" method="post" action="">
            <table id="sort-table">
            <thead>
            <tr>
              <th>{lang.title}</th>
        <th>{lang.who}</th>
        <th>{lang.when}</th>
                <th>{lang.options}</th>
            </thead>
            <tbody>
          {loop name="articles"}
          {if condition="[counter.articles] %2 == 0"}
          <tr class="alt">
          {else}
          <tr>
          {/if}
                    <td>{$articles.title}</td>
        <td>{$articles.username}</td>
        <td>{date.$articles.insert_date}</td>
                                <td valign="top">
                                  <a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.modify}" href="?p=mod&mod=blog&m=modify&ai={$articles.id}">
                    <span class="ui-icon ui-icon-pencil"></span>
                  </a>
                  
                  <a class="btn_no_text btn ui-state-default ui-corner-all first" title="{lang.delete}" href="?p=mod&mod=blog&m=delete&ai={$articles.id}">
                    <span class="ui-icon ui-icon-trash"></span>
                  </a>
                  </td>
                            </tr>
                    {/loop}

            </tbody>
            </table>
            <div class="clear"></div>
            <div class="clear"></div>
            <div id="pager">
          
                <a class="btn_no_text btn ui-state-default ui-corner-all first" title="First Page" href="#">
                  <span class="ui-icon ui-icon-arrowthickstop-1-w"></span>
                </a>
                <a class="btn_no_text btn ui-state-default ui-corner-all prev" title="Previous Page" href="#">
                  <span class="ui-icon ui-icon-circle-arrow-w"></span>
                </a>
              
                <input type="text" class="pagedisplay"/>
                <a class="btn_no_text btn ui-state-default ui-corner-all next" title="Next Page" href="#">
                  <span class="ui-icon ui-icon-circle-arrow-e"></span>
                </a>
                <a class="btn_no_text btn ui-state-default ui-corner-all last" title="Last Page" href="#">
                  <span class="ui-icon ui-icon-arrowthickstop-1-e"></span>
                </a>
                <select class="pagesize">
                  <option value="10" selected="selected">10 {lang.results}</option>
                  <option value="20">20 {lang.results}</option>
                  <option value="30">30 {lang.results}</option>
                  <option value="40">40 {lang.results}</option>
                </select>               
            </div>
            <br /><br />
</form>
</div>
</div>
{/content}