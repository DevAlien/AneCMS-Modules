{content name="main"}
<!-- h2 stays for breadcrumbs -->
<h2><a href="#">{lang.pages_pages}</a></h2>
                <div id="main">
<br />
<form action="?p=mod&mod=pages&t=set" class="jNice" method="POST">

    <h3>{lang.pages_selectdefault}</h3>
                <fieldset><p><label>{lang.pages_pagename}:</label>
                <select name="page">
                {loop name="pages"}
                <option value="{$pages.id}" {if condition="([$pages.id] == [$selected])"}SELECTED{/if}>{$pages.name}</option>
                {/loop}
</select>
</p>

                <input type="submit" value="{lang.submit}" />
</fieldset>
                        </form>
{if condition="isset($_GET['t']) && ($_GET['t'] == 'set')"}
    <div class="notice{$color}">{$resultmessage}</div>

{/if}
<br />
                    	<table cellpadding="0" cellspacing="0">
			    <tr>
                                <td>{lang.name}</td>
				<td>{lang.who}</td>
				<td>{lang.when}</td>
                <td>{lang.options}</td>
                            </tr>
			    {loop name="pages"}
			    <tr class="odd">
                                <td>{$pages.name}</td>
				<td>{$pages.who}</td>
				<td>{date.$pages.time}</td>
                <td><a href="?p=mod&mod=pages&m=modify&pi={$pages.id}">{lang.modify}</a> <a href="?p=mod&mod=pages&m=delete&id={$pages.id}">{lang.delete}</a></td>
                            </tr>
			{/loop}
                        </table>
<br />
</div>
{/content}