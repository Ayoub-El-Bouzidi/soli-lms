<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Models\Tag;
use Modules\Core\Repositories\BaseRepository;

class TagRepository extends BaseRepository
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }
}
