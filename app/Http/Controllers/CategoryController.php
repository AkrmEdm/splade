<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Tables\Categories;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            // 'categories' => SpladeTable::for(Category::class)
            //     ->withGlobalSearch(columns: ['name'])
            //     ->column('name', canBeHidden:false, sortable:true)
            //     ->column('slug')
            //     ->column('action')
            //     ->paginate(5),

            'categories' => Categories::class,
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());

        Toast::title('New category added!')->autoDismiss(5);
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryStoreRequest $request, Category $category)
    {
        $category->update($request->validated());

        Toast::title('Category Updated Successfully!')->autoDismiss(5);
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Toast::title('Category Deleted Successfully!')->autoDismiss(5);
        return redirect()->back();
    }

}
