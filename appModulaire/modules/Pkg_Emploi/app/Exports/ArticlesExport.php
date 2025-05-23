<?php

namespace Modules\Blog\app\Exports;

use Modules\Blog\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticlesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Article::with('category', 'user')
        ->get()
        ->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'category' => $article->category->name,
                'user' => $article->user->name,
                'created_at' => $article->created_at->format('Y-m-d'),
            ];
        });;
    }
    public function headings(): array
    {
        return ['id','Title', 'Content', 'Category', 'User', 'Created At'];
    }
}
