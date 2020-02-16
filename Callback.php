<?php

namespace Truonglv\MostReactedPost;

class Callback
{
    /**
     * @param string $html
     * @return string
     */
    public static function renderPostHtml($html)
    {
        $html = preg_replace('/id="js-post-(\d+)"/i', 'id="js-mrp-post-\1"', $html);
        $html = preg_replace('/id="post-(\d+)"/i', 'id="mrp-post-\1"', $html);

        return $html;
    }
}
