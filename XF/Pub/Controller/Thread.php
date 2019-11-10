<?php

namespace Truonglv\MostReactedPost\XF\Pub\Controller;

use XF\Finder\Post;
use XF\Mvc\Reply\View;
use XF\Mvc\ParameterBag;
use XF\Repository\Attachment;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $response = parent::actionIndex($params);

        $limit = $this->options()->tMostReactedPost_limit;
        if ($response instanceof View && $limit > 0) {
            /** @var \XF\Entity\Thread|null $thread */
            $thread = $response->getParam('thread');
            if (!$thread || $thread->reply_count <= 0) {
                return $response;
            }

            /** @var Post $postFinder */
            $postFinder = $this->finder('XF:Post');

            $postFinder->with('User');
            $postFinder->inThread($thread, [
                'visibility' => false
            ]);

            $postFinder->where('message_state', 'visible');
            $postFinder->where('reaction_score', '>', 0);
            $postFinder->where('position', '>', 0);
            $postFinder->order('reaction_score', 'DESC');

            $postFinder->limit($limit);
            $posts = $postFinder->fetch();

            /** @var Attachment $attachmentRepo */
            $attachmentRepo = $this->repository('XF:Attachment');
            $attachmentRepo->addAttachmentsToContent($posts, 'post');

            /** @var \Truonglv\MostReactedPost\Data\Post $postData */
            $postData = $this->data('Truonglv\MostReactedPost:Post');
            $postData->setPosts($posts);
        }

        return $response;
    }
}
