<?php
//require_once  'faceconn/Tools.php';

/**
 * Facebook InviteAllFriends is used to invite friends to start using an application 
 * without requiring for manual selection in step 50 by 50
 */
class InviteAllFriends {
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
     * Set title of invite next friends dialog
     * @param type $nextDialogTitle 
     */
    public function SetNextDialogTitle($nextDialogTitle) { $this->nextDialogTitle = $nextDialogTitle; }
    
    /**
     * Set numbers of invite next friends dialog. Default: Invites were sent to first <b>{0}</b> out of <b>{1}</b> of your friends.
     * @param type $nextDialogNumbers 
     */
    public function SetNextDialogNumbers($nextDialogNumbers) { $this->nextDialogNumbers = $nextDialogNumbers; }
    
    /**
     * Set continue label of next friends dialog. Default: Continue with sending to next 50 friends ..
     * @param type $nextDialogContinueLabel 
     */
    public function SetNextDialogContinueLabel($nextDialogContinueLabel) { $this->nextDialogContinueLabel = $nextDialogContinueLabel; }
    
    /**
     * Set text of continue button inside next friends dialog. Default: Continue
     * @param type $nextDialogContinueButton 
     */
    public function SetNextDialogContinueButton($nextDialogContinueButton) {$this->nextDialogContinueButton = $nextDialogContinueButton; }
    
    /**
     * Set text of cancel button inside next friends dialog. Default: Cancel
     * @param type $nextDialogCancelButton 
     */
    public function SetNextDialogCancelButton($nextDialogCancelButton) {$this->nextDialogCancelButton = $nextDialogCancelButton; }

    /**
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $script = "<script type='text/javascript'>\n";
        $script .= "var invitedFriends = null;\n"; 
        $script .= "var FaceconnMaxInvites = 50;\n";
        $script .= "var FaceconnInvitedFriends = 0;\n";
        $script .= "var FaceconnFriendList = null;\n";
        $script .= "var FaceconnInviteMessage = null;\n";
        $script .= "var FaceconnInviteTitle = null;\n";
        $script .= "var FaceconnInviteData = null;\n\n";


        $script .= "function FaceconnLoadNextFriends()\n";
        $script .= "{\n";
        $script .= "  if (FaceconnFriendList == null) {\n";
        $script .= "      setTimeout('FaceconnLoadNextFriends()', 100);\n";
        $script .= "      return;\n";
        $script .= "  }\n";
        $script .= "  document.getElementById('FaceconnInviteNextDialog').style.visibility = 'hidden';\n";
        $script .= "  var stringList = '';\n";
        $script .= "  for (var i = FaceconnInvitedFriends; i < FaceconnInvitedFriends + FaceconnMaxInvites && i < FaceconnFriendList.length; i++) {\n";
        $script .= "     stringList += ',';\n";
        $script .= "     stringList += FaceconnFriendList[i].id;\n";
        $script .= "  }\n";
        $script .= "  stringList = stringList.substring(1, stringList.lenght);\n";
        $script .= "  FaceconnShowInviteRequest(stringList);\n";
        $script .= "}\n\n";

        $script .= "function FaceconnLoadFriends() {;\n";
        $script .= "    if (graphApiInitialized != true) {\n";
        $script .= "      setTimeout('FaceconnLoadFriends()', 100);\n";
        $script .= "      return;\n";
        $script .= "    }\n\n";

        $script .= "    setTimeout(function() {\n";
        $script .= "      var friends = FB.api('/me/friends?fields=id', function(response) {\n";
        $script .= "        if (!response || response.error) {\n";
        $script .= "            FB.getLoginStatus(function(response) { if (response.status === 'connected') FaceconnLoadFriends(); return; });\n";
        $script .= "        } else {\n";
        $script .= "          FaceconnFriendList = response.data;\n";
        $script .= "        }\n";
        $script .= "      });\n";
        $script .= "    }, 100);\n";
        $script .= "};\n\n";

        $script .= "function FaceconnShowInviteRequest(friends)\n";
        $script .= "{\n";
        $script .= "  //Pass in the gift id (gift), as well as the gift name (giftname).  \n";
        $script .= "  FB.ui({ \n";
        $script .= "    method: 'apprequests', \n";
        $script .= "    message: FaceconnInviteMessage,\n";
        $script .= "    data: FaceconnInviteData, \n";
        $script .= "    title: FaceconnInviteTitle,\n";
        $script .= "    to: friends\n";
        $script .= "  },\n";
        $script .= "  function(response) {\n";
        $script .= "    if (response && response.to) {\n";
        $script .= "      FaceconnInvitedFriends += FaceconnMaxInvites;\n";
        $script .= "      var FriendsCount = FaceconnFriendList.length;\n";
        $script .= "      if (FriendsCount > FaceconnInvitedFriends)\n";
        $script .= "      {\n";
        $script .= "        document.getElementById('FaceconnSentSumLabel').innerHTML = FaceconnInvitedFriends;\n";
        $script .= "        document.getElementById('FaceconnFriendsToSendLabel').innerHTML = FriendsCount;\n";
        $script .= "        document.getElementById('FaceconnFriendsProgressBar').style.width = FaceconnInvitedFriends*100 / FriendsCount + '%';\n";
        $script .= "        document.getElementById('FaceconnInviteNextDialog').style.visibility = 'visible';\n";
        $script .= "      }\n";
        $script .= "      else\n";
        $script .= "      {\n";
        $script .= "        FaceconnCreateInvitedFriendsList();\n";
        $script .= "      }\n";
        $script .= "    } else {\n";
        $script .= "        document.getElementById('FaceconnInviteNextDialog').style.visibility = 'hidden';\n";
        $script .= "        FaceconnCreateInvitedFriendsList();\n";
        $script .= "    }\n";
        $script .= "  });\n";
        $script .= "}\n\n";

        $script .= "function FaceconnExecuteInvite(msg, data, title)\n";
        $script .= "{\n";
        $script .= "    FaceconnInviteMessage = msg;\n";
        $script .= "    FaceconnInviteTitle = title;\n";
        $script .= "    FaceconnInviteData = data;\n";
        $script .= "    FaceconnInvitedFriends = 0;\n";
        $script .= "    FaceconnLoadNextFriends();\n";
        $script .= "}\n\n";
        $script .= "FaceconnLoadFriends();\n\n";
        
        $script .= "function FaceconnCreateInvitedFriendsList()\n";
        $script .= "  {\n";
        $script .= "    var stringList = '';\n";
        $script .= "    for (var i = 0; i < FaceconnInvitedFriends && i < FaceconnFriendList.length; i++) {\n";
        $script .= "      stringList += ',';\n";
        $script .= "      stringList += FaceconnFriendList[i].id;\n";
        $script .= "    }\n";
        $script .= "    stringList = stringList.substring(1, stringList.lenght);\n";
        $script .= "    invitedFriends = stringList;\n";
        if ($this->onSendRequestSubmitForm != null) {;
            $script .= "    var form1 = document.getElementById('" . $this->onSendRequestSubmitForm . "');\n";
            $script .= "    var field = document.createElement('input');\n";
            $script .= "    field.setAttribute('type', 'hidden');\n";
            $script .= "    field.setAttribute('name', 'invitedFriends');\n";
            $script .= "    field.setAttribute('value', '' + invitedFriends);\n";
            $script .= "    form1.appendChild(field);\n";
            $script .= "    form1.submit();\n";
        }
        $script .= "    }\n";
        $script .= "</script>\n";
        
        $html = $script;
        
        $html .= "<div id='FaceconnInviteNextDialog' class='Faceconn_dialog_shadow' style='visibility:hidden'>\n";
        $html .= "    <div style='width:100%; height:100%; background-color:White'>\n";
        $html .= "        <div style='width:100%; height:30px; background-color:#6D84B4; color:white; font-size:14px'>\n";
        $html .= "            <div style='padding:5px; padding-left:10px'>" . $this->nextDialogTitle . "</div>\n";
        $html .= "        </div>\n";
        $html .= "        <div style='width:100%; height:135px; background-color:White; color:black; font-size:14px;'>\n";
        $html .= "            <div style='padding:9px; padding-right:12px'>\n";
        $html .= "                <br />\n";
        $numbers = $this->nextDialogNumbers;
        $numbers = str_replace("{0}", "<span id=\"FaceconnSentSumLabel\"></span>", $numbers);
        $numbers = str_replace("{1}", "<span id=\"FaceconnFriendsToSendLabel\"></span>", $numbers);
        $html .= "                " . $numbers . "<br /><br />\n";
        $html .= "                <div class='Faceconn_invite_progress_empty'>\n";
        $html .= "                    <div id='FaceconnFriendsProgressBar' class='Faceconn_invite_progress'></div>\n";
        $html .= "                </div>\n";
        $html .= "                <br />\n";
        $html .= "                <div style='font-size:10px; text-align:right'>" . $this->nextDialogContinueLabel . "</div>\n";
        $html .= "            </div>\n";
        $html .= "        </div>\n";
        $html .= "        <div style='width:100%; height:55px; background-color:#f2f2f2; color:white; font-size:14px; text-align:right;'>\n";
        $html .= "            <div style='padding-right:10px; padding-top:15px'>\n";
        $html .= "            <input id='nextDialogContinueButtonControl' runat='server' type='button' class='Faceconn_continue_invite_button' onclick='FaceconnLoadNextFriends()' value='" . $this->nextDialogContinueButton . "' />\n";
        $html .= "            <input id='nextDialogCancelButtonControl' runat='server' type='button' class='Faceconn_continue_invite_button' onclick='FaceconnCreateInvitedFriendsList(); document.getElementById(\"FaceconnInviteNextDialog\").style.visibility = \"hidden\";' value='" . $this->nextDialogCancelButton . "' />\n";
        $html .= "            </div>\n";
        $html .= "        </div>\n";
        $html .= "    </div>\n";
        $html .= "</div>\n";

        $functionName = "FaceconnExecuteInvite('" . $this->message . "', '" . $this->additionalData . "', '" . $this->title . "')";
        switch ($this->commandType)
        {
            case "link":
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "\" >";
                $html .= $this->commandText;
                $html .= "</a>\n";
                break;
            case "button":
                $html .= "<input type='button' style='" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "\"  value=\"";
                $html .= $this->commandText;
                $html .= "\" />\n";
                break;
            case "image":
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' class='" . $this->cssClass . "' onclick=\"" . $functionName . "\" ><img src='";
                $html .= $this->image;
                $html .= "' alt='' /></a>\n";
                break;
            case "auto":
                $html .= "<script type=\"text/javascript\">";
                $html .= $functionName . ";\n";
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
    private $redirectUri = null;
    private $image = null;
    private $onSendRequestJavaScript = null;
    private $onSendRequestSubmitForm = null;
    
     private $nextDialogTitle = "Invite more friends ...";
     private $nextDialogNumbers = "Invites were sent to first <b>{0}</b> out of <b>{1}</b> of your friends.";
     private $nextDialogContinueLabel = "Continue with sending to next 50 friends ...";
     private $nextDialogContinueButton = "Continue";
     private $nextDialogCancelButton = "Cancel";
}


?>
