<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ItemController extends Controller {

    // Define the directory where uploaded images will be saved
    private static function GET_UPLOAD_DIRECTORY() {
        return storage_path() . "\\app\\public\\item_images\\";
    }

    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == User::$ROLES["shop_owner"]) {
            return view('items.create', [
                "categories" => Category::all(),
            ]);
        }
        return redirect()->route("main_page")->with("error", "User does not have the required permission!");
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'shop_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'price' => 'required|min:0.01',
            'description' => 'required',
            'original_amount' => 'required|min:1',
            "image" => "required|image",
        ]);

        $validatedData["amount_currently_in_stock"] = $validatedData["original_amount"];
        
        // check if user has permissions to add an item (has to be owner of the shop or an admin)
        $user = auth()->user();
        if (!$validatedData["shop_id"] ==  $user->id || !$user->role == User::$ROLES["admin"]) {
            return redirect()->route('main_page')->with("error", "User does not have permissions to add item!");   
        }

        $image_path = $this->save_item_image($validatedData["image"]);
        $validatedData["image_path"] = $image_path;

        $item = Item::create($validatedData);
        $item->save();

        return redirect()->route('main_page')->with("success", "Item added successfully!");
    }

    public function save_item_image($imageInput) {

        $image = Image::make($imageInput);
        // Create a unique filename for the uploaded image
        $file_name = Str::uuid();
		$path = self::GET_UPLOAD_DIRECTORY() . $file_name . ".jpg";
        if ( $image->width() > $image->height() ) { // Landscape
            $image->widen(1200)
                ->save($path);
        } else { // Portrait
            $image->heighten(900)
                ->save($path);
        }
        return "/storage/item_images/" . $file_name . ".jpg";
    }

    public function items_by_user(User $user) {
        $items = $user->items;
        $user_full_name = $user->first_name . " " . $user->last_name;
        $user_id = $user->id;
        return view("items.index", compact("items", "user_full_name", "user_id"));
    }

    public function search(Request $request) {
        $query = $request->search;
        $items = Item::where('title', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->get();

        return view('items.search', [
            "items" => $items,
            "query" => $query,
        ]);
    }

    /**
     * Display the specified item.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'price' => 'required',
            'item_description' => 'required',
            'original_amount' => 'required|min:1',
            'amount_currently_in_stock' => 'required|min:0',
        ]);

        $item->update($validatedData);

        return redirect()->route('items.show', $item->id);
    }

    /**
     * Remove the specified item from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index');
    }

}