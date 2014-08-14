<?php
//require_once  'faceconn/Tools.php';

/**
 * Facebook Request Dialog is used to invite friends to start using an application, 
 * or to send request for some specific action to application users.
 */
class RequestDialog
{
    /**
     * Function sets the type of the command control.
	 * Allowed values are 'link', 'button', 'image' and 'auto'. Default value is 'button'.
     * @param <string> $commandType
     */
    public function SetCommandType($commandType) 
    {
        if ($commandType != "button" && $commandType != "link" && $commandType != 'auto' && $commandType != "image")
        {
            throw new Exception("StreamPublish Error:  Unsuported command type: " . $commandType);
        }
        $this->commandType = $commandType;
    }

    /**
     * Function sets the title of a request button/link. Default value is 'Send Request'.
     * @param <string> $commandText
     */
    public function SetCommandText($commandText) {$this->commandText = $commandText;}

    /**
     * Function sets the message of the request dialog.
     * @param <string> $name
     */
    public function SetMessage($message) {$this->message = $message;}

    /**
     * Function sets the title of the request dialog.
     * @param <string> $nameUrl
     */
    public function SetTitle($nameUrl) {$this->title = $title;}

    /**
     * Function sets the additional data of request dialog.
     * @param <string> $caption
     */
    public function SetAdditionalData($additionalData) {$this->additionalData = $additionalData;}

    /**
     * Function sets the friend ID. If it's set, the request will be sent just to this friend.
     * @param <string> $friendId
     */
    public function SetFriendId($friendId) {$this->friendId = $friendId;}

    /**
     * Function sets the CSS style of the button/link.
     * @param <string> $cssStyle
     */
    public function SetCssStyle($cssStyle) {$this->cssStyle = $cssStyle;}

    /**
     * Function sets the CSS class of the button/link.
     * @param <string> $cssClass
     */
    public function SetCssClass($cssClass) {$this->cssClass = $cssClass;}
    
    /**
     * Function sets the image of the button.
     * @param <string> $image
     */
    public function SetImage($image) {$this->commandType="image"; $this->image = $image;}
    
     /**
     * Function sets the filters of the request dialog.
     * @param <string> $filters
     */
    public function SetFilters($filters) {$this->filters = $filters;}
    
    /**
     * Function sets friend IDs to exclude from the request dialog
     * @param type $excludeIds 
     */
    public function  SetExcludeIds($excludeIds) {$this->excludeIds = $excludeIds;}
    
    /**
     * Function sets max recipients number
     * @param type $maxRecipients 
     */
    public function SetMaxRecipients($maxRecipients) {$this->maxRecipients = $maxRecipients;}
    
    /**
     * Function sets the redirect URI of the request dialog.
     * @param <string> $redirectUri
     */
    public function SetRedirectUri($redirectUri) {$this->redirectUri = $redirectUri;}
    
   /**
    * Function sets the JavaScript code to be executed after the user is send request.
    * @param type $onSendRequestJavaScript 
    */
    public function SetOnSendRequestJavaScript($onSendRequestJavaScript) { $this->onSendRequestJavaScript = $onSendRequestJavaScript; }
    
     /**
     * Function sets the form ID to be submitted after the user send request.
     * @param type $onSendRequestSubmitForm 
     */
    public function SetOnSendRequestSubmitForm ($onSendRequestSubmitForm) { $this->onSendRequestSubmitForm = $onSendRequestSubmitForm; }

    /**
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $functionName = "ShowRequestDialog" . GlobalCounter::GetCount();
        $html = "<script>\n";
        $html .= "var invitedFriends = null;"; 
        $html .= "function " . $functionName . "() {\n";
        $html .= "  if (graphApiInitialized != true) {\n";
        $html .= "    setTimeout('" . $functionName . "()', 100);\n";
        $html .= "    return;\n";
        $html .= "  }\n";
        $html .= "  FB.ui({method: 'apprequests', message: '";
        $html .= $this->message . "'";
        if ($this->title != null)
        {
            $html .= ", title: '" . $this->title . "'";
        }
        if ($this->friendId != null)
        {
            $html .= ", to: '" . $this->friendId . "'";
        }
        if ($this->additionalData != null)
        {
            $html .= ", data: '" . $this->additionalData . "'";
        }
        if ($this->redirectUri != null)
        {
            $html .= ", redirect_uri: '" . $this->redirectUri . "'";
        }
        if ($this->filters != null)
        {
            $html .= ", filters: [" . $this->filters . "]";
        }
        if ($this->excludeIds != null)
        {
            $html .= ", exclude_ids: [" . $this->excludeIds . "]";
        }
        if ($this->maxRecipients != null)
        {
            $html .= ", max_recipients: '" . $this->maxRecipients . "'";
        }
        
        
        $html .= "}, function(response) {\n";
        $html .= "  if (response && response.to) {\n";
        $html .= "    invitedFriends = response.to;\n";
        if ($this->onSendRequestSubmitForm != null) {;
            $html .= "    var form1 = document.getElementById('" . $this->onSendRequestSubmitForm . "');\n";
            $html .= "    var field = document.createElement('input');\n";
            $html .= "    field.setAttribute('type', 'hidden');\n";
            $html .= "    field.setAttribute('name', 'invitedFriends');\n";
            $html .= "    field.setAttribute('value', '' + invitedFriends);\n";
            $html .= "    form1.appendChild(field);\n";
            $html .= "    form1.submit();\n";
        }
        $html .= "  }\n";
        $html .= "  else invitedFriends = null;\n";
        $html .= "})}\n";
        $html .= "</script>\n";

        switch ($this->commandType)
        {
            case "link":
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "()\" >";
                $html .= $this->commandText;
                $html .= "</a>\n";
                break;
            case "button":
                $html .= "<input type='button' style='" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "()\"  value=\"";
                $html .= $this->commandText;
                $html .= "\" />\n";
                break;
            case "image":
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "()\" ><img src='";
                $html .= $this->image;
                $html .= "' alt='' /></a>\n";
                break;
            case "auto":
                $html .= "<script type=\"text/javascript\">";
                $html .= $functionName . "();\n";
                $html .= "</script>\n";
                break;
            default:
                throw new Exception('Request Dialog Control Error:  Unsupported Command Type: ' . $this->commandType);
        }
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
    private $commandType = "button";
    private $commandText = "Send Request";
    private $message = null;
    private $title = null;
    private $friendId = null;
    private $additionalData = null;
    private $cssStyle = null;
    private $cssClass = null;
    private $filters = null;
    private $excludeIds = null;
    private $maxRecipients = null;
    private $redirectUri = null;
    private $image = null;
    private $onSendRequestJavaScript = null;
    private $onSendRequestSubmitForm = null;
}

?>
