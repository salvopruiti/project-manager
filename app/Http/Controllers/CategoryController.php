<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::paginate();

        return view('categories.index', $data);
    }

    public function create()
    {
        return $this->edit(new Category());
    }

    public function edit(Category $category)
    {
        $data['category'] = $category;
        return view('categories.form', $data);
    }

    public function store(CategoryRequest $request)
    {
        $category = category::create($request->validated());

        return redirect()->route('categories.index');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index');
    }

    public function destroy(category $category)
    {
        try {

            \DB::beginTransaction();

            $category->tickets()->update(['category_id' => null]);
            $category->tasks()->update(['category_id' => null]);
            $category->delete();

            \DB::commit();

            return redirect()->route('categories.index');

        } catch (\Throwable $exception) {

            \DB::rollBack();

            throw $exception;
        }
    }
}
