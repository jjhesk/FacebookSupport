<?php
/**
 * With Bookmark button users can bookmark your website inside the Facebook environment
 * and later on easily navigate back. The bookmark will be placed on left column of
 * the user's Facebook homepage.
 */
defined('ABSPATH') || exit;
if (!class_exists('Bookmark')) {
    class Bookmark
    {
        /**
         * Call this function with parameter set to false if bookmark button is used
         * inside Facebook application instead of Facebook Connect website.
         * @param <bool> $offFacebook
         * @throws Exception
         */
        public function SetOffFacebook($offFacebook)
        {
            if (!is_bool($offFacebook)) {
                throw new Exception('Bookmark Error:  OffFacebook parameter is not a boolean type.');
            }
            $this->offFacebook = $offFacebook;
        }

        /**
         * Get html for creating of this component, depending on defined settings.
         * @return string html
         */
        public function GetOutputHtml()
        {
            $html = "<fb:bookmark ";
            if ($this->offFacebook) {
                $html .= "type='off-facebook'";
            }
            $html .= "></fb:bookmark>\n";
            return $html;
        }

        /**
         * Function renders component on the web page, depending on defined settings.
         */
        public function Render()
        {
            echo $this->GetOutputHtml();
        }


        private $offFacebook = true;
    }
}
?>
