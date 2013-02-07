<div class="sidebar-small">
    <div id="subpagemnu-top"></div>
        <div id="subpagemnu-mid">
            <div id="courses-subpage-mnu-heading" class="font2">Courses:</div>
            <ul class="font1">
                <?php
                    wp_list_pages( array('child_of'=>get_the_ID(),'title_li'=>false,'link_before'=>'<span>','link_after'=>'</span>') )
                ?>
            </ul>
        </div>
    <div id="subpagemnu-bot"></div>
</div>