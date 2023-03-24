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

    public function create_admin_view_categories() {
        return view("admin.view-categories", [
            "categories" => Category::all(),
        ]);
    }

    public function create_add_category() {
        return view("admin.add-category");
    }

    public function store(Request $request) {
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

    public function edit($id) {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request) {

        $attributes = $request->validate([
            'category_id' => 'required|exists:categories,id',
            "name" => ["string", "max:255", "unique:categories,name," . $request->get("category_id"), "regex:/^[a-zA-Z0-9_]*$/"],
            'description' => 'string',
            'color' => ["regex:/^(\#[\da-f]{3}|\#[\da-f]{6}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/"],
            "displayed_in_navbar" => "boolean",
        ]);

        $category = Category::find($attributes["category_id"]);
        unset($attributes["category_id"]);
        foreach($attributes as $name => $value) {
            $category[$name] = $value;
        }


        $category->save();

        /* Updating categories is done in real-time without page refresh so we send a simple 
         * message back instead of a redirect */
        return "Category updated successfully";
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category has been deleted');
    }
}