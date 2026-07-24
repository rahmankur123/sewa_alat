@extends('layouts.app')
@section('title','Transaksi Baru')

@section('content')

<div class="max-w-7xl mx-auto md:p-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===================== --}}
        {{-- LEFT - BARANG --}}
        {{-- ===================== --}}
        <div class="lg:col-span-2">

            {{-- HEADER --}}
            <div class="mb-5">

                <h2 class="text-2xl font-bold text-slate-800">
                    Transaksi Baru
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Pilih barang yang akan disewa
                </p>

            </div>

            {{-- SEARCH --}}
            <div class="mb-5">

                <input
                    type="text"
                    id="searchBarang"
                    placeholder="Cari barang..."
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition"
                >

            </div>

            {{-- LIST BARANG --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">

                @foreach($barang as $b)

                <div class="barang-item bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg transition duration-300">

                    {{-- FOTO --}}
                    <div class="h-40 overflow-hidden bg-slate-100">

                        <img
                            src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-300"
                        >

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4">

                        <h3 class="nama-barang font-bold text-slate-800 line-clamp-1">
                            {{ $b->nama_barang }}
                        </h3>

                        <div class="mt-3 flex items-center justify-between">

                            <div>

                                <p class="text-indigo-600 font-bold text-lg">
                                    Rp {{ number_format($b->harga_per_hari,0,',','.') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    per hari
                                </p>

                            </div>

                            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">
                                Stok {{ $b->stok }}
                            </span>

                        </div>

                        {{-- BUTTON --}}
                        @if($b->stok <= 0)

                        <button
                            disabled
                            class="w-full mt-4 bg-slate-300 text-white py-2.5 rounded-2xl text-sm font-semibold cursor-not-allowed"
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
                            class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-2xl text-sm font-semibold transition cursor-pointer"
                        >
                            + Tambah
                        </button>

                        @endif

                    </div>

                </div>

                @endforeach

            </div>

        </div>


        {{-- ===================== --}}
        {{-- RIGHT - KERANJANG --}}
        {{-- ===================== --}}
        <div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sticky top-4">

                {{-- HEADER --}}
                <div class="mb-5">

                    <h2 class="text-2xl font-bold text-slate-800">
                        Keranjang
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Detail transaksi penyewaan
                    </p>

                </div>

                <form action="{{ route('petugas.transaksi.store') }}" method="POST">
                    @csrf

                    {{-- PILIH ANGGOTA --}}
                    <div class="mb-4">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Pilih Anggota
                        </label>

                        <select
                            name="user_id"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                        >

                            <option value="">
                                -- Pilih Anggota --
                            </option>

                            @foreach($users as $u)

                                @if($u->role == 'anggota')

                                <option value="{{ $u->id }}">
                                    {{ $u->name }}
                                </option>

                                @endif

                            @endforeach

                        </select>

                    </div>

                    {{-- TANGGAL PINJAM --}}
                    <div class="mb-4">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Pinjam
                        </label>

                        <input
                            type="date"
                            name="tanggal_pinjam"
                            id="tglPinjam"
                            value="{{ date('Y-m-d') }}"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                        >

                    </div>

                    {{-- DURASI HIDDEN --}}
                    <input
                        type="hidden"
                        name="durasi"
                        id="durasiHidden"
                        value="1"
                    >

                    {{-- TANGGAL KEMBALI --}}
                    <div class="mb-5">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Kembali
                        </label>

                        <input
                            type="date"
                            name="tanggal_kembali_rencana"
                            id="tglKembali"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition"
                        >

                        <p class="text-xs text-slate-400 mt-2">
                            Durasi otomatis dihitung dari tanggal pinjam & tanggal kembali
                        </p>

                    </div>

                    {{-- CART --}}
                    <div
                        id="cartList"
                        class="space-y-3 max-h-72 overflow-y-auto"
                    >

                        <div class="text-sm text-slate-400 text-center py-6">
                            Belum ada barang dipilih
                        </div>

                    </div>

                    {{-- TOTAL --}}
                    <div class="mt-5 border-t border-slate-200 pt-4">

                        <div class="flex items-center justify-between">

                            <span class="font-semibold text-slate-700">
                                Total
                            </span>

                            <span class="text-2xl font-bold text-indigo-600">
                                Rp <span id="totalHarga">0</span>
                            </span>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white py-3 rounded-2xl font-bold transition cursor-pointer"
                    >
                        Checkout
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection



{{-- ========================= --}}
{{-- SCRIPT --}}
{{-- ========================= --}}
<script>

let cart = [];
let total = 0;
let lamaSewa = 1;


// =========================
// SEARCH BARANG
// =========================
document.getElementById('searchBarang')
.addEventListener('keyup', function(){

    let keyword = this.value.toLowerCase();

    document.querySelectorAll('.barang-item')
    .forEach(item => {

        let nama = item.querySelector('.nama-barang')
            .innerText
            .toLowerCase();

        item.style.display =
            nama.includes(keyword)
            ? 'block'
            : 'none';

    });

});


// =========================
// HITUNG DURASI
// =========================
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


// =========================
// ADD TO CART
// =========================
function addToCart(id, nama, harga){

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


// =========================
// RENDER CART
// =========================
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
        <div class="border border-slate-200 rounded-2xl p-3">

            <div class="flex justify-between items-start gap-3">

                <div class="flex-1">

                    <p class="font-semibold text-sm text-slate-700">
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

                <div class="text-right">

                    <p class="font-bold text-indigo-600 text-sm">
                        Rp ${sub.toLocaleString()}
                    </p>

                    <div class="flex items-center justify-end gap-2 mt-2">

                        <button
                            type="button"
                            onclick="kurangItem(${i})"
                            class="w-7 h-7 rounded-lg bg-red-500 text-white cursor-pointer"
                        >
                            -
                        </button>

                        <span class="text-sm font-semibold">
                            ${item.qty}
                        </span>

                        <button
                            type="button"
                            onclick="tambahItem(${i})"
                            class="w-7 h-7 rounded-lg bg-green-500 text-white cursor-pointer"
                        >
                            +
                        </button>

                    </div>

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

}


// =========================
// TAMBAH ITEM
// =========================
function tambahItem(i){

    cart[i].qty++;

    renderCart();

}


// =========================
// KURANG ITEM
// =========================
function kurangItem(i){

    cart[i].qty--;

    if(cart[i].qty <= 0){

        cart.splice(i,1);

    }

    renderCart();

}


// =========================
// UPDATE TOTAL
// =========================
document.getElementById('tglPinjam')
.addEventListener('change', renderCart);

document.getElementById('tglKembali')
.addEventListener('change', renderCart);


// =========================
// INIT
// =========================
window.onload = function(){

    hitungDurasi();

    renderCart();

}

</script>