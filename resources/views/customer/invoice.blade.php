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

        <div class="card">
            <div class="card-header">
                {{ $transactions[0]->updated_at }}
                {{ date('H:i:s') }}
                <p id="countdown"></p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let date = new Date();

        let jam = datte.getHours()
        let menit = date.getMinutes()
        let detik = date.getSeconds()

        let waktu = jam + ":" + menit + ":" + detik
        // let timeout = 7 * 60;
        // if (timeout > 0) {
        //     setInterval(function() {
        //         timeout -= 1
        //         document.getElementById('countdown').innerTextHTML
        //     }, 1000)
        // }
    </script>
@endpush
