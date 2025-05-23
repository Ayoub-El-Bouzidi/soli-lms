<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Comment;
use Modules\Blog\Models\Article;
use Modules\Core\Service\BaseService;

class CommentService extends BaseService
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }
    public function CommentsByArticle(Article $article)
    {
        return $article->comments;
    }
}


