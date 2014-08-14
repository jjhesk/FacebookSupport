<?php
/**
 * Facebook Send Button is used by users of website to share interesting content
 * with their friends by selecting them from friends list. This will result in
 * sending the message to friends' inbox. There is also an option to send it to
 * the wall of group that user is fan of, or any email address.
 */
class SendButton
{
    private $url = null;
    private $font = null;
    private $colorScheme = null;
    private $ref = null;

    /**
     * Function sets the URL of the send button. If it's not set, current page URL is used.
     * @param <string> $url
     */
    public function SetUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Function sets the font inside the like button. Available values are 'arial', 'lucida grande',
     * 'segoe ui', 'tahoma', 'trebuchet ms' and 'verdana'.
     * @param <string> $font
     */
    public function SetFont($font)
    {
        if ($font != null) {
            switch ($font) {
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


    // Private members

    /**
     * Function sets the color scheme. Available values are 'light' and 'dark'. Deault value is 'light'.
     * @param <string> $colorScheme
     */
    public function SetColorScheme($colorScheme)
    {
        if ($colorScheme == "dark") {
            $this->colorScheme = $colorScheme;
        } else if ($colorScheme != "light") {
            throw new Exception('LikeButton Error:  Unsupported Color Scheme: ' . $colorScheme);
        }
    }

    /**
     * Function sets the reference string for tracking referals.
     * @param <string> $ref
     */
    public function SetRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * Function renders component on the web page, depending on defined settings.
     */
    public function Render()
    {
        echo $this->GetOutputHtml();
    }

    /**
     * Get html for creating of this component, depending on defined settings.
     * @return string html
     */
    public function GetOutputHtml()
    {
        $html = "<fb:send ";
        if ($this->url != null) {
            $html .= "href='" . $this->url . "' ";
        }
        if ($this->font != null) {
            $html .= "font='" . $this->font . "' ";
        }
        if ($this->colorScheme != null) {
            $html .= "colorscheme='" . $this->colorScheme . "' ";
        }
        if ($this->ref != null) {
            $html .= "ref='" . $this->ref . "' ";
        }
        $html .= "></fb:send>\n";
        return $html;
    }
}

?>

