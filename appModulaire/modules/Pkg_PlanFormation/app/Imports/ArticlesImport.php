<?php

namespace Modules\Blog\app\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Models\Article;

class ArticlesImport implements ToModel ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Article([
            'title'  => $row['title'],
            'content' => $row['content'],
            'category' => $row['category'],
            'user ' => $row['user'],
            'created_at ' => $row['created_at']
        ]);
    }
}
