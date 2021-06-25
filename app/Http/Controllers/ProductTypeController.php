<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProductTypeController extends Controller
{

    
    // use middleware so the functions of this controller can only be accessed by user with role 'Member' and 'Admin'
    // except for the index function, it can be accessed by 'guest'
    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->middleware('admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::all()->sortBy('name');
        return view('home', compact('productTypes'))->with([
            'message_success' => Session::get('message_success')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Show the Add Product Type page.
    public function create()
    {
        return view('productType.create')->with([
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
     * To perform add product type operation.
     * First, validate the input,  the name field is required with unique name and minimal 4 characters
     * the image is not required but the extension must be jpeg, png, or gif
     * If this validation fails, then it will return back to the page with error message.
     * If validation is success, then check the image input, if there are no image input, then store NULL value to the image path,
     * if there is an image input, then set the image path to the /storage/public/images folder/[imagename]
     * After that store it to the database by using create function from the ProductType model class.
     * After finish, return back to the page with success message.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|unique:product_types,name|min:4',
            'image'=>'mimes:jpeg,png,gif',
        ]);

        if ($request->image != null) {
            $image_path = '/'.'storage/'.$request->file('image')->store('images', 'public');
        } else {
            $image_path = NULL;
        }

        ProductType::create([
            'name'=>$request->name,
            'image'=>$image_path,
        ]);

        return redirect()->back()->with(
            [
                'message_success' => "The product type <b>" . $request->name . "</b> was created."
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductType $productType)
    {
        return view('productType.edit')->with([
            'productType' => $productType,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'name'=>'required|min:5',
            'image'=>'mimes:jpeg,png,gif'
        ]);

        if ($request->image) {
            $image_path = '/'.'storage/'.$request->file('image')->store('images', 'public');

            $productType->update([
                'name' => $request['name'],
                'image' => $image_path,
            ]);            
        }
        
        // else if image is not updated, don't update image 
        else {
            $productType->update([
                'name' => $request['name'],
                ]);   
            }

        return $this->index()->with(
            [
                'message_success' => "The product type <b>" . $productType->name . "</b> was updated."
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    /**
     * Perform delete product type operation
     * First find the ProductType data from the db
     * Take the image path and get rid of the '/storage'
     * then after that delete the image file from the public folder using Storage::disk delete function
     * After that using the delete() method from the product type model to delete the data from the db.
     * Finally, return back with success message
     */
    public function destroy(ProductType $productType)
    {
        $oldName = $productType -> name;
        $product = ProductType::find($productType->id);
        
        $image_path = str_replace('/storage', '', $productType->image);
        Storage::disk('public')->delete($image_path);
       
        $product->delete();

        return $this->index()->with(
            [
                'message_success' => "The product type <b>" . $oldName . "</b> was deleted."
            ]
        );
    }
}
