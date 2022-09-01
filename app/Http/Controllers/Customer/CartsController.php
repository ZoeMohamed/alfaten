<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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


        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'unpaid')
            ->with('product')->orderBy('product_id')->get();



        foreach ($carts as $cart) {

            $cart->product->discount =  Discount::where('product_id', $cart->product->id)
                ->where('start_date', "<=", date('Y-m-d'))
                ->where('end_date', '>=', date('Y-m-d'))->first();

            if ($cart->product->discount == null) {
                $cart->product->discount = (object)[
                    "percentage" => 0
                ];
            }

            $cart->product->potongan = $cart->product->discount->percentage / 100 * $cart->product->price;
            $cart->product->new_price = $cart->product->price - $cart->product->potongan;
        }

        // dd($carts);
        $jumlah_cart = $carts->sum('quantity');
        $total_harga = 0;

        foreach ($carts as $cart) {
            // dd($cart->product->price
            $total_harga += $cart->quantity * $cart->product->price;
        }
        return view('customer.carts', compact('carts', 'total_harga', 'jumlah_cart'));
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

    public function generateInvoice()
    {

        $invoice_code = "INV_" . Auth::user()->id . Str::random(5);

        $check = Transaction::where('invoice_code', $invoice_code)->get();

        //Jikalau Invoice sudah dipakai
        if (count($check) > 0) {
            $invoice_code = "INV_" . Auth::user()->id . Str::random(5);
            // $invoice_code
        }

        return $invoice_code;
    }
    public function checkout()
    {
        $invoice_code = $this->generateInvoice();
        Transaction::where('user_id', Auth::user()->id)->where('status', 'unpaid')->update([
            "invoice_code" => $invoice_code,
            "status" => "waiting"
        ]);

        return redirect()->route('customer.invoice', $invoice_code);

        // return redirect("/customer/carts/invoice/{$invoice_code}");
    }
    public function show($id)
    {
        //
    }
    public function invoice($invoice_code)
    {

        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'unpaid')
            ->with('product')->get();

        $jumlah_cart = $carts->sum('quantity');
        $transactions = Transaction::where('invoice_code', $invoice_code)->get();
        return view('customer.invoice', compact('transactions', 'jumlah_cart'));
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


        Transaction::find($id)->update([
            "quantity" => $request->qty
        ]);
        // dd($request->qty);
        return redirect()->back()->with('status', 'Berhasil Mengedit Jumlah Produk dari keranjang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Transaction::find($id);

        $cart->delete();

        return redirect()->back()->with('status', 'Berhasil mengapus barang dari keranjang');
    }
}
