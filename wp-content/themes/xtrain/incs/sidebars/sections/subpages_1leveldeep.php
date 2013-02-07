<?php

    $sb_content = wp_list_pages( array('echo'=>false,'child_of'=>get_the_ID(),'title_li'=>false,'link_before'=>'<span  class="font4">','link_after'=>'</span>') );
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