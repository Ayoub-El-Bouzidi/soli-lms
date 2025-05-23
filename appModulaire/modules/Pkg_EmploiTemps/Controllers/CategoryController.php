<?php

namespace Modules\Blog\Controllers;

use Modules\Core\Controllers\Controller;

use Modules\Blog\app\Requests\CategoryRequest;
use Modules\Blog\app\Requests\ImportRequest;

use Modules\Blog\app\Exports\CategoriesExport;
use Modules\Blog\app\Imports\CategoriesImport;

use Modules\Blog\Services\CategoryService;
use Maatwebsite\Excel\Facades\Excel;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $categories = $this->categoryService->paginate(4);
        return view('Blog::admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Blog::admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->create($request->validated());
        return redirect()->route('category.index')->with('success', 'Catégorie créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->find($id);
        if(!$category){
            abort(404);
        }
        return view('Blog::admin.category.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->find($id);
        if(!$category){
            abort(404);
        }
        return view('Blog::admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $categoryUpdated = $this->categoryService->update($id,$request->validated());
        if(!$categoryUpdated){
            abort(404);
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryDeleted = $this->categoryService->delete($id);
        if(!$categoryDeleted){
            abort(404);
        }
        return redirect()->route('category.index');
    }

    
    public function import(ImportRequest $request)
    {
        Excel::import(new CategoriesImport, $request->file('file'));
        return back()->with('success', 'Importation réussie !');
    }
    public function export()
    {
        return Excel::download(new CategoriesExport, 'Categories.xlsx');
    }
}
