/**
 * Created by Hesk on innocator facebook connection
 */
function logout_fb_redirec() {
    window.location.href = innobject.domain;
    // alert("log out");
    console.log("log out call back here");
}
var graphApiInitialized = false;
window.fbAsyncInit = function () {
    FB.init({
        appId: innobject.AppID,
        status: true, // check login status
        cookie: true, //enable cookies to allow the server to access the session
        xfbml: true, // parse XFBML
        oauth: true
    });
    //  alert("graphApiInitialized yes");
    graphApiInitialized = true;
    // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
    // for any authentication related change, such as login, logout or session refresh. This means that
    // whenever someone who was previously logged out tries to log in again, the correct case below
    // will be handled.
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            // the user is logged in and has authenticated your
            // app, and response.authResponse supplies
            // the user's ID, a valid access token, a signed
            // request, and the time the access token
            // and signed request each expire
            //  var uid = response.authResponse.userID;
            //  var accessToken = response.authResponse.accessToken;
            // alert("0");
            jQuery("#fb_logout_action").removeClass("hidden");

            fbAPI();
        } else if (response.status === 'not_authorized') {
            // the user is logged in to Facebook,
            // but has not authenticated your app
            jQuery("#fb_login_action").removeClass("hidden");
        } else {
            jQuery("#fb_login_action").removeClass("hidden");
            //  alert("2");
            // the user isn't logged in to Facebook.
        }
    });

    FB.Event.subscribe('auth.authResponseChange', function (response) {
        // Here we specify what we do with the response anytime this event occurs.
        if (response.status === 'connected') {
            // The response object is returned with a status field that lets the app know the current
            // login status of the person. In this case, we're handling the situation where they
            // have logged in to the app.
            //  fbAPI();
            jQuery("#fb_logout_action").removeClass("hidden");
        }
        else if (response.status === 'not_authorized') {
            // In this case, the person is logged into Facebook, but not into the app, so we call
            // FB.login() to prompt them to do so.
            // In real-life usage, you wouldn't want to immediately prompt someone to login
            // like this, for two reasons:
            // (1) JavaScript created popup windows are blocked by most browsers unless they
            // result from direct interaction from people using the app (such as a mouse click)
            // (2) it is a bad experience to be continually prompted to login upon page load.
            //  FB.login();

            // alert("not log in");
            jQuery("#fb_login_action").removeClass("hidden");
        } else {
            // alert("not log in");
            // In this case, the person is not logged into Facebook, so we call the login()
            // function to prompt them to do so. Note that at this stage there is no indication
            // of whether they are logged into the app. If they aren't then they'll see the Login
            // dialog right after they log in to Facebook.
            // The same caveats as above apply to the FB.login() call here.
            //  FB.login();
            jQuery("#fb_login_action").removeClass("hidden");
        }
    });
    /*    jQuery('#sign_in').click(function (e) {
     e.preventDefault();
     FB.login(function (response) {
     if (response.authResponse) {
     //return window.location = '/auth/facebook/callback';
     }
     });
     });
     jQuery('#sign_out').click(function (e) {
     FB.logout(function (response) {
     console.log("Here logout response", response);
     });
     });*/
};
(function (d, s, idfb) {
    var e = d.createElement(s);
    e.id = idfb;
    e.async = true;
    e.src = '//connect.facebook.net/' + innobject.languageCode + '/all.js#xfbml=1appId=' + innobject.AppID;
    d.getElementById('fb-root').appendChild(e);
    // console.log(d);
}(document, 'script', 'facebook-jssdk'));
// Here we run a very simple test of the Graph API after login is successful.
// This testAPI() function is only called in those cases.
function fbAPI() {
    var $ = jQuery;
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', {fields: "picture,id,name"}, function (response) {
        //  console.log(response);
        //  console.log('Good to see you, ' + response.name + '.');
        $("#account-nav img,.avatar.avatar-64.photo").attr("src", response.picture.data.url);
        $("#fb_user_name").html(response.name);
    });
    $.get("http://ipinfo.io", function (response) {
        //  $("#ip").html("IP: " + response.ip);
        $("#user_location").html(response.country);
        // $("#details").html(JSON.stringify(response, null, 4));
        console.log(response);
    }, "jsonp");
}
