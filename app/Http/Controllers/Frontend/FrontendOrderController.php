<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\Store\Order;
use App\Mail\Orders\OrderMail;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontendOrderController extends Controller
{

    public function post_order(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $lineItems = [];
        $cartItems = Cart::content();
        $total_price = 0;

        foreach($cartItems as $product){
            $total_price += $product->price * $product->qty;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'ron',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $product->qty,
            ];
        }

        // $sessionId = $request->get('session_id');
        // $session = $stripe->checkout->sessions->retrieve($sessionId);

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        $auth = Auth::user();

        $details = collect([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'county' => $request->input('county'),
            'locality' => $request->input('locality')
        ]);

        $order = new Order();
        $order->session_id = $checkout_session->id;
        $order->total_price = $total_price;
        $order->user_id = $auth->id ?? null;
        $order->products = serialize(Cart::content());
        $order->details = serialize($details);
        // $order->message = $request->message;
        $order->status_delivery = 'pending';
        $order->status_payment = 'unpaid';
        
        $order = Order::firstOrCreate($order->toArray());

        Mail::to($details['email'])->send(new OrderMail($details, $order));

        return redirect($checkout_session->url);
        
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');

        try{
            $session = $stripe->checkout->sessions->retrieve($sessionId);


            if(!$session)
                throw new NotFoundHttpException();
            

            $order = Order::where('session_id', $session->id)->where('status_payment', 'unpaid')->first();
            if(!$order)
                throw new NotFoundHttpException();

            if($order && $order->status_payment == 'unpaid'){
                $order->status_payment = 'paid';
                $order->save();
            }
    
            Cart::destroy();

            $customer = $session->customer_details->name;
            return view('frontend.store.checkout-success', compact('customer', 'lastFourDigits', 'cardType'));
            
        } catch(\Exception $e){
            return redirect()->to('/');
            // throw new NotFoundHttpException();
        }
        
    }

    public function cancel()
    {
        Cart::destroy();
        return redirect()->to('/');
        // dd('canceled');
    }

}
