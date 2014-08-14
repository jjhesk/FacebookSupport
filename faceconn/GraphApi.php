<?php
//require_once FACECONN_DIR . 'AppConfig.php';

/**
 * Call this function after <body> tag on each page to enable GraphAPI JavaScript SDK.
 * You can find all language codes at:
 * http://www.facebook.com/translations/FacebookLocales.xml
 */
function UseGraphAPI($languageCode = "en_US")
{

    return;
    $languageCode = "en_US";
    //  echo "<div id='fb-root'></div>\n";
    echo "<script>\n";
    echo "var graphApiInitialized = false;\n";
    echo "  window.fbAsyncInit = function() {\n";
    echo "    FB.init({\n";
    echo "      appId  : '" . AppConfig::GetAppId() . "',\n";
    echo "      status : true, // check login status\n";
    echo "      cookie : true, // enable cookies to allow the server to access the session\n";
    echo "      xfbml  : true,  // parse XFBML\n";
    echo "      oauth: true";
    echo "    });\n";
    echo "    graphApiInitialized = true;\n";
    echo "  };\n";
    echo "  (function(d, s, idfb) {\n";
    echo "    var e = d.createElement(s);\n";
    echo "    e.id = idfb;";
    echo "    e.src = '//connect.facebook.net/" . $languageCode . "/all.js#xfbml=1appId=" . AppConfig::GetAppId() . "';\n";
    echo "    e.async = true;\n";
    echo "    d.getElementById('fb-root').appendChild(e);\n";
    echo "  }(document, 'script', 'facebook-jssdk'));\n";
    echo "</script>\n";
}
