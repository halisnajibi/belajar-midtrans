<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="#">Midtrans</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                <a class="nav-link" href="/belanja">Belanja</a>
                <a class="nav-link" href="/cart" id="cart">Cart</a>
                <a class="nav-link" href="/riwayat">Riwayat</a>
            </div>
        </div>
    </div>
</nav>
@push('myscript')
    <script>
         $.get('/cart/count', function(data) {
        $('#cart').text('Cart (' + data.count + ')');
    });
    </script>
@endpush