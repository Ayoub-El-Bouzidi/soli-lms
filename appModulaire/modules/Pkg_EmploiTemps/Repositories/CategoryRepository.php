<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Models\Category;
use Modules\Core\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
