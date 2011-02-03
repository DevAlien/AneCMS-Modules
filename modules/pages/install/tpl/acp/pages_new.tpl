{content name="main"}
                <h2><a href="#">{lang.pages_pages}</a> &raquo; <a href="#" class="active">Nuova</a></h2>

                <div id="main"><br>

                <form action="?p=mod&mod=pages&i={$geti}" class="jNice" method="POST">
                        	<fieldset><p><label>{lang.pages_pagename}:</label><input type="text" class="text-long" name="pagename" value="{$pages_title}"/></p></fieldset>
                  <iframe name="frame" src="upload.php" width="450px" height="100px"></iframe>
                            <textarea  style="width: 700px; height: 600px;" id="page" name="page">{$pages_page}</textarea>

{if condition="[$geti] == 0"}
<h3>{lang.pages_addlink}</h3>
<fieldset><p><label>Nome link:</label><input type="text" class="text-long" name="linkname" value=""/></p>
							<p><label>{lang.access}:</label>
							<select name="linksecurity">

                        <option value="1">{lang.cfg_vissibleall}</option>
                        <option value="2">{lang.cfg_vissibleonlymember}</option>
                        <option value="3">{lang.cfg_vissibleaadmin}</option>
							</select>
							</p>
							</fieldset>
							{/if}
							<input type="submit" value="{lang.submit}" />
							
                        </form>
<br />
</div>
{/content}