var $crfp = jQuery.noConflict();
$crfp(document).ready(function() {
    $crfp('form#commentform p').each(function(i,item) {
        if ($crfp('input[name=revtitle]', $crfp(item)).length > 0) {
            $crfp(item).after('<p><input name="rating-star" type="radio" class="star" value="1" /><input name="rating-star" type="radio" class="star" value="2" /><input name="rating-star" type="radio" class="star" value="3" /><input name="rating-star" type="radio" class="star" value="4" /><input name="rating-star" type="radio" class="star" value="5" /><input type="hidden" name="crfp-rating" value="0" /></p>'); // Add rating field to end of comment form    
        }
    });
    
    $crfp('input.star').rating(); // Invoke rating plugin
    $crfp('div.star-rating a').bind('click', function(e) { $crfp('input[name=crfp-rating]').val($crfp(this).html()); }); // Stores rating in hidden field ready for POST
    $crfp('div.rating-cancel a').bind('click', function(e) { $crfp('input[name=crfp-rating]').val('0'); }); // Stores rating in hidden field ready for POST
});