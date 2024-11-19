<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    //
    public function index(){
        $items=Cart::instance('cart')->content();
        return view('cart',compact('items'));
    }
    public function add_to_cart(Request $request){
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back( );
    }
    public function increase_cart_quantity($rowId){
        $product=Cart::instance('cart')->get($rowId);
        $qty=$product->qty+1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    public function decrease_cart_quantity($rowId){
        $product=Cart::instance('cart')->get($rowId);
        $qty=$product->qty-1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function checkout()
    {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Assuming you have a model called Address for the address table
    $address = Address::where('user_id', Auth::user()->id)
                      ->where('isdefault', 1)
                      ->first();

    return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;

        // Retrieve the default address for the user
        $address = Address::where('user_id', $user_id)
                          ->where('isdefault', true)
                          ->first();

        // If no default address exists, validate and create a new address
        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            // Create a new address
            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'India'; // Assuming India is the default country
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }

        // Set checkout amounts
        $this->setAmountforCheckout();

        // Create a new order
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        // Add items to the order
        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id; // Correct property for product ID
            $orderItem->order_id = $order->id;  // Correct mapping of order ID
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }

        // Handle payment modes
        if ($request->mode == "card") {
            // Card-specific logic
        } elseif ($request->mode == "paypal") {
            // PayPal-specific logic
        } elseif ($request->mode == "cod") {
            // Handle Cash on Delivery
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }

        // Clear the cart and session data
        Cart::instance('cart')->destroy(); // Fixed typo
        Session::forget('coupon');
        Session::forget('checkout');
        Session::put('order_id', $order->id);

        // Redirect to order confirmation
        return redirect()->route('cart.order.confirmation', compact('order'));
    }

    public function setAmountforCheckout()
    {
        // Check if the cart is empty
        if (Cart::instance('cart')->content()->count() > 0) {
            if (!Session::has('coupon')) {
                Session::put('checkout', [
                    'subtotal' => str_replace(',', '', Cart::instance('cart')->subtotal()),
                    'tax' => str_replace(',', '', Cart::instance('cart')->tax()),
                    'total' => str_replace(',', '', Cart::instance('cart')->total()),
                ]);
            }
        } else {
            Session::forget('checkout');
        }
    }

    public function order_confirmation()
    {
        // Retrieve the order from the session
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order')); // Fixed typo in the view name
        }

        return redirect()->route('cart.index');
    }
}