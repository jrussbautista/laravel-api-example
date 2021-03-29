<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index() {
        return CategoryResource::collection(Category::all());
    }

    public function show(Category $category) {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request) {

        $data = $request->all();

        if($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'categories/'.uniqid().'.'.$file->extension();
            $file->storeAs('public', $fileName);
            $data['photo'] = $fileName;
        }

        $category = Category::create($data);


        return new CategoryResource($category);
    }

    public function update(Category $category,  StoreCategoryRequest $request) {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    public function destroy(Category $category) {
        $category->delete();
        return response()->noContent();
    }
}
