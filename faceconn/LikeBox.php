<?php
/**
 * This control enables the owners of web sites to connect it to their Facebook Page, so they can gain 
 * more Likes from their own website. Visitor of web site can easily become a fan of the Facebook Page;
 * see messages from the page wall, their friends which like it too, and the rest of the fans. 
 */
class LikeBox
{
    /**
     * Function sets the Facebook Page ID.
     * @param <string> $pageId
     */
    public function SetPageId($pageId) {$this->pageId = $pageId;}

    /**
     * Function sets the width of the like box in pixels. Default value is 292.
     * @param <int> $width
     * @throws Exception
     */
    public function SetWidth($width) 
	{
        if (! is_int($width))
        {
            throw new Exception("LikeBox Error:  Width parameter is not an integer type.");
        }
        $this->width = $width;
    }

    /**
     * Function sets the height of the like box in pixels.
     * @param <int> $width
     * @throws Exception
     */
    public function SetHeight($height)
	{
        if (! is_int($height))
        {
            throw new Exception("LikeBox Error:  Heights parameter is not an integer type.");
        }
        $this->height = $height;
    }

    /**
     * Function sets the number of fans to display. Default value is 10.
     * @param <int> $fansCount
     * @throws Exception
     */
    public function SetFansCount($fansCount) 
    {
        if (! is_int($fansCount))
        {
            throw new Exception("LikeBox Error:  FansCount parameter is not an integer type.");
        }
        $this->fansCount = $fansCount;
    }

    /**
     * Call this function with the parameter set to true to show the massages from the Page Wall.
     * @param <bool> $showStream
     * @throws Exception
     */
    public function SetShowStream($showStream)
    {
        if (! is_bool($showStream))
        {
           throw new Exception('LikeBox Error:  ShowStream parameter is not a boolean type.');
        }      
        $this->showStream = $showStream;
    }

    /**
     * Call this function with the parameter set to true to show the header.
     * @param <bool> $showHeader
     * @throws Exception
     */
    public function SetShowHeader($showHeader) 
    {
        if (! is_bool($showHeader))
        {
           throw new Exception('LikeBox Error:  ShowHeader parameter is not a boolean type.');
        }
        $this->showHeader = $showHeader;
    }

    /**
     * Get html for creating of this component, depending on defined settings.
     * @throws Exception
     * @return string html
     */
    public function GetOutputHtml()
    {
        if ($this->pageId == null)
        {
            throw new Exception('LikeBox Error:  Page ID is not set: ');
        }
        $html = "<fb:like-box profile_id='" . $this->pageId . "' ";
        if ($this->width != 292)
        {
            $html .= "width='" . $this->width . "' ";
        }
        if ($this->height != null)
        {
            $html .= "height='" . $this->height . "' ";
        }
        if ($this->fansCount != 10)
        {
            $html .= "connections='" . $this->fansCount . "' ";
        }
        if ($this->showStream == false)
        {
            $html .= "stream='false' ";
        }
        if ($this->showHeader == false)
        {
            $html .= "header='false' ";
        }
        $html .= "></fb:like-box>\n";
        return $html;
    }

    /**
     * Function renders component on the web page, depending on defined settings.
     */
    public function Render()
    {
        echo $this->GetOutputHtml();
    }


    //private members
    private $pageId = null;
    private $width = 292;
    private $height = null;
    private $fansCount = 10;
    private $showStream = true;
    private $showHeader = true;
}
?>
