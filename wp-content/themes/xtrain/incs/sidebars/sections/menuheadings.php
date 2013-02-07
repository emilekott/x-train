<?php
if ($post->post_parent)	{
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$pid_check = $ancestors[$root];
} else {
	$pid_check = $post->ID;
}

switch($pid_check):
    case 2: //about pages
        $headingfile = 'heading_about.gif';
    break;
    case 15: //gallery
        $headingfile = 'heading_gallery.gif';
    break;

    case 11: //membership
        //echo ''; //not applicable - integrated with menu
    break;
endswitch;

switch($post->ID):
    case 23: //windsurf
        $headingfile = 'windsurf-menu.gif';
    break;
    case 25: //kitesurf
        $headingfile = 'kitesurf-menu.gif';
    break;
    case 27: //surf / sup
        $headingfile = 'surfsup-menu.gif';
    break;
    case 91: //kids/rippers
        $headingfile = 'kidsrippers-menu.gif';
    break;
    case 29: //powerkite
        $headingfile = 'powerkite-menu.gif';
    break;
	case 1725: //2 hour
        $headingfile = 'tasters.png';
    break;
endswitch;
if($headingfile):?>
<div id="courses-subpage-mnu-heading"><img src="<?=get_bloginfo('stylesheet_directory').'/images/'.$headingfile?>" /></div>
<?php endif; ?>
