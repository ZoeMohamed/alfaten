<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{



    public function __construct()
    {
        return $this->middleware(['auth', 'role:Customer']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::with('products.discounts')->get();

        // dd($categories);

        foreach ($categories as $category) {
            foreach ($category->products as $product) {
                $product->discount =  Discount::where('product_id', $product->id)
                    ->where('start_date', "<=", date('Y-m-d'))
                    ->where('end_date', '>=', date('Y-m-d'))->first();

                if ($product->discount == null) {
                    $product->discount = (object)[
                        "percentage" => 0
                    ];
                }

                $product->potongan = $product->discount->percentage / 100 * $product->price;
                $product->new_price = $product->price - $product->potongan;

                // dd($product->potongan);
            }
        }
        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'unpaid')
            ->with('product')->get();
        // ->select('*', DB::raw('sum(quantity) as qty'))
        // ->groupBy('product_id')
        // ->get();

        // dd($carts);
        $jumlah_cart = $carts->sum('quantity');
        $total_harga = 0;

        foreach ($carts as $cart) {
            // dd($cart->product->price
            $total_harga += $cart->quantity * $cart->product->price;
        }
        return view('customer.carts', compact('carts', 'total_harga', 'jumlah_cart', 'product'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
