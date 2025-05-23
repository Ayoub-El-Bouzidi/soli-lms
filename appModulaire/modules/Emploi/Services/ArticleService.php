<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Core\Service\BaseService;

class ArticleService extends BaseService
{
    public function __construct(Article $article)
    {
        parent::__construct($article);
    }
    public function update(int $id, array $data)
    {
        $article = $this->find($id);
        if ($article) {
            $article->update($data);
            $article->tags()->sync($data['tags']);
            return $article;
        }
        return null;
    }
}


