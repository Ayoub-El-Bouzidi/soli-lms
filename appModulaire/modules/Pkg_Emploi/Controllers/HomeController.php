<?php

namespace Modules\Pkg_Emploi\Controllers;


use Modules\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Services\ArticleService;
use Modules\Blog\Services\CategoryService;

class HomeController extends Controller
{
    protected $articleService;
    protected $categoryService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(/* ArticleService $articleService, CategoryService $categoryService */)
    {
        // $this->middleware('auth');
        // $this->articleService = $articleService;
        // $this->categoryService = $categoryService;
    }

    /**
     * Show the public articles index with filter and search.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function publicIndex(Request $request)
    {
        
    }

    /**
     * Show a single article.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publicShow($id)
    {
        $article = $this->articleService->findOrFail((int) $id);
        return view('Blog::public.articles.show', compact('article'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Blog::home');
    }
}
