<?php
/**
 * Recommendations control is used to show a list of interesting content for
 * particular domain. The list is created depending on user's personal preferences
 * and shared content by other people.
 */
class Recommendations
{
    /**
     * Function sets the domain for which to show recommendations. 
	   * Default domain is web site on which the page with control is located.
     * @param <type> $domain 
     */
    public function SetDomain($domain) {$this->domain = $domain;}

    /**
     * Function sets the width of the control in pixels. Default value is 300.
     * @param <int> $width
     */
    public function SetWidth($width) 
    {
        if (! is_int($width))
        {
            throw new Exception("Recommendations Error:  Width parameter is not an integer type.");
        }
        $this->width = $width;
    }

    /**
     * Function sets the height of the control in pixels. Default value is 300.
     * @param <int> $height
     */
    public function SetHeight($height) 
    {
        if (! is_int($height))
        {
            throw new Exception("Recommendations Error:  Height parameter is not an integer type.");
        }
        $this->height = $height;
    }

    /**
     * Call this function with the parameter set to true to show the header.
     * @param <type> $showHeader
     */
    public function SetShowHeader($showHeader) 
    {
        if (! is_bool($showHeader))
        {
           throw new Exception('Recommendations Error:  ShowHeader parameter is not a boolean type.');
        }
        $this->showHeader = $showHeader;
    }

    /**
     * Function sets the color scheme. Available values are 'light' and 'dark'. Default value is 'light'.
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
            throw new Exception('Recommendations Error:  Unsupported Color Scheme: ' . $colorScheme);
        }
    }

    /**
     * Function sets the font inside the control. Available values are 'arial', 'lucida grande',
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
                    throw new Exception('Recommendations Error:  Unsupported font: ' . $font);
            }
        }
    }

    /**
     * Function sets the border color.
     * @param <type> $borderColor
     */
    public function SetBorderColor($borderColor) {$this->borderColor = $borderColor;}



    /**
    * Get html for creating of this component, depending on defined settings.
    * @return string html
    */
    public function GetOutputHtml()
    {
        $html = "<fb:recommendations ";
        if ($this->domain != null)
        {
            $html .= "site='" . $this->domain . "' ";
        }
        if ($this->width != 300)
        {
            $html .= "width='" . $this->width . "' ";
        }
        if ($this->height != 300)
        {
            $html .= "height='" . $this->height . "' ";
        }
        if ($this->showHeader == false)
        {
            $html .= "header='false' ";
        }
        if ($this->colorScheme != null)
        {
            $html .= "colorscheme='" . $this->colorScheme . "' ";
        }
        if ($this->font != null)
        {
            $html .= "font='" . $this->font . "' ";
        }
        if ($this->borderColor != null)
        {
            $html .= "border_color='" . $this->borderColor . "' ";
        }
        $html .= "></fb:recommendations>\n";
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
    private $domain = null;
    private $width = 300;
    private $height = 300;
    private $showHeader = true;
    private $colorScheme = null;
    private $font = null;
    private $borderColor = null;
}
?>
