@extends('layouts.app')
@section('title','Sewa Barang')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-slate-800">
            Sewa Barang
        </h1>

        <p class="text-slate-500 mt-1">
            Pilih perlengkapan bela diri yang ingin disewa
        </p>

    </div>


    <div class="grid grid-cols-12 gap-6">

        {{-- =========================================
            LIST BARANG
        ========================================== --}}
        <div class="col-span-12 lg:col-span-8">

            {{-- SEARCH --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">

                <div class="relative">

                    <input
                        type="text"
                        id="searchBarang"
                        placeholder="Cari barang..."
                        class="w-full rounded-xl pl-11 pr-4 border border-slate-300 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                    >

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 absolute left-4 top-3.5 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>

                    </svg>

                </div>

            </div>


            {{-- GRID BARANG --}}
            <div id="barangContainer"
                class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                @foreach($barang as $b)

                <div class="barang-item bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition duration-300">

                    {{-- FOTO --}}
                    <div class="relative">

                        <img
                            src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                            class="h-52 w-full object-cover"
                        >

                        {{-- BADGE STOK --}}
                        <div class="absolute top-3 right-3">

                            @if($b->stok > 0)

                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow">
                                    Stok {{ $b->stok }}
                                </span>

                            @else

                                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full shadow">
                                    Habis
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- CONTENT --}}
                    <div class="p-4">

                        <h3 class="font-semibold text-slate-800 text-lg">
                            {{ $b->nama_barang }}
                        </h3>

                        <div class="mt-2 flex items-center justify-between">

                            <div>

                                <p class="text-xs text-slate-400">
                                    Harga Sewa
                                </p>

                                <p class="text-blue-600 font-bold text-lg">
                                    Rp {{ number_format($b->harga_per_hari,0,',','.') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    / hari
                                </p>

                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <div class="mt-4">

                            @if($b->stok == 0)

                            <button
                                disabled
                                class="w-full bg-slate-300 text-white py-2.5 rounded-xl text-sm cursor-not-allowed"
                            >
                                Stok Habis
                            </button>

                            @else

                            <button
                                type="button"
                                onclick="addToCart(
                                    {{ $b->id }},
                                    '{{ $b->nama_barang }}',
                                    {{ $b->harga_per_hari }}
                                )"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-medium transition cursor-pointer"
                            >

                                + Tambah ke Keranjang

                            </button>

                            @endif

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>



        {{-- =========================================
            SIDEBAR CART
        ========================================== --}}
        <div class="col-span-12 lg:col-span-4">

            <div class="bg-white rounded-2xl shadow-sm sticky top-5 overflow-hidden">

                {{-- HEADER --}}
                <div class="p-5 bg-slate-50">

                    <h2 class="text-xl font-bold text-slate-800">
                        Keranjang Sewa
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Detail penyewaan barang
                    </p>

                </div>


                <form
                    action="{{ route('anggota.sewa.store') }}"
                    method="POST"
                    class="p-5"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="user_id"
                        value="{{ auth()->id() }}"
                    >

                    {{-- DURASI HIDDEN --}}
                    <input
                        type="hidden"
                        name="durasi"
                        id="durasiHidden"
                        value="1"
                    >


                    {{-- TANGGAL --}}
                    <div class="space-y-4">

                        {{-- TGL PINJAM --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Tanggal Pinjam
                            </label>

                            <input
                                type="date"
                                name="tanggal_pinjam"
                                id="tglPinjam"
                                value="{{ date('Y-m-d') }}"
                                required
                                class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            >

                        </div>


                        {{-- TGL KEMBALI --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Tanggal Kembali
                            </label>

                            <input
                                type="date"
                                name="tanggal_kembali_rencana"
                                id="tglKembali"
                                required
                                class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            >

                            <p class="text-xs text-slate-400 mt-2">
                                Durasi otomatis dihitung dari tanggal pinjam & tanggal kembali
                            </p>

                        </div>

                    </div>


                    {{-- CART --}}
                    <div class="mt-6">

                        <div class="flex items-center justify-between mb-3">

                            <h3 class="font-semibold text-slate-700">
                                Daftar Barang
                            </h3>

                            <span id="jumlahItem"
                                class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
                                0 Item
                            </span>

                        </div>

                        <div id="cartList"
                            class="space-y-3 max-h-80 overflow-y-auto pr-1">

                            <div class="text-sm text-slate-400 text-center py-6">
                                Belum ada barang dipilih
                            </div>

                        </div>

                    </div>


                    {{-- TOTAL --}}
                    <div class="mt-6 border-t pt-4">

                        <div class="flex justify-between items-center">

                            <span class="text-slate-600">
                                Total Pembayaran
                            </span>

                            <span class="text-2xl font-bold text-blue-600">
                                Rp <span id="totalHarga">0</span>
                            </span>

                        </div>

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition cursor-pointer"
                    >

                        Checkout Sekarang

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection



{{-- =========================================
    SCRIPT
========================================= --}}
<script>

let cart = [];
let total = 0;
let lamaSewa = 1;


// =========================================
// SEARCH BARANG
// =========================================
document.getElementById('searchBarang')
.addEventListener('keyup', function(){

    let keyword = this.value.toLowerCase();

    document.querySelectorAll('.barang-item')
    .forEach(item => {

        let nama =
            item.innerText.toLowerCase();

        item.style.display =
            nama.includes(keyword)
            ? 'block'
            : 'none';

    });

});


// =========================================
// HITUNG DURASI OTOMATIS
// =========================================
function hitungDurasi(){

    let tglPinjam =
        document.getElementById('tglPinjam').value;

    let tglKembali =
        document.getElementById('tglKembali').value;

    if(!tglPinjam || !tglKembali){

        lamaSewa = 1;

        document.getElementById('durasiHidden').value =
            1;

        return;

    }

    let start = new Date(tglPinjam);
    let end = new Date(tglKembali);

    let diff =
        (end - start) /
        (1000 * 60 * 60 * 24);

    lamaSewa = diff > 0 ? diff : 1;

    document.getElementById('durasiHidden').value =
        lamaSewa;

}


// =========================================
// ADD CART
// =========================================
function addToCart(id,nama,harga){

    let item = cart.find(i => i.id === id);

    if(item){

        item.qty++;

    }else{

        cart.push({
            id,
            nama,
            harga,
            qty:1
        });

    }

    renderCart();

}


// =========================================
// RENDER CART
// =========================================
function renderCart(){

    let html = '';

    total = 0;

    hitungDurasi();

    cart.forEach((item,i)=>{

        let sub =
            item.harga *
            item.qty *
            lamaSewa;

        total += sub;

        html += `
        <div class="border rounded-xl p-3">

            <div class="flex justify-between items-start">

                <div>

                    <p class="font-medium text-slate-700 text-sm">
                        ${item.nama}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Rp ${item.harga.toLocaleString()} ×
                        ${item.qty} ×
                        ${lamaSewa} hari
                    </p>

                    <input type="hidden" name="barang_id[]" value="${item.id}">
                    <input type="hidden" name="qty[]" value="${item.qty}">

                </div>

                <button
                    type="button"
                    onclick="hapusItem(${i})"
                    class="text-red-500 text-xs cursor-pointer"
                >
                    Hapus
                </button>

            </div>


            <div class="flex items-center justify-between mt-3">

                <div class="flex items-center gap-2">

                    <button
                        type="button"
                        onclick="kurangItem(${i})"
                        class="w-7 h-7 bg-red-500 text-white rounded-lg cursor-pointer"
                    >
                        -
                    </button>

                    <span class="font-semibold w-6 text-center">
                        ${item.qty}
                    </span>

                    <button
                        type="button"
                        onclick="tambahItem(${i})"
                        class="w-7 h-7 bg-green-500 text-white rounded-lg cursor-pointer"
                    >
                        +
                    </button>

                </div>

                <div class="font-bold text-blue-600 text-sm">
                    Rp ${sub.toLocaleString()}
                </div>

            </div>

        </div>
        `;

    });

    if(cart.length === 0){

        html = `
        <div class="text-sm text-slate-400 text-center py-6">
            Belum ada barang dipilih
        </div>
        `;

    }

    document.getElementById('cartList').innerHTML =
        html;

    document.getElementById('totalHarga').innerText =
        total.toLocaleString();

    document.getElementById('jumlahItem').innerText =
        cart.length + ' Item';

}


// =========================================
// TAMBAH ITEM
// =========================================
function tambahItem(i){

    cart[i].qty++;

    renderCart();

}


// =========================================
// KURANG ITEM
// =========================================
function kurangItem(i){

    cart[i].qty--;

    if(cart[i].qty <= 0){

        cart.splice(i,1);

    }

    renderCart();

}


// =========================================
// HAPUS ITEM
// =========================================
function hapusItem(i){

    cart.splice(i,1);

    renderCart();

}


// =========================================
// UPDATE TOTAL SAAT TANGGAL BERUBAH
// =========================================
document.getElementById('tglPinjam')
.addEventListener('change', renderCart);

document.getElementById('tglKembali')
.addEventListener('change', renderCart);


// =========================================
// INIT
// =========================================
window.onload = function(){

    hitungDurasi();

    renderCart();

}

</script>