<?php

namespace Modules\Blog\Controllers;

use Modules\Core\Controllers\Controller;

use Modules\Blog\Services\CategoryService;
use Modules\Blog\Services\ArticleService;
use Modules\Blog\Services\TagService;

use Modules\Blog\app\Requests\ArticleRequest;
use Modules\Blog\app\Requests\ImportRequest;

use Modules\Blog\app\Imports\ArticlesImport;
use Modules\Blog\app\Exports\ArticlesExport;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    protected $articleService;
    protected $tagService;
    protected $categoryService;

    public function __construct(ArticleService $articleService,TagService $tagService, CategoryService $categoryService)
    {
        $this->articleService = $articleService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->articleService->paginate(4);
        return view('Blog::admin.article.index', compact('articles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getAll();
        $tags = $this->tagService->getAll();
        return view('Blog::admin.article.create', compact('categories','tags'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();
        $validated["user_id"] = Auth::id();
        $validated["category_id"] = $request->category;
        $article = $this->articleService->create( $validated);
        $article->tags()->attach($request->tags);
        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = $this->articleService->findOrFail((int) $id);
        return view('Blog::admin.article.show',compact('article'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(string $id)
    {
        $article = $this->articleService->findOrFail((int) $id);
        $categories = $this->categoryService->getAll();
        $tags = $this->tagService->getAll();
        return view('Blog::admin.article.edit',compact('article','categories','tags'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $id)
    {
        $this->articleService->findOrFail((int) $id); // Check if the article exists
        $this->articleService->update($id,$request->validated());
        // if(!$articleUpdated){
        //         abort(404);
        // }
        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->articleService->findOrFail((int) $id); // Check if the article exists
        $this->articleService->delete($id);
        return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    }
    
    /**
     * Import article
     */
    public function import(ImportRequest $request)
    {
        Excel::import(new ArticlesImport, $request->file('file'));
        return back()->with('success', 'Importation réussie !');
    }
    /**
     * Export article
     */
    public function export()
    {
        return Excel::download(new ArticlesExport, 'articles.xlsx');
    }
}
