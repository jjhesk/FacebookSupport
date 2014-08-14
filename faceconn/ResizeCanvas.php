<?php
/**
 *  This class is used to resize application canvas height depending on content inside Facebook Canvas
 *  and Page applications.
 */
class ResizeCanvas
{
    public function Render()
    {
        echo "<script type=\"text/javascript\">\n";
        echo "function ResizeIFrame() {\n";
        echo "    if (graphApiInitialized != true) {\n";
        echo "        setTimeout('ResizeIFrame()', 100);\n";
        echo "        return;\n";
        echo "    }\n";
        echo "     FB.Canvas.setAutoGrow();\n";
        echo "}\n";
        echo "ResizeIFrame();\n";
    }
}

?>
