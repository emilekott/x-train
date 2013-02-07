<?php

    if ($post->post_parent)	{
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent = $ancestors[$root];
} else {
	$parent = $post->ID;
}


    $sb_content = wp_list_pages( array('echo' => false,'child_of'=>$parent,'title_li'=>false,'link_before'=>'<span  class="font1">','link_after'=>'</span>','walker' => new Custom_Walker_List_Pages) );
    if($sb_content):
?>
<div class="sidebar-small">
    <div id="subpagemnu-top"></div>
        <div id="subpagemnu-mid" class="content-submnu">
            <div id="courses-subpage-mnu-heading"><img src="<?php bloginfo('stylesheet_directory') ?>/images/heading_club.gif" alt="Club" /></div>
            <ul>
                <?php
                    echo $sb_content;
                ?>
            </ul>

        </div>
    <div id="subpagemnu-bot"></div>
</div>
<?php endif ?>