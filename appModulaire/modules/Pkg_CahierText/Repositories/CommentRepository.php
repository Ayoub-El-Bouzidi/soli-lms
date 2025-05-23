<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Models\Comment;
use Modules\Core\Repositories\BaseRepository;

class TagRepository extends BaseRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }
}
