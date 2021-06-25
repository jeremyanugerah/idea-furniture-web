<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

     /**
      * Use middleware so this page can only be accessed by user with role 'Member' and role 'Admin'
      * except for the function indexFiltered and show, it can be accessed by 'Guest'
      */
    public function __construct()
    {
        $this->middleware('auth')->except('indexFiltered', 'show');
        $this->middleware('admin')->except('indexFiltered', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the products based on a productType
     * Also, if the user uses the search bar, then it will search the products data based on the search input
     * Then use paginate function so in every page it shows only 10 products
     */
    public function indexFiltered($productType_id, Request $request) {
        $products = Product::where('product_type_id', '=', $productType_id)->where('name', 'like', "%$request->search%")->paginate(10);
        $productType = ProductType::where('id', '=', $productType_id)->first();
        $search = $request->search;
        return view('product.index', compact('products', 'productType', 'search'))->with([
            'message_success' => Session::get('message_success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Display Add Product page
    public function create()
    {
        $productTypes = ProductType::all();
        return view('product.create')->with([
            'productTypes' => $productTypes,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * To perform add product operation.
     * First, validate the input,  the name field is required with minimal 5 characters
     * the image is not required but the extension must be jpeg, png, or gif
     * the type is required and must exists on the database, the stock and the price is required and must be numeric with value greater than zero
     * the description is required with minimal 15 characters.
     * If this validation fails, then it will return back to the page with error message.
     * If validation is success, then check the image input, if there are no image input, then store NULL value to the image path,
     * if there is an image input, then set the image path to the /storage/public/images folder/[imagename]
     * After that store it to the database by using create function from the Product model class.
     * After finish, return back to the page with success message.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|min:5',
            'image'=>'mimes:jpeg,png,gif',
            'type'=>'required|exists:product_types,id',
            'stock'=>'required|numeric|gt:0',
            'price'=>'required|numeric|gt:0',
            'description'=>'required|min:15',
        ]);

        if ($request->image != NULL) {
            $image_path = '/'.'storage/'.$request->file('image')->store('images', 'public');
        } else {
            $image_path = NULL;
        }

        Product::create([
            'name'=>$request->name,
            'image'=>$image_path,
            'product_type_id'=>$request->type,
            'stock'=>$request->stock,
            'price'=>$request->price,
            'description'=>$request->description
        ]);

        return redirect()->back()->with(
            [
                'message_success' => "The product <b>" . $request->name . "</b> was created."
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // Display the Product Detail page
    public function show(Product $product)
    {
        return view('product.show', compact('product'))->with([
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // Display the Edit Product page
    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        return view('product.edit')->with([
            'productTypes' => $productTypes,
            'product' => $product,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    /**
     * Perform update product operation based on the user input
     * First validate the input same with the 'add' function's validation
     * Then perform update function and only updates the image if the user input an image,
     * if the user does not input an image than do not update the image value/path.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name'=>'required|min:5',
            'image'=>'mimes:jpeg,png,gif',
            'type'=>'required|exists:product_types,id',
            'stock'=>'required|numeric|gt:0',
            'price'=>'required|numeric|gt:0',
            'description'=>'required|min:15',
        ]);

        // if image is filled
        if ($request->image) {
            $image_path = '/'.'storage/'.$request->file('image')->store('images', 'public');
            $product->update([
                'name'=>$request->name,
                'image'=>$image_path,
                'product_type_id'=>$request->type,
                'stock'=>$request->stock,
                'price'=>$request->price,
                'description'=>$request->description,
            ]);
        }

        // else if image is not updated, don't update image 
        else {
            $product->update([
                'name'=>$request->name,
                'product_type_id'=>$request->type,
                'stock'=>$request->stock,
                'price'=>$request->price,
                'description'=>$request->description,
            ]);
        }

        return redirect()->back()->with([
            'message_success' => "The product <b>" . $product->name . "</b> was updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    /**
     * Perform delete product operation
     * First find the Product data from the db
     * Take the image path and get rid of the '/storage'
     * then after that, delete the image file from the public folder using Storage::disk delete function
     * After that using the delete() method from the product model to delete the data from the db.
     * Finally, return back with success message
     */
    public function destroy(Product $product)
    {
        $oldName = $product -> name;
        $product = Product::find($product->id);
        $image_path = str_replace('/storage', '', $product->image);
        Storage::disk('public')->delete($image_path);
       
        $product->delete();

        return redirect()->back()->with([
            'message_success' => "The product <b>" . $oldName . "</b> was deleted."
        ]);
    }
}
