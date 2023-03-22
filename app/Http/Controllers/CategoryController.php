<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.add-category');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
            'category_color' => 'required|max:255'
        ]);

        $category = new Category([
            'name' => $request->get('category_name'),
            'description' => $request->get('category_description'),
            'added_by' => auth()->id(),
            'color' => $request->get('category_color')
        ]);

        $category->save();

        return redirect()->back()->with('success', 'Category has been added');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'color' => 'required|max:255'
        ]);

        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->style = $request->get('style');

        $category->save();

        return redirect()->back()->with('success', 'Category has been updated');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category has been deleted');
    }
}