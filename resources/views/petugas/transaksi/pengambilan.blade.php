@extends('layouts.app')
@section('title','Konfirmasi Pengambilan')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ========================= --}}
        {{-- LEFT : DAFTAR BARANG --}}
        {{-- ========================= --}}
        <div class="lg:col-span-2">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Konfirmasi Pengambilan
                    </h2>

                    <p class="text-sm text-slate-500">
                        Ubah transaksi sebelum barang diserahkan kepada anggota
                    </p>

                </div>

            </div>

            {{-- SEARCH --}}
            <div class="mb-5">

                <input
                    type="text"
                    id="searchBarang"
                    placeholder="Cari barang..."
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition">

            </div>

            {{-- LIST BARANG --}}
            <div
                id="barangContainer"
                class="grid grid-cols-2 md:grid-cols-3 gap-5">

                @foreach($barang as $b)

                @php

                    $qtyDipilih = 0;

                    foreach($transaksi->detail as $detail){

                        if($detail->barang_id == $b->id){

                            $qtyDipilih = $detail->qty;

                            break;

                        }

                    }

                    $stokTampil = $b->stok + $qtyDipilih;

                @endphp

                <div class="barang-item bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg transition duration-300">

                    {{-- FOTO --}}
                    <div class="h-44 bg-slate-100 overflow-hidden">

                        <img
                            src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-300">

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4">

                        <h3 class="nama-barang font-bold text-slate-800 text-base line-clamp-1">
                            {{ $b->nama_barang }}
                        </h3>

                        <div class="flex items-center justify-between mt-3">

                            <div>

                                <p class="text-indigo-600 font-bold text-lg">
                                    Rp {{ number_format($b->harga_per_hari,0,',','.') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    per hari
                                </p>

                            </div>

                            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">
                                Stok {{ $stokTampil }}
                            </span>

                        </div>

                        @if($stokTampil <= 0)

                            <button
                                disabled
                                class="w-full mt-4 bg-slate-300 text-white py-2.5 rounded-2xl text-sm font-semibold cursor-not-allowed">

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
                                class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-2xl text-sm font-semibold transition">

                                + Tambah

                            </button>

                        @endif

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        {{-- ========================= --}}
        {{-- RIGHT : FORM --}}
        {{-- ========================= --}}
        <div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 sticky top-4">

                <div class="mb-5">

                    <h2 class="text-2xl font-bold text-slate-800">
                        Keranjang
                    </h2>

                    <p class="text-sm text-slate-500">
                        Detail transaksi penyewaan
                    </p>

                </div>

                <form
                    id="formPengambilan"
                    action="{{ route('petugas.transaksi.diambil',$transaksi->id) }}"
                    method="POST">

                    @csrf

                    {{-- ANGGOTA --}}
                    <div class="mb-4">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Anggota
                        </label>

                        <div class="rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3">

                            {{ $transaksi->user->name }}

                        </div>

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
                            value="{{ $transaksi->tanggal_pinjam }}"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">

                    </div>

                    {{-- TANGGAL KEMBALI --}}
                    <div class="mb-4">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Kembali
                        </label>

                        <input
                            type="date"
                            name="tanggal_kembali_rencana"
                            id="tglKembali"
                            value="{{ $transaksi->tanggal_kembali_rencana }}"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition">

                    </div>

                    {{-- DURASI --}}
                    <input
                        type="hidden"
                        id="durasiHidden"
                        name="durasi">

                    {{-- CART --}}
                    <div
                        id="cartList"
                        class="space-y-3 max-h-72 overflow-y-auto">

                    </div>
                                        {{-- ========================= --}}
                    {{-- TOTAL --}}
                    {{-- ========================= --}}
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
                        class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white py-3 rounded-2xl font-bold transition">

                        Konfirmasi Pengambilan

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- ========================= --}}
{{-- SWEET ALERT --}}
{{-- ========================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document
.getElementById('formPengambilan')
.addEventListener('submit',function(e){

    e.preventDefault();

    Swal.fire({

        title:'Konfirmasi Pengambilan',

        text:'Yakin barang akan diserahkan kepada anggota?',

        icon:'question',

        showCancelButton:true,

        confirmButtonText:'Ya, Serahkan',

        cancelButtonText:'Batal',

        reverseButtons:true

    }).then((result)=>{

        if(result.isConfirmed){

            this.submit();

        }

    });

});

</script>


{{-- ========================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================= --}}
<script>

let cart = [

@foreach($transaksi->detail as $d)

{

    id: {{ $d->barang->id }},

    nama: "{{ $d->barang->nama_barang }}",

    harga: {{ $d->barang->harga_per_hari }},

    qty: {{ $d->qty }}

},

@endforeach

];

let total = 0;

let lamaSewa = 1;
// ======================================
// SEARCH BARANG
// ======================================
document
.getElementById('searchBarang')
.addEventListener('keyup',function(){

    let keyword = this.value.toLowerCase();

    document.querySelectorAll('.barang-item')
    .forEach(item=>{

        let nama = item.querySelector('.nama-barang')
            .innerText
            .toLowerCase();

        item.style.display =
            nama.includes(keyword)
            ? 'block'
            : 'none';

    });

});


// ======================================
// HITUNG DURASI
// ======================================
function hitungDurasi(){

    let pinjam =
        document.getElementById('tglPinjam').value;

    let kembali =
        document.getElementById('tglKembali').value;

    if(pinjam=='' || kembali==''){

        lamaSewa = 1;

    }else{

        let tgl1 = new Date(pinjam);

        let tgl2 = new Date(kembali);

        let selisih =
            (tgl2 - tgl1) /
            (1000*60*60*24);

        lamaSewa =
            selisih > 0
            ? selisih
            : 1;

    }

    document
        .getElementById('durasiHidden')
        .value = lamaSewa;

}


// ======================================
// ADD TO CART
// ======================================
function addToCart(id,nama,harga){

    let item =
        cart.find(x=>x.id==id);

    if(item){

        item.qty++;

    }else{

        cart.push({

            id:id,

            nama:nama,

            harga:harga,

            qty:1

        });

    }

    renderCart();

}



// ======================================
// RENDER CART
// ======================================
function renderCart(){

    hitungDurasi();

    let html='';

    total = 0;

    cart.forEach((item,index)=>{

        let subtotal =
            item.harga *
            item.qty *
            lamaSewa;

        total += subtotal;

        html += `

<div class="border border-slate-200 rounded-2xl p-3">

<div class="flex justify-between">

<div class="flex-1">

<p class="font-semibold text-slate-700">
${item.nama}
</p>

<p class="text-xs text-slate-400 mt-1">

Rp ${item.harga.toLocaleString()}
×
${item.qty}
×
${lamaSewa} Hari

</p>

<input
type="hidden"
name="barang_id[]"
value="${item.id}">

<input
type="hidden"
name="qty[]"
value="${item.qty}">

</div>

<div class="text-right">

<p class="font-bold text-indigo-600">

Rp ${subtotal.toLocaleString()}

</p>

<div class="flex justify-end items-center gap-2 mt-2">

<button
type="button"
onclick="kurangItem(${index})"
class="w-7 h-7 rounded-lg bg-red-500 text-white">

-

</button>

<span class="font-semibold">

${item.qty}

</span>

<button
type="button"
onclick="tambahItem(${index})"
class="w-7 h-7 rounded-lg bg-green-500 text-white">

+

</button>

</div>

</div>

</div>

</div>

`;

    });

    if(cart.length==0){

        html=`

<div class="text-center text-slate-400 py-8">

Belum ada barang dipilih

</div>

`;

    }

    document
        .getElementById('cartList')
        .innerHTML = html;

    document
        .getElementById('totalHarga')
        .innerText =
        total.toLocaleString();

}
// ======================================
// TAMBAH ITEM
// ======================================
function tambahItem(index){

    cart[index].qty++;

    renderCart();

}


// ======================================
// KURANG ITEM
// ======================================
function kurangItem(index){

    cart[index].qty--;

    if(cart[index].qty <= 0){

        cart.splice(index,1);

    }

    renderCart();

}


// ======================================
// UPDATE SAAT TANGGAL BERUBAH
// ======================================
document
.getElementById('tglPinjam')
.addEventListener('change',function(){

    renderCart();

});

document
.getElementById('tglKembali')
.addEventListener('change',function(){

    renderCart();

});


// ======================================
// INIT
// ======================================
window.onload = function(){

    hitungDurasi();

    renderCart();

};

</script>