<?php
/**
 * Created by PhpStorm.
 * User: Hesk
 * Date: 13年12月3日
 * Time: 下午4:21
 */
add_shortcode('facebook_signup_button', array('facebooksupport', 'facebooksignupbutton'));

class facebooksupport
{
    var $login_button = '<div class="login"><a href="https://www.facebook.com/dialog/oauth?scope=publish_stream%2Cread_stream%2Cemail%2Cuser_photos%2Cread_friendlists&amp;redirect_uri=http%3A%2F%2Fhesk.imusictech.net%2F2012_ibike%2Findex.php%2Flogin%2Ffacebook_login&amp;display=page&amp;client_id=112382108943139&amp;state=32e76aa11ef37fa7b8294121078d6046&amp;response_type=code"></a></div>';

    public static function facebooksignupbutton()
    {

        // Code
        return self::login_button;
    }
}