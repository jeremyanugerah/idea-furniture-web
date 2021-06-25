<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Ui\Presets\React;

class CartItemController extends Controller
{
    // Use middleware so this page can only be accessed by user with role 'Member'
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Display the Shopping Cart Page
    public function index()
    {
        $user_id = Auth::user()->id;
        $cartItems = CartItem::where('user_id', '=', $user_id)->get();
        return view('cart.index', compact('cartItems'))->with([
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Perform add to cart operation
     * First, validate the input, quantity is required with numeric value and the value must be greater than 0
     * Then check if the Cart Item already existed in the user's shopping cart or not 
     * if it already existed, then update the quantity
     * if it has not existed yet, then create the cart item
     * Also, the system will check first if the product stock is available and is enough to meet the user's request/demand
     * if the stock is insufficient, then return back with warning message
     * if success, then create or update the Cart Item on the db.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $this->validate($request, [
            'quantity'=>'required|numeric|gt:0',
        ]);

        $cartItem = CartItem::where('user_id', $user_id)->where('product_id', $request->productId)->first();
        $product = Product::find($request->productId);

        // if the cart item doesn't exist 
        if($cartItem == null) {
            if($product->stock == 0) {
                return redirect()->back()->with([
                    'message_warning' => "Product is out of stock"]
                );
            }

            if($request->quantity > $product->stock) {
                return redirect()->back()->with([
                    'message_warning' => "Quantity must be lower or equal than stock"]
                );
            } 
            else {
                CartItem::create([
                    'user_id'=>$user_id,
                    'product_id'=>$product->id,
                    'quantity'=>$request->quantity
                ]);
    
                return redirect()->back()->with([
                        'message_success' => "Product <b>" . $product->name . "</b> was added to the cart."]
                );
            }
        }
        // if the cart item already existed in the cart
        else {
            // if the product stock is not enough
            if($request->quantity + $cartItem->quantity > $product->stock) {
                return redirect()->back()->with([
                    'message_warning' => "The quantity exceeds the available stock."]
                );
            }
            // if the stock is available
            else {
                $newQuantity = $request->quantity + $cartItem->quantity;
                $cartItem->update([
                    'quantity'=>$newQuantity,
                ]);
                return redirect()->back()->with([
                    'message_success' => "Quantity updated."]
                );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    /**
     * Perform update cart item operation 
     * First, validate the input, quantity is required with numeric value and the value must be greater than 0
     * After that, check the quantity value
     * if the value is the same as before (value isn't changed) then do not update and return back
     * if the requested quantity is greater than the stock, then return back with warning message
     * else if the requested quantity meets the stock, then update the cart item quantity and return with success message.
     */
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = Product::find($request->product_id);
        $cartItem = CartItem::where('user_id', $user_id)->where('product_id', $request->product_id)->first();

        $this->validate($request, [
            'quantity'=>'required|numeric|gt:0',
        ]);

        // if the requested quantity is equal or the same with before
        if($request->quantity == $cartItem->quantity) {
            return redirect()->back();
        }
        // if the requested quantity is greater than stock
        else if($request->quantity > $product->stock) {
            return redirect()->back()->with([
                'message_warning' => "The quantity requested for product <b>" . $product->name . "</b> exceeds the available stock.",
            ]);
        }    
        else {
            $newQuantity = $request->quantity;
            $cartItem->update([
                'quantity'=>$newQuantity,
            ]);

            return redirect()->back()->with([
                'message_success' => "The quantity for product <b>" . $product->name . "</b> has been updated."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    // Delete the cart item and then return back with success message
    public function destroy(Request $request)
    {
        $user_id = Auth::user()->id;
        $cartItem = CartItem::where('user_id', $user_id)->where('product_id', $request->product_id)->first();
        $oldName = $cartItem->product->name;

        $cartItem->delete();

        return redirect()->back()->with([
            'message_success' => "The product <b>" . $oldName . "</b> has been deleted from the cart."
        ]);
    }
}
