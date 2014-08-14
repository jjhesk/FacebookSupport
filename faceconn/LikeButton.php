<?php
/**
 * Like button allows users to share some content from the website with their friends. Pressing
 * on the Like button will result in publishing of a story on user's profile, with link to the website.
 */
class LikeButton
{
    /**
     * Function sets the URL of the like button. If it's not set, current page URL is used.
     * @param <string> $url
     */
    public function SetUrl($url) {$this->url = $url;}

    /**
     * Function sets the layout. Available values are 'standard', 'button_count', 'box_count'. 
	 * Default value is 'standard'.
     * @param <string> $layout
     */
    public function SetLayout($layout)
    {
        if ($layout == "button_count")
        {
            $this->layout = $layout;
        }
        else if ($layout == "box_count")
        {
            $this->layout = $layout;
        }
        else if ($layout == "standard")
        {
            $this->layout = null;
        }
        else
        {
            throw new Exception('LikeButton Error:  Unsupported layout: ' . $layout);
        }
    }

    /**
     * Call this function with the parameter set to true to show profile picture bellow the like button. 
	 * Default value is true.
     * @param <bool> $showFaces
     */
    public function SetShowFaces($showFaces) 
    {
        if (! is_bool($showFaces))
        {
           throw new Exception('LikeButton Error:  ShowFaces parameter is not a boolean type.');
        }
        $this->showFaces = $showFaces;
    }

    /**
     * Function sets the width of the like button in pixels. Default value is 450.
     * @param <int> $width
     */
    public function SetWidth($width) 
    {
        if (! is_int($width))
        {
            throw new Exception("LikeButton Error:  Width parameter is not an integer type.");
        }
        $this->width = $width;
    }

    /**
     * Function sets the text of the like button. Available values are 'like' and 'recommend'. 
	 * Defined text is translated depending on user language settings.
     * @param <string> $action
     */
    public function SetAction($action)
    {
        if ($action == "recommend")
        {
            $this->action = $action;
        }
        else if ($action != "like")
        {
            throw new Exception('LikeButton Error:  Unsupported action: ' . $action);
        }
    }

    /**
     * Function sets the font inside the like button. Available values are 'arial', 'lucida grande',
     * 'segoe ui', 'tahoma', 'trebuchet ms' and 'verdana'.
     * @param <string> $font
     */
    public function SetFont($font)
    {
        if ($font != null)
        {
            switch ($font)
            {
                case "arial":
                case "lucida grande":
                case "segoe ui":
                case "tahoma":
                case "trebuchet ms":
                case "verdana":
                    $this->font = $font;
                    break;
                default:
                    throw new Exception('Like Button Error:  Unsupported font: ' . $font);
            }
        }
    }

    /**
     * Function sets the color scheme. Available values are 'light' and 'dark'. Deault value is 'light'.
     * @param <string> $colorScheme
     */
    public function SetColorScheme($colorScheme)
    {
        if ($colorScheme == "dark")
        {
            $this->colorScheme = $colorScheme;
        }
        else if ($colorScheme != "light")
        {
            throw new Exception('LikeButton Error:  Unsupported Color Scheme: ' . $colorScheme);
        }
    }

    /**
     * Function sets the reference string for tracking referals.
     * @param <string> $ref
     */
    public function SetRef($ref) {$this->ref = $ref;}
    
    /**
     * Function set send button as visible/not visible. Default is false.
     * @param type $send 
     */
    public function SetSend($send) {$this->send = $send;}


    /**
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $html = "<fb:like ";
        if ($this->url != null)
        {
            $html .= "href='" . $this->url . "' ";
        }
        if ($this->layout != null)
        {
            $html .= "layout='" . $this->layout . "' ";
        }
        if ($this->showFaces == false)
        {
            $html .= "show_faces='false' ";
        }
        if ($this->width != 450)
        {
            $html .= "width='" . $this->width . "' ";
        }
        if ($this->action != null)
        {
            $html .= "action='" . $this->action . "' ";
        }
        if ($this->font != null)
        {
            $html .= "font='" . $this->font . "' ";
        }
        if ($this->colorScheme != null)
        {
            $html .= "colorscheme='" . $this->colorScheme . "' ";
        }
        if ($this->ref != null)
        {
            $html .= "ref='" . $this->ref . "' ";
        }
        if ($this->send)
        {
            $html .="send='true' ";
        }
        $html .= "></fb:like>\n";
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
    private $url = null;
    private $layout = null;
    private $showFaces = true;
    private $width = 450;
    private $action = null;
    private $font = null;
    private $colorScheme = null;
    private $ref = null;
    private $send = false;
}
?>
