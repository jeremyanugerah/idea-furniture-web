<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Product;
use App\TransactionDetail;
use App\TransactionHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    // use middleware so the functions of this controller can only be accessed by user with role 'Member'
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * To display the transaction history page,
     * Get the user id from Auth
     * Get the transaction header data from its table where the user id is the same with the current user id
     * Order the transaction descendingly based on the transaction date.
     */
    public function index() {
        $user_id = Auth::user()->id;
        $transactions = TransactionHeader::where('user_id', '=', $user_id)->orderBy('date_time', 'DESC')->get();
        return view('transaction.index', compact('transactions'));
    }

    /**
     * Function to perform checkout operation
     * First check and validate if the product stock is sufficient
     * If out of stock or stock is insufficient then return back with messages on what items are not available
     * If the checkout is success then create the TransactionHeader and TransactionDetails and then delete the CartItems data
     * After that return back with success message showing the transaction is successful.
     */
    public function checkout() {
        $user_id = Auth::user()->id;
        $cartItems = CartItem::where('user_id', $user_id)->get();

        $array_message = [];
        $checkoutStatus = true;

        foreach($cartItems as $cartItem) {
            // if product is out of stock
            if($cartItem->product->stock == 0) {
                array_push($array_message, "Product <b>" . $cartItem->product->name . "</b> is out of stock!");
            }
            // if quantity requested is greater than stock available
            else if($cartItem->quantity > $cartItem->product->stock) {
                array_push($array_message, "The quantity requested for product <b>" . $cartItem->product->name . "</b> exceeds the available stock.");
                $checkoutStatus = false;
            }
        }

        // if the checkout fails
        if($checkoutStatus == false) {
            return redirect()->back()->withErrors([
                $array_message
            ]);
        }
        // if the checkout is GO
        else {
            TransactionHeader::create([
                'user_id' => $user_id,
                'date_time' => Carbon::now(),
            ]);

            $header = TransactionHeader::where('user_id', $user_id)->latest('date_time')->first();

            foreach($cartItems as $cartItem) {
                TransactionDetail::create([
                    'transaction_header_id' => $header->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ]);

                $product = Product::find($cartItem->product_id);
                $newStock = ($product->stock - $cartItem->quantity);
                $product->update([
                    'stock' => $newStock,
                ]);

                $cartItem->delete();
            }

            return redirect()->back()->with([
                'message_success' => "Checkout success"
            ]);
        }
    }
}
