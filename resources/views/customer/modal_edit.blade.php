<div class="modal fade" id="edit{{ $cart->id }}"aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.updateCart', $cart->id) }}" method="POST">
                <div class="modal-body">

                    @csrf

                    <p>Nama Produk : {{ $cart->product->name }}</p>
                    <p>Harga Satuan : {{ $cart->product->price }}</p>
                    <input type="number" name="qty" value="{{ $cart->quantity }}" min="1">
                    <input type="hidden" value="{{ $cart->id }}" name="product_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>

        </div>
    </div>
</div>
