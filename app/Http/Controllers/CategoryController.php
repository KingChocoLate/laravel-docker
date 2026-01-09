<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories() {
        return response()->json(Category::all());
    }

    public function createCategory(Request $request) {
        $category = new Category;
        $category->name = $request->name;
        $category->save();
        return ["message" => "Creating 1 new category"];
    }

    public function getCategory($categoryId) {
        return ["message" => "Getting 1 category base on given categoryId"];
    }

    public function updateCategory($cateogryId) {
        return ["message" => "Updating 1 category base on given categoryId"];
    }

    public function deleteCategory($categoryId) {
        return ["message" => "Deleting 1 category base on given categoryId"];
    }

    public function show($task) {
        $this->authorize('view', $task);
    }
}
