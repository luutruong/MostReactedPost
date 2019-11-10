<?php

namespace Truonglv\MostReactedPost\Data;

use XF\Mvc\Entity\AbstractCollection;

class Post
{
    /**
     * @var null|AbstractCollection
     */
    private $posts = null;

    /**
     * @param AbstractCollection $posts
     * @return void
     */
    public function setPosts(AbstractCollection $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return AbstractCollection|null
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
