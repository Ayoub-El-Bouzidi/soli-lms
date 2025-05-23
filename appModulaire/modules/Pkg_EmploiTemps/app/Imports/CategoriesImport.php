<?php

namespace Modules\Blog\app\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Models\Category;

class CategoriesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'name'  => $row['name'],
            'slug' => $row['slug'],
        ]);
    }
}
