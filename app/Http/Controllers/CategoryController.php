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
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'style' => 'required|max:255'
        ]);

        $category = new Category([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'added_by' => auth()->id(),
            'style' => $request->get('style')
        ]);

        $category->save();

        return redirect('/categories')->with('success', 'Category has been added');
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
            'style' => 'required|max:255'
        ]);

        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->style = $request->get('style');

        $category->save();

        return redirect('/categories')->with('success', 'Category has been updated');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect('/categories')->with('success', 'Category has been deleted');
    }
}