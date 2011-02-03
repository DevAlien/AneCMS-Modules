<?php if(isset($_GET['p'])){ ?>
    <h3 class="dash"><?php echo $lang['blog_not_approved_commentsfta'];?></h3>
<?php } else{ ?>
<h3 class="dash"><?php echo $lang['blog_not_approved_comments'];?></h3>
<?php } ?>
<?php if($var['count']>0){ ?>
<ul class="dash">
<?php $counter_CNA=0; foreach($var['CNA'] as $key => $CNA){ $counter_CNA++; ?>
<li class="dash">
    <?php echo $CNA['comment'];?><a href="#" class="right red"><?php echo $lang['delete'];?></a> <span class="right color">-</span> <a href="#" class="right green"><?php echo $lang['accept'];?></a>
</li>
<?php } ?>
</ul>
<?php } else{ ?>
<?php echo $lang['blog_all_comments_approved'];?>
<?php } ?>