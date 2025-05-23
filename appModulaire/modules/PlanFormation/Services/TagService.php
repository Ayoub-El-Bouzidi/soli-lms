<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Tag;
use Modules\Core\Service\BaseService;

class TagService extends BaseService
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }
}


