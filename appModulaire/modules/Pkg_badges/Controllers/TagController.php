<?php

namespace Modules\Blog\Controllers;


use Modules\Core\Controllers\Controller;
use Modules\Blog\Models\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Blog\app\Exports\TagsExport;
use Modules\Blog\app\Imports\TagsImport;
use Modules\Blog\app\Requests\ImportRequest;
use Modules\Blog\app\Requests\TagRequest;
use Modules\Blog\Services\TagService;

use function PHPUnit\Framework\isNumeric;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::paginate(4);
        return view('Blog::admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Blog::admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $this->tagService->create($request->validated());
        return redirect()->route('tag.index')->with('success', 'Catégorie créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = $this->tagService->find($id);
        if(!$tag){
            abort(404);
        }
        return view('Blog::admin.tag.show',compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = $this->tagService->find($id);
        if(!$tag){
            abort(404);
        }
        return view('Blog::admin.tag.edit',compact('tag'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        $tagUpdated = $this->tagService->update($id,$request->validated());
        if(!$tagUpdated){
            abort(404);
        }
        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tagDeleted = $this->tagService->delete($id);
        if(!$tagDeleted){
            abort(404);
        }
        return redirect()->route('tag.index');
    }

    
    public function import(ImportRequest $request)
    {
        Excel::import(new TagsImport, $request->file('file'));
        return back()->with('success', 'Importation réussie !');
    }
    public function export()
    {
        return Excel::download(new TagsExport, 'Tags.xlsx');
    }
}
