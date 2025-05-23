<?php

namespace Modules\Blog\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Blog\Models\Tag;

class TagsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tag::all()
        ->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'created_at' => $tag->created_at->format('Y-m-d'),
            ];
        });;
    }
    public function headings(): array
    {
        return ['id','name', 'slug', 'created_at'];
    }
}
