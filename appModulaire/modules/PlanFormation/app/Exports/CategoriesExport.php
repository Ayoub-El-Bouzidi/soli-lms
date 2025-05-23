<?php

namespace Modules\Blog\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Blog\Models\Category;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all()
        ->map(function ($categpry) {
            return [
                'id' => $categpry->id,
                'name' => $categpry->name,
                'slug' => $categpry->slug,
                'created_at' => $categpry->created_at->format('Y-m-d'),
            ];
        });;
    }
    public function headings(): array
    {
        return ['id','name', 'slug', 'created_at'];
    }
}
