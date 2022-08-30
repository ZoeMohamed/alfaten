@extends('layouts.app')

@section('navbar')
    @php $page = 'Carts'; @endphp
    @include('layouts.nav.customer')
@endsection

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col col-md-9 col-sm-12">
                <h3>Daftar Produk</h3>

                <div class="row">
                    @foreach ($carts as $cart)
                        <div class="col-md-9 col-sm-12 mb-2">
                            <div class="card">
                                <div class="card-header">

                                    {{ $cart->product->name }}

                                    <div class="mb-2"></div>

                                    <img src="{{ $cart->product->thumbnail }}" alt="" width="100" height="100">
                                </div>

                                <div class="card-body">

                                    <p>Carts Quantity : {{ $cart->quantity }}</p>
                                    <p>Price : {{ $cart->product->price }}</p>
                                    {{-- {!! $product->new_price !== $product->price ? "<s> $product->price </s>" : $product->price !!}
                                    <br>
                                    {{ $product->new_price !== $product->price ? $product->new_price : '' }} --}}
                                    <p>Price After Discount : {{ $cart->product->new_price }}</p>
                                    <div class="d-flex gap-3">
                                        @include('customer.modal_detail')
                                        <button class="btn btn-success" data-bs-target="#detail{{ $cart->id }}"
                                            data-bs-toggle="modal">Detail</button>

                                        @include('customer.modal_edit')

                                        <button class="btn btn-warning" data-bs-target="#edit{{ $cart->id }}"
                                            data-bs-toggle="modal">Edit</button>


                                        @include('customer.modal_delete')

                                        <button class="btn btn-danger" data-bs-target="#delete{{ $cart->id }}"
                                            data-bs-toggle="modal">Delete</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>

            </div>

            <div class="col col-md-3 col-sm-12">

                <div class="card me-4 mt-4">
                    <div class="card-header">
                        <h3>Total Harga</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mt-3"> Rp.{{ $total_harga }}
                        </h4>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
