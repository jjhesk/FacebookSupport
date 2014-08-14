<?php
//require_once  'faceconn/Tools.php';

/**
 * This is a common interface for all media types used for stream publishing.
 */
interface MediaType
{
    public function GetJSON();
}

/**
 * Facebook Stream publish popup is used to publish stories on users' wall, friends' wall
 * or on Facebook Page Wall if the user is an admin.
 */
class StreamPublish
{
    private $commandType = "button";
    private $commandText = "Publish";
    private $image = null;
    private $name = null;
    private $nameUrl = null;
    private $caption = null;
    private $description = null;
    private $userMessage = null;
    private $friendId = null;
    private $pageId = null;
    private $media = null;
    private $onPublishJavaScript = null;
    private $onPublishSubmitForm = null;
    private $cssStyle = null;
    private $cssClass = null;
    private $displayPopup = false;
    private $actionLinks = array();
    private $properties = array();

    /**
     * Function sets the type of the command control.
     * Allowed values are 'link', 'button', 'image' and 'auto'. Default value is 'button'.
     * @param <string> $commandType
     */
    public function SetCommandType($commandType)
    {
        if ($commandType != "button" && $commandType != "link" && $commandType != 'auto' && $commandType != "image") {
            throw new Exception("StreamPublish Error:  Unsuported command type: " . $commandType);
        }
        $this->commandType = $commandType;
    }

    /**
     * Function sets the title of a publish button/link. Default value is 'Publish'.
     * @param <string> $commandText
     */
    public function SetCommandText($commandText)
    {
        $this->commandText = $commandText;
    }

    // Private members

    /**
     * Function sets the image of the button.
     * @param <string> $image
     */
    public function SetImage($image)
    {
        $this->commandType = "image";
        $this->image = $image;
    }

    /**
     * Function sets the name of the story.
     * @param <string> $name
     */
    public function SetName($name)
    {
        $this->name = $name;
    }

    /**
     * Function sets the URL of the name. If it's set, the name of story is linked.
     * @param <string> $nameUrl
     */
    public function SetNameUrl($nameUrl)
    {
        $this->nameUrl = $nameUrl;
    }

    /**
     * Function sets the caption of the story.
     * @param <string> $caption
     */
    public function SetCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * Function sets the description of the story.
     * @param <string> $description
     */
    public function SetDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Function sets predefined user message.
     * @param <string> $userMessage
     */
    public function SetUserMessage($userMessage)
    {
        $this->userMessage = $userMessage;
    }

    /**
     * Function sets the friend ID. If it's set, the story is published on the friend's wall.
     * @param <string> $friendId
     */
    public function SetFriendId($friendId)
    {
        $this->friendId = $friendId;
    }

    /**
     * Function sets the Facebook Page ID. If it's set, the story is published on the Facebook Page.
     * @param <string> $pageId
     */
    public function SetPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    /**
     * Function sets the instance of MediaType.
     * Allowed types are ImageMedia, VideoMedia, Mp3Media and FlashMedia.
     * @param <MediaType> $media
     */
    public function SetMedia($media)
    {
        $this->media = $media;
    }

    /**
     * Function sets the JavaScript code to be executed after the story is published.
     * @param <string> $onPublishJavaScript
     */
    public function SetOnPublishJavaScript($onPublishJavaScript)
    {
        $this->onPublishJavaScript = $onPublishJavaScript;
    }

    /**
     * Function sets the form ID to be submitted after the story is published.
     * @param <string> $onPublishSubmitForm
     */
    public function SetOnPublishSubmitForm($onPublishSubmitForm)
    {
        $this->onPublishSubmitForm = $onPublishSubmitForm;
    }

    /**
     * Function sets the CSS style of the button/link.
     * @param <string> $cssStyle
     */
    public function SetCssStyle($cssStyle)
    {
        $this->cssStyle = $cssStyle;
    }

    /**
     * Function sets the CSS class of the button/link.
     * @param <string> $cssClass
     */
    public function SetCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * Call this function with the parameter set to true to show popup window.
     * @param <bool> $displayPopup
     */
    public function SetDisplayPopup($displayPopup)
    {
        $this->displayPopup = $displayPopup;
    }

    /**
     * Add property/linked property to propery list
     * @param <Property> $property
     */
    public function AddPropery($property)
    {
        $this->properties[] = $property;
    }

    /**
     * Add action link to action links list
     * @param <ActionLink> $actionLink
     */
    public function AddActionLink($actionLink)
    {
        $this->actionLinks[] = $actionLink;
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
        $OnPublishPopupFunc = "OnPopupFunc" . GlobalCounter::GetCount();
        $OnPublishCallbackFunc = "OnPublishCallbackFunc" . GlobalCounter::GetCount();

        $html = "<script>\n";
        $html .= "function " . $OnPublishCallbackFunc . "(response) {\n";
        $html .= "if (response != null && response != undefined) {\n";
        if ($this->onPublishJavaScript != null) {
            $html .= $this->onPublishJavaScript . ";\n";
        }
        if ($this->onPublishSubmitForm != null) {
            $html .= "document.getElementById('" . $this->onPublishSubmitForm . "').submit()";
        }
        $html .= "}\n";
        $html .= "}\n";
        $html .= "function " . $OnPublishPopupFunc . "() {\n";
        $html .= "if (graphApiInitialized == false) {\n";
        $html .= "  setTimeout('" . $OnPublishPopupFunc . "()', 100);\n";
        $html .= "  return;\n";
        $html .= "}\n";
        $html .= "var publish = {\n";
        $html .= "  method: 'stream.publish',\n";
        if ($this->displayPopup) {
            $html .= "display: 'popup',\n";
        }
        $html .= "  message: '" . $this->userMessage . "',\n";
        $html .= "  target_id: '" . $this->friendId . "',\n";
        $html .= "  actor_id: '" . $this->pageId . "',\n";

        // open attachment
        $html .= "  attachment: {\n";
        $html .= "    name: '" . $this->name . "',\n";
        $html .= "    caption: '" . $this->caption . "',\n";
        $html .= "    description: '" . $this->description . "',\n";
        $html .= "    href: '" . $this->nameUrl . "',\n";

        // add media
        if ($this->media != null) {
            $html .= "    media:[" . $this->media->GetJSON() . "],\n";
        }

        // add properties
        if (count($this->properties) > 0) {
            $html .= "properties:{";
            $firstAdded = false;
            foreach ($this->properties as $property) {
                if ($firstAdded) {
                    $html .= ",";
                }
                $html .= $property->GetJSON();
                $firstAdded = true;
            }
            $html .= "}\n";
        }

        // close attachment
        $html .= "  },\n";

        // add action links
        if (count($this->actionLinks) > 0) {
            $html .= "action_links:[";
            $firstAdded = false;
            foreach ($this->actionLinks as $link) {
                if ($firstAdded) {
                    $html .= ",";
                }
                $html .= $link->GetJSON();
                $firstAdded = true;
            }
            $html .= "]\n";
        }

        // close object and publish
        $html .= "  };\n";
        $html .= "  FB.ui(publish, " . $OnPublishCallbackFunc . ");\n";
        $html .= "}\n";

        // auto publish for 'auto' command type
        if ($this->commandType == 'auto') {
            $html .= $OnPublishPopupFunc . "();";
        }

        $html .= "</script>\n";

        // create publish button/link
        switch ($this->commandType) {
            case "button":
                $html .= "<input type='button' onclick='" . $OnPublishPopupFunc;
                $html .= "()' id='PublishButton" . GlobalCounter::GetCount() . "' value='" . $this->commandText;
                $html .= "' style='" . $this->cssStyle . "' class='" . $this->cssClass . "' />";
                break;
            case "link":
                $html .= "<a style='cursor:pointer' onclick='" . $OnPublishPopupFunc;
                $html .= "()' id='PublishLink" . GlobalCounter::GetCount() . "' >" . $this->commandText . "</a>";
                break;
            case 'image':
                $html .= "<a style='cursor:pointer;" . $this->cssStyle . "' onclick='" . $OnPublishPopupFunc;
                $html .= "()' id='PublishLink" . GlobalCounter::GetCount() . "' ><img src='" . $this->image . "' alt='' /></a>";
                break;
            case 'auto':
                break;
            default:
                throw new Exception('Stream Publish Control Error:  Unsupported Command Type: ' . $this->commandType);
        }
        return $html;
    }
}

/**
 * The class is used to store data about image media type for stream publishing.
 */
class ImageMedia implements MediaType
{
    private $imageUrl;
    private $destUrl;

    public function __construct($imageUrl, $destUrl)
    {
        $this->imageUrl = $imageUrl;
        $this->destUrl = $destUrl;
    }

    public function GetJSON()
    {
        return "{\"type\":\"image\",\"src\":\"" . $this->imageUrl . "\",\"href\":\"" . $this->destUrl . "\"}";
    }
}

/**
 * The class is used to store data about video media type for stream publishing.
 */
class VideoMedia implements MediaType
{
    private $videoUrl;
    private $imageUrl;
    private $destinationUrl;
    private $videoTitle;

    public function __construct($videoUrl, $imageUrl, $destinationUrl, $videoTitle)
    {
        $this->videoUrl = $videoUrl;
        $this->imageUrl = $imageUrl;
        $this->destinationUrl = $destinationUrl;
        $this->videoTitle = $videoTitle;
    }

    public function GetJSON()
    {
        $json = "{\"type\":\"video\",\"video_src\":\"" . $this->videoUrl . "\",\"preview_img\":\"" . $this->imageUrl . "\",";
        $json .= "\"video_link\":\"" . $this->destinationUrl . "\", \"video_title\":\"" . $this->videoTitle . "\"}";
        return $json;
    }
}

/**
 * The class is used to store data about MP3 media type for stream publishing.
 */
class Mp3Media implements MediaType
{
    private $mp3Url;
    private $title;
    private $artist;
    private $album;

    public function __construct($mp3Url, $title, $artist, $album)
    {
        $this->mp3Url = $mp3Url;
        $this->title = $title;
        $this->artist = $artist;
        $this->album = $album;
    }

    public function GetJSON()
    {
        $json = "{\"type\":\"mp3\",\"src\":\"" . $this->mp3Url . "\",\"title\":\"" . $this->title . "\",";
        $json .= "\"artist\":\"" . $this->artist . "\", \"album\":\"" . $this->album . "\"}";
        return $json;
    }
}

/**
 * The class is used to store data about Flash media type for stream publishing.
 */
class FlashMedia implements MediaType
{
    private $swfUrl;
    private $imageUrl;
    private $width;
    private $height;
    private $expandedWidth;
    private $expandedHeight;

    public function __construct($swfUrl, $imageUrl, $width, $height, $expandedWidth, $expandedHeight)
    {
        $this->swfUrl = $swfUrl;
        $this->imageUrl = $imageUrl;
        $this->width = $width;
        $this->height = $height;
        $this->expandedWidth = $expandedWidth;
        $this->expandedHeight = $expandedHeight;
    }

    public function GetJSON()
    {
        $json = "{\"type\":\"flash\",\"swfsrc\":\"" . $this->swfUrl . "\",\"imgsrc\":\"" . $this->imageUrl . "\",";
        $json .= "\"width\":\"" . $this->width . "\", \"height\":\"" . $this->height;
        $json .= "\",\"expanded_width\":\"" . $this->expandedWidth . "\", \"expanded_height\":\"" . $this->expandedHeight . "\"}";
        return $json;
    }
}

class ActionLink
{
    private $text;
    private $url;

    public function __construct($text, $url)
    {
        $this->text = $text;
        $this->url = $url;
    }

    public function GetJSON()
    {
        return "{\"text\":\"" . $this->text . "\",\"href\":\"" . $this->url . "\"}";
    }
}

class Property
{
    protected $name;
    protected $text;

    public function __construct($name, $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

    public function GetJSON()
    {
        return "\"" . $this->name . "\":\"" . $this->text . "\"";
    }
}

class LinkedProperty extends Property
{
    private $url;

    public function __construct($name, $text, $url)
    {
        $this->name = $name;
        $this->text = $text;
        $this->url = $url;
    }

    public function GetJSON()
    {
        return "\"" . $this->name . "\":{\"text\":\"" . $this->text . "\",\"href\":\"" . $this->url . "\"}";
    }
}

?>
