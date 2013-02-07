<?php $testimonial = get_random_testimonial() ?>
<div class="sidebar-small" id="sidebar-testimonials">
    <div id="sidebar-testimonials-top"></div>
    <div id="sidebar-testimonials-mid" class="font3">
        <strong>Customers Recently Said:</strong>
        <div id="sidebar-testimonial-quote">"<?=$testimonial->post_content?>"</div>
        <div id="sidebar-testimonial-name"><?=$testimonial->post_title?></div>
    </div>
    <div id="sidebar-testimonials-bot"></div>
</div>