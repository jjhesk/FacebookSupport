<?php
//require_once  'faceconn/Tools.php';

/**
 * Facebook Connect Login Button control is used to connect a website and Facebook and allow
 * the usage of Facebook API. It also enables that once a user is logged in, all controls from
 * the library will work without additional logging in.
 */
class LoginButton
{
    /**
     * Function sets the text inside login button.
     * @param <string> $text
     */
    public function SetText($text) { $this->text = $text;}

    /**
     * Function sets the size of login button. 
	 * Allowed values are: icon, small, medium, large and xlarge.
     * @param <string> $size
     */
    public function SetSize($size) 
    {
        switch ($size)
        {
            case "icon":
            case "small":
            case "medium":
            case "large":
            case "xlarge":
                $this->size = $size;
                break;
            default:
                throw new Exception("LoginButton error: unsupported size: " . $size);
        } 
    }

    /**
     * Function sets required permissions (in comma separated list form).
     * @param <string> $permissions
     */
    public function SetPermissions($permissions) {$this->permissions = $permissions;}

    /**
     * Function sets the JavaScript code to be executed after the user is logged in.
     * @param <string> $onLoginJavaScript
     */
    public function SetOnLoginJavaScript($onLoginJavaScript) {$this->onLoginJavaScript = $onLoginJavaScript;}

    /**
     * Function sets the form ID to be submitted after the user is logged in.
     * @param <string> $onLoginSubmitForm
     */
    public function SetOnLoginSubmitForm($onLoginSubmitForm) {$this->onLoginSubmitForm = $onLoginSubmitForm;}

    /**
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $OnLoginFunc = "OnLogin" . GlobalCounter::GetCount();
        $html = "<script>\n";
        $html .= "function " . $OnLoginFunc . "() {\n";
        $html .= "  FB.getLoginStatus(function(response) {\n";
        $html .= "    if (response.status == 'connected') {\n";
        if ($this->onLoginJavaScript)
        {
            $html .= "      " . $this->onLoginJavaScript . ";\n";
        }
        if ($this->onLoginSubmitForm)
        {
            $html .= "      " . "document.getElementById('" . $this->onLoginSubmitForm . "').submit();\n";
        }
        $html .= "    }\n";
        $html .= "  })\n";
        $html .= "}\n";
        $html .= "</script>\n";
        $html .= " <fb:login-button ";
        if ($this->onLoginJavaScript != null || $this->onLoginSubmitForm)
        {
            $html .= "onlogin='" . $OnLoginFunc . "()' ";
        }
        if ($this->size != null)
        {
            $html .= "size='" . $this->size . "' ";
        }
        if ($this->permissions != null)
        {
            $html .= "scope='" . $this->permissions . "' ";
        }
        $html .= ">";
        if ($this->text != null)
        {
            $html .= $this->text;
        }
        $html .= "</fb:login-button>";
        return $html;
    }

    /**
     * Function renders component on the web page, depending on defined settings.
     */
    public function Render()
    {
        echo $this->GetOutputHtml();
    }


    // Private members
    private $text = null;
    private $size = null;
    private $permissions = null;
    private $onLoginJavaScript = null;
    private $onLoginSubmitForm = null;
}
?>
