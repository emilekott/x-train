<div class="sidebar-small sidebar-small-box1" id="sidebar-newsletter">
            <div class="sidebar-widget-inner">
                <form action="<?php ECHO $_SERVER['REQUEST_URI'] ?>" method="post">
                    <input type="text" name="sub_n" value="Name" onFocus="if(this.value == 'Name'){this.value='';}" onBlur="if(this.value == ''){this.value='Name';}" />
                    <input type="text" name="sub_e" value="Email Address" onFocus="if(this.value == 'Email Address'){this.value='';}" onBlur="if(this.value == ''){this.value='Email Address';}" />
                    <input type="hidden" name="formgo" value="1" />
                    <input type="hidden" name="formsource" value="newslettersubscribe" />
                    <input type="hidden" name="origlocation" value="<?=$_SERVER['REQUEST_URI']?>" />
                    <input type="image" src="<?php bloginfo('stylesheet_directory') ?>/images/signup-btn.png" name="signup" />
                </form>
            </div>
        </div>