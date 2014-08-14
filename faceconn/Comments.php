<?php
/**
 * This control is used to easily enable visitors of your web site to write comments on articles,
 * photos or any other content on your web site, and share them with their friends by posting them
 * on their profiles. Posting a comment on user's wall will result in more visitors from the
 * Facebook to your site.
 */

defined('ABSPATH') || exit;
if (!class_exists('Comments')) {
    class Comments
    {
        /**
         * Function sets the unique Id of the comments box. Default value is encoded page URL.
         * It's required only if more than one comments box is used on the same page.
         * @param <string> $uniqueId
         */
        public function SetUniqueId($uniqueId)
        {
            $this->uniqueId = $uniqueId;
        }

        /**
         * Function sets the width in pixels. Default value is 550.
         * @param <int> $width
         * @throws Exception
         */
        public function SetWidth($width)
        {
            if (!is_int($width)) {
                throw new Exception("Comments Error:  Width parameter is not an integer type.");
            }
            $this->width = $width;
        }

        /**
         * Function sets the maximum number of displayed comments. Default value is 10.
         * @param <int> $commentsCount
         * @throws Exception
         */
        public function SetCommentsCount($commentsCount)
        {
            if (!is_int($commentsCount)) {
                throw new Exception("Comments Error:  CommentsCount parameter is not an integer type.");
            }
            $this->commentsCount = $commentsCount;
        }

        /**
         * Function sets the color scheme. Available values are 'light' and 'dark'. Deault value is 'light'.
         * @param <string> $colorScheme
         * @throws Exception
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
         * Function sets the URL of the comments. If it's not set, current page URL is used.
         * @param <string> $url
         */
        public function SetUrl($url)
        {
            $this->url = $url;
        }

        /**
         * Get html for creating of this component, depending on defined settings.
         * @return string html
         */
        public function GetOutputHtml()
        {
            $html = "<fb:comments migrated='1' ";
            if ($this->uniqueId != null) {
                $html .= "xid='" . $this->uniqueId . "' ";
            }
            if ($this->width != 550) {
                $html .= "width='" . $this->width . "' ";
            }
            if ($this->commentsCount != 10) {
                $html .= "numposts='" . $this->commentsCount . "' ";
            }
            if ($this->colorScheme != null) {
                $html .= "colorscheme='" . $this->colorScheme . "' ";
            }
            if ($this->url != null) {
                $html .= "href='" . $this->url . "' ";
            }
            $html .= "></fb:comments>\n";
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
        private $uniqueId = null;
        private $width = 550;
        private $commentsCount = 10;
        private $colorScheme = null;
        private $url = null;
    }
}
?>
