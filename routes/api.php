<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AudienceController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function() {
    Route::get('/', 'getCategories');
    Route::post('/', 'createCategory');
    Route::get('/{categoryId}', 'getCategory');
    Route::patch('/{categoryId}', 'updateCategory');
    Route::delete('/{categoryId}', 'deleteCategory');
});

Route::controller(ProductController::class)->prefix('products')->group(function() {
    Route::get('/', 'getProducts');
    Route::get('/findProduct', 'findProduct');
});

Route::post('/login', function (Request $request) {
    $request->validate(['email'=>'required|email','password'=>'required']);

    if (!Auth::attempt($request->only('email','password'))) {
        return response()->json(['message'=>'Invalid credentials'], 401);
    }

    $user = $request->user();
    $token = $user->createToken('mobile')->accessToken;

    return response()->json(['token'=>$token]);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', fn(Request $r) => $r->user()->load('roles'));

    Route::post('/products', function (Request $request) {
        abort_unless($request->user()->can('products.create'), 403);
        return response()->json(['message' => 'Product logic here']);
    });

    Route::patch('/categories/{category}/status', function (Request $request, Category $category) {
        abort_unless($request->user()->can('updateStatus', $category), 403);

        $request->validate(['status' => 'required|string']);
        $category->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully']);
    });
});


Route::post('/authors', [AuthorController::class, 'createAuthor']);
Route::post('/articles', [ArticleController::class, 'createArticle']);
Route::post('/audiences', [AudienceController::class, 'createAudience']);
Route::post('/subscriptions', [SubscriptionController::class, 'subscribe']);
Route::post('/comments', [CommentController::class, 'createComment']);

Route::get('/authors/{authorName}/articles', [QueryController::class, 'getArticlesByAuthor']);
Route::get('/articles/{articleName}/audiences', [QueryController::class, 'getAudiencesByArticle']);
Route::get('/authors/{authorName}/audiences', [QueryController::class, 'getAudiencesByAuthor']);
Route::get('/audiences/{audienceName}/comments', [QueryController::class, 'getCommentsByAudience']);
Route::get('/comments', [QueryController::class, 'getAllCommentsWithTopic']);