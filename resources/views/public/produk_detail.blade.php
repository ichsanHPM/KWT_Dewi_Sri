@extends('layouts.public')

@section('title', $produk->nama_produk . ' - KWT Dewi Sri')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-success">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk.list') }}" class="text-decoration-none text-success">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                @if($produk->foto)
                    <img src="{{ asset('uploads/produks/' . $produk->foto) }}" class="img-fluid w-100" alt="{{ $produk->nama_produk }}" style="max-height: 500px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-leaf fa-5x text-secondary opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold text-dark mb-2">{{ $produk->nama_produk }}</h1>
            <h2 class="text-success fw-bold mb-2">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</h2>

            <div class="mb-4">
                @if($produk->stok > 0)
                    <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i> Stok Tersedia: {{ $produk->stok }}</span>
                @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i> Stok Habis</span>
                @endif
            </div>

            <div class="mb-4">
                <h5 class="fw-bold text-dark">Deskripsi</h5>
                <p class="text-muted">{{ $produk->deskripsi_produk }}</p>
            </div>

            @if($produk->spesifikasi)
            <div class="mb-4 p-3 bg-light rounded-3 border">
                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle me-2"></i>Spesifikasi</h6>
                <p class="mb-0 small text-secondary">{{ $produk->spesifikasi }}</p>
            </div>
            @endif

            <hr class="my-4">

            @auth
                @if($produk->stok > 0)
                    <div class="card border-success mb-3">
                        <div class="card-body bg-success bg-opacity-10">
                            <h5 class="card-title fw-bold text-success mb-3">Pesan Sekarang</h5>
                            
                            <form action="{{ route('pesan.store', $produk->id) }}" method="POST">
                                @csrf
    
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jumlah Pesanan</label>
                                    <div class="input-group" style="width: 150px;">
                                        <button class="btn btn-outline-success" type="button" onclick="updateQty(-1)">-</button>
                                        <input type="number" class="form-control text-center" id="jumlah_pesanan" name="jumlah_pesanan" 
                                            value="1" min="1" max="{{ $produk->stok }}" readonly>
                                        <button class="btn btn-outline-success" type="button" onclick="updateQty(1)">+</button>
                                    </div>
                                    <div class="form-text small">Stok tersedia: {{ $produk->stok }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Metode Pengiriman</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="metode_pengiriman" id="opsi_ambil" value="ambil" checked onchange="toggleAlamat()">
                                        <label class="btn btn-outline-success" for="opsi_ambil">Ambil Sendiri (Gratis)</label>

                                        <input type="radio" class="btn-check" name="metode_pengiriman" id="opsi_antar" value="antar" onchange="toggleAlamat()">
                                        <label class="btn btn-outline-success" for="opsi_antar">Diantar Kurir</label>
                                    </div>
                                </div>

                                <div id="area_pengiriman" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pilih Wilayah (Dusun)</label>
                                        <select class="form-select" name="dusun_id" id="dusun_select" onchange="hitungTotal()">
                                            <option value="" data-ongkir="0" selected>-- Pilih Lokasi Anda --</option>
                                            
                                            <optgroup label="Zona Dekat (Gratis Ongkir)">
                                                <option value="Kentungan" data-ongkir="0">Dusun Kentungan</option>
                                                <option value="Manukan" data-ongkir="0">Dusun Manukan</option>
                                            </optgroup>

                                            <optgroup label="Zona Jauh (+Rp 5.000)">
                                                <option value="Banteng" data-ongkir="5000">Dusun Banteng</option>
                                                <option value="Sanggrahan" data-ongkir="5000">Dusun Sanggrahan</option>
                                                <option value="Tambakan" data-ongkir="5000">Dusun Tambakan/Prujakan</option>
                                                <option value="Sumberan" data-ongkir="5000">Dusun Sumberan</option>
                                                <option value="Tiyasan" data-ongkir="5000">Dusun Tiyasan</option>
                                                <option value="Pogung" data-ongkir="5000">Dusun Pogung Lor/Kidul</option>
                                                <option value="Dayu" data-ongkir="5000">Dusun Dayu</option>
                                                <option value="Pondok" data-ongkir="5000">Dusun Pondok</option>
                                                <option value="Ploso Kuning" data-ongkir="5000">Dusun Ploso Kuning V</option>
                                            </optgroup>
                                        </select>
                                        <div class="form-text text-danger small" id="info_ongkir"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Detail Alamat</label>
                                        <textarea name="alamat_detail" id="alamat_detail" class="form-control" rows="2" placeholder="Contoh: Dusun, RT, Rumah pagar biru, depan pos ronda..."></textarea>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold text-muted">Total Bayar:</span>
                                    <h3 class="fw-bold text-success mb-0" id="tampilan_total">
                                        Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                    </h3>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-pill shadow-sm">
                                    <i class="fas fa-shopping-cart me-2"></i> Buat Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-secondary text-center py-4">
                        <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                        <h5 class="text-muted">Maaf, Stok Habis</h5>
                        <p class="small mb-0">Silakan cek kembali nanti atau hubungi admin.</p>
                    </div>
                @endif
            @else
                <div class="alert alert-warning border-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-lock me-3 fa-2x text-warning"></i>
                    <div>
                        <strong>Ingin membeli produk ini?</strong><br>
                        Silakan login terlebih dahulu untuk melakukan pemesanan.
                    </div>
                </div>
                <a href="{{ route('login') }}" class="btn btn-warning w-100 py-2 fw-bold rounded-pill text-white shadow-sm">
                    <i class="fas fa-sign-in-alt me-2"></i> Login untuk Membeli
                </a>
                <div class="text-center mt-2">
                    <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold">Daftar disini</a></small>
                </div>
            @endauth
        </div>
    </div>
</div>

<script>
    // Ambil data harga dan stok dari server ke variabel JS
    const hargaProduk = {{ $produk->harga_produk }};
    const stokMax = {{ $produk->stok }};

    // Fungsi Update Jumlah (+/-)
    function updateQty(change) {
        let input = document.getElementById('jumlah_pesanan');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + change;
        
        // Pastikan tidak minus dan tidak lebih dari stok
        if (newVal >= 1 && newVal <= stokMax) {
            input.value = newVal;
            hitungTotal(); // Update harga setiap kali jumlah berubah
        }
    }

    // Fungsi Tampilkan/Sembunyikan Alamat
    function toggleAlamat() {
        const isAntar = document.getElementById('opsi_antar').checked;
        const areaDiv = document.getElementById('area_pengiriman');
        const alamatInput = document.getElementById('alamat_detail');
        const dusunSelect = document.getElementById('dusun_select');

        if (isAntar) {
            areaDiv.style.display = 'block'; // Munculkan form
            alamatInput.required = true;     // Wajib diisi
            dusunSelect.required = true;     // Wajib diisi
        } else {
            areaDiv.style.display = 'none';  // Sembunyikan form
            alamatInput.required = false;    // Tidak wajib
            dusunSelect.required = false;    // Tidak wajib
            dusunSelect.value = "";          // Reset pilihan dusun
        }
        hitungTotal(); // Update harga (kembali ke 0 ongkir jika ambil sendiri)
    }

    // Fungsi Hitung Total (Harga Barang + Ongkir)
    function hitungTotal() {
        // 1. Ambil Jumlah Barang
        let qty = parseInt(document.getElementById('jumlah_pesanan').value);
        
        // 2. Cek Ongkir
        let ongkir = 0;
        let isAntar = document.getElementById('opsi_antar').checked;
        
        if (isAntar) {
            let select = document.getElementById('dusun_select');
            let selectedOption = select.options[select.selectedIndex];
            
            // Ambil atribut 'data-ongkir' dari opsi yang dipilih
            if (selectedOption.value !== "") {
                ongkir = parseInt(selectedOption.getAttribute('data-ongkir'));
            }
        }

        // 3. Tampilkan Info Ongkir (Tulisan Merah/Hijau kecil di bawah dropdown)
        let infoDiv = document.getElementById('info_ongkir');
        if (ongkir > 0) {
            infoDiv.innerHTML = "+ Ongkir Rp " + new Intl.NumberFormat('id-ID').format(ongkir);
            infoDiv.className = "form-text text-danger small fw-bold";
        } else if (isAntar && document.getElementById('dusun_select').value !== "") {
             infoDiv.innerHTML = "Gratis Ongkir (Jarak Dekat)";
             infoDiv.className = "form-text text-success small fw-bold";
        } else {
            infoDiv.innerHTML = "";
        }

        // 4. Kalkulasi Akhir
        let total = (hargaProduk * qty) + ongkir;

        // 5. Update Teks Total Bayar
        document.getElementById('tampilan_total').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);
    }
</script>

@endsection