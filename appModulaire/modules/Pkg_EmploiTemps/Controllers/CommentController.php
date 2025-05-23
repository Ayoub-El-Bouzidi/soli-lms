<?php

namespace Modules\Blog\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Controllers\Controller;
use Modules\Blog\app\Requests\CommentRequest;
use Modules\Blog\Services\ArticleService;
use Modules\Blog\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;
    protected $articleService;

    public function __construct(CommentService $commentService , ArticleService $articleService)
    {
        $this->commentService = $commentService;
        $this->articleService = $articleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->commentService->getAll();
        return view("Blog::admin.comment.index", compact("comments"));
    }

    /**
     * Display comments for a specific article.
     */
    public function indexByArticle(string $id)
    {
        $article = $this->articleService->find($id);
        $comments = $this->commentService->CommentsByArticle($article);
        return view("Blog::admin.comment.indexByArticle", compact("comments", "article"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementation for creating a comment (not provided)
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = $this->commentService->find($id);
        if (!$comment) {
            abort(404);
        }
        return view("Blog::admin.comment.show", compact("comment"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = $this->commentService->find($id);
        if (!$comment) {
            abort(404);
        }
        return view("Blog::admin.comment.edit", compact("comment"));
    }

    /**
     * Update the specified resource in storage.
     **/
    public function update(CommentRequest $request, string $id)
    {
        $comment = $this->commentService->findOrFail((int) $id); // Check if the comment exists
        $comment->update($request->validated());
        return redirect()->route('comment.show',$comment)->with('success', 'Commentaire modifié avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, string $articleId)
    {
        $article = $this->articleService->findOrFail((int) $articleId);
        // Create and save the comment
        $article->comments()->create([
            'content' => $request->content, // Assuming the user is logged in
            'user_id' => Auth::id(), // Assuming the user is logged in
        ]);
        // Redirect back with a success message
        return redirect()
            ->route('public.public.show', $article->id)
            ->with('success', 'Your comment has been added!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = $this->commentService->findOrFail((int) $id); // Check if the comment exists
        $comment->delete();

        return redirect()
            ->route('Blog::comment.index')
            ->with('success', 'Commentaire supprimé avec succès.');
    }

    public function destroyByArticle(string $id)
    {
        $comment = $this->commentService->findOrFail((int) $id); // Check if the comment exists
        $article = $comment->article;
        $comment->delete();

        return redirect()
            ->route('Blog::comment.indexByArticle', $article)
            ->with('success', 'Commentaire supprimé avec succès.');
    }
}
