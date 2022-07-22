<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categories = Category::with('subCategories')->whereNull('parent_id')->get();
        // return view('dashboard.categories.index', compact($categories));

        return view('dashboard.categories.index', [
            'categories' => Category::with('subCategories')->whereNull('parent_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create', [
            'categories' => Category::with('subCategories')->whereNull('parent_id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        // $this->validate($request, [
        //     'name'       =>['required', 'max:80'],
        //     'parent_id'  =>['sometimes', 'nullable', 'numaric'],
        // ]); 

        //with using jobs
        // $this->dispatch(CreateCategoriesTable::fromRequest($request));

        $category = new Category();

        $category->name         = $request->name;
        $category->parent_id    = $request->parent_id;
        $category->slug         = Str::slug($request->name);

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category successfully created!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::with('subCategories')->whereNull('parent_id')->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => ['required'],
            'parent_id' => ['sometimes', 'nullable']
        ]);

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->slug = Str::slug($request->name);

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted!');
    }

    public function subCategories()
    {

        return view('dashboard.categories.sub-categories', [
            'categories' => Category::with('subCategories')->whereNotNull('parent_id')->get()
        ]);
    }
}
