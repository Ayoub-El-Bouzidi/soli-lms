<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Models\Article;
use Modules\Core\Repositories\BaseRepository;

class ArticleRepository extends BaseRepository
{
    public function __construct(Article $article)
    {
        parent::__construct($article);
    }
}
