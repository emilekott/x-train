<?php
    if ($post->post_parent)	{
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent = $ancestors[$root];
} else {
	$parent = $post->ID;
}

    $sb_content = wp_list_pages( array('echo'=>false,'child_of'=>$parent,'title_li'=>false,'link_before'=>'<span  class="font4">','link_after'=>'</span>') );
    if($sb_content):
?><div class="sidebar-small">
    <div id="subpagemnu-top"></div>
        <div id="subpagemnu-mid-generic" class="content-submnu-generic">
            <?php include('menuheadings.php') ?>
            <ul>
                <?php
                  echo $sb_content
                ?>
            </ul>

        </div>
    <div id="subpagemnu-bot"></div>
</div>
<?php endif ?>