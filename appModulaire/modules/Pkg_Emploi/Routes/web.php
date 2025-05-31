<?php


use Modules\Blog\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Controllers\ArticleController;
use Modules\Blog\Controllers\CategoryController;
use Modules\Blog\Controllers\CommentController;
use Modules\Blog\Controllers\TagController;
use Modules\Blog\Controllers\HomeController;
use App\Http\Controllers\UserController;



// Route::get('/', function () {
//     return view('Blog::auth.login');
// })->middleware('guest');

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->name('dashboard');

// // import & export Articles
// Route::get('/exportArticles', [ArticleController::class, 'export'])->name('articles.export');
// Route::post('/importArticles', [ArticleController::class, 'import'])->name('articles.import');
// // import & export Tags
// Route::get('/exportTags', [TagController::class, 'export'])->name('tags.export');
// Route::post('/importTags', [TagController::class, 'import'])->name('tags.import');
// // import & export Categories
// Route::get('/exportCategories', [CategoryController::class, 'export'])->name('categories.export');
// Route::post('/importCategoryies', [CategoryController::class, 'import'])->name('categories.import');

// Route::get('articles/{article}/comments', [CommentController::class, 'indexByArticle'])->name('comment.indexByArticle');
// Route::delete('articles/comment/{comment}', [CommentController::class, 'destroyByArticle'])->name('comment.destroyByArticle');



// Route::resource('/dashboard/comment',CommentController::class);
// Route::resource('/dashboard/article',ArticleController::class);
// Route::resource('/dashboard/category',CategoryController::class);
// Route::resource('/dashboard/tag',TagController::class);


// Route::get('/home', [HomeController::class, 'index'])->name('home');


// Route::get('/public', [HomeController::class, 'publicIndex'])->name('public.public.index');
// Route::get('/public/article/{id}', [HomeController::class, 'publicShow'])->name('public.public.show');
// Route::post('/articles/{id}/comments', [CommentController::class, 'store'])->name('public.article.comments.store');


// // Admin Routes with 'admin' role middleware
// Route::group(['middleware' => ['permission:view admin']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('/dashboard/article', ArticleController::class);
//     Route::resource('/dashboard/category', CategoryController::class);
//     Route::resource('/dashboard/tag', TagController::class);
//     Route::resource("/dashboard/user",UserController::class);

// });



// // Route::get('change', [LanguageController::class, 'change'])->name("lang.change");
