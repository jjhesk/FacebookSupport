<?php
/**
 * Logout class is used to for the same purpuse as LogoutButton. Only difference
 * is that its apearence is not predefined, but it can be define with CSS.
 */
class LogoutButton
{
    /**
     * Function sets the type of command control.
	 * Allowed values are 'link', 'button', 'image' and 'auto'. Default value is 'button'.
     * @param <string> $commandType
     */
    public function SetCommandType($commandType) 
	{
        if ($commandType != "button" && $commandType != "link" && $commandType != 'auto' && $commandType != "image")
        {
            throw new Exception("Permissions Error:  Unsuported command type: " . $commandType);
        }
        $this->commandType = $commandType;
    }

    /**
     * Function sets the title of command button/link. Default value is 'Logout'.
     * @param <string> $commandText
     */
    public function SetCommandText($commandText) {$this->commandText = $commandText;}

    /**
     * Function sets the JavaScript code to be executed after the user is logged in.
     * @param <string> $onLogoutJavaScript
     */
    public function SetOnLogoutJavaScript($onLogoutJavaScript) {$this->onLogoutJavaScript = $onLogoutJavaScript;}

    /**
     * Function sets the form ID to be submitted after the user is logged in.
     * @param <string> $onLogoutSubmitForm
     */
    public function SetOnLogoutSubmitForm($onLogoutSubmitForm) {$this->onLogoutSubmitForm = $onLogoutSubmitForm;}

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
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $OnOpenPopupFunc = "OnPopupFunc" . GlobalCounter::GetCount();
        $OnLogoutCallbackFunc = "OnLogoutCallbackFunc" . GlobalCounter::GetCount();
        $html = "<script>\n";
        $html .= "function " . $OnLogoutCallbackFunc . "() {\n";
        if ($this->onLogoutJavaScript != null)
        {
            $html .= $this->onLogoutJavaScript . ";\n";
        }
        if ($this->onLogoutSubmitForm != null)
        {
            $html .= "document.getElementById('" . $this->onLogoutSubmitForm . "').submit()";
        }
        $html .= "}\n";
        $html .= "function " . $OnOpenPopupFunc . "() {\n";
        $html .= "if (graphApiInitialized == false) {\n";
        $html .= "  setTimeout('" . $OnOpenPopupFunc . "()', 100);\n";
        $html .= "  return;\n";
        $html .= "}\n";
        $html .= "setTimeout(function() {\n";
        $html .= "  FB.logout(function(response) {" . $OnLogoutCallbackFunc . "();});\n";
        $html .= "}, 500);\n";
        $html .= "}\n";
        if ($this->commandType == 'auto')
        {
            $html .= $OnOpenPopupFunc . "();";
        }
        $html .= "</script>\n";

        switch ($this->commandType)
        {
            case "button":
                $html .= "<input type='button' onclick='" . $OnOpenPopupFunc;
                $html .= "()' id='LogoutButton" . GlobalCounter::GetCount() . "' value='" . $this->commandText;
                $html .= "' style='" . $this->cssStyle . "' class='" . $this->cssClass . "' />";
                break;
            case "link":
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' onclick='" . $OnOpenPopupFunc;
                $html .= "()' id='LogoutLink" . GlobalCounter::GetCount() . "' >" . $this->commandText ."</a>";
                break;
             case 'image':
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' onclick='" . $OnOpenPopupFunc;
                $html .= "()' id='LogoutLink" . GlobalCounter::GetCount() . "' ><img src='" . $this->image . "' alt='' /></a>";
                break;
            case 'auto':
                break;
            default:
                throw new Exception('Logout Error:  Unsupported Command Type: ' . $this->commandType);
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
    private $commandText = "Logout";
    private $onLogoutJavaScript = null;
    private $onLogoutSubmitForm = null;
    private $cssStyle = null;
    private $cssClass = null;
    private $image = null;
}
?>
