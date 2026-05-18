@extends('layouts.app')
@section('title','Sewa Barang')

@section('content')

<div class="p-6 grid grid-cols-12 gap-6">

    {{-- =========================
        DAFTAR BARANG (70%)
    ========================== --}}
    <div class="col-span-12 lg:col-span-8">
        <h2 class="text-xl font-bold text-slate-700 mb-4">
            Daftar Barang
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

            @foreach($barang as $b)
            <div class="bg-white p-3 rounded-xl shadow-sm border hover:shadow-md transition">

                {{-- FOTO --}}
                <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                     class="h-32 w-full object-cover rounded-lg">

                {{-- NAMA --}}
                <h3 class="font-semibold mt-2 text-slate-700">
                    {{ $b->nama_barang }}
                </h3>

                {{-- HARGA --}}
                <p class="text-sm text-slate-500">
                    Rp {{ number_format($b->harga_per_hari,0,',','.') }}/hari
                </p>

                {{-- STOK --}}
                <p class="text-xs text-slate-400">
                    Stok: {{ $b->stok }}
                </p>

                {{-- BUTTON --}}
                @if($b->stok == 0)
                    <button class="bg-gray-400 text-white w-full py-1 mt-2 rounded text-sm" disabled>
                        Stok Habis
                    </button>
                @else
                    <button
                        onclick="addToCart({{ $b->id }}, '{{ $b->nama_barang }}', {{ $b->harga_per_hari }})"
                        class="bg-blue-600 text-white w-full py-1 mt-2 rounded text-sm hover:bg-blue-700">
                        + Tambah
                    </button>
                @endif

            </div>
            @endforeach

        </div>
    </div>


    {{-- =========================
        KERANJANG (30%)
    ========================== --}}
    <div class="col-span-12 lg:col-span-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border">

            <h2 class="font-bold text-lg text-slate-700 mb-3">
                Keranjang Sewa
            </h2>

            <form action="{{ route('anggota.sewa.store') }}" method="POST">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input type="hidden" name="durasi" id="durasiHidden">

                {{-- TANGGAL PINJAM --}}
                <div class="mb-3">
                    <label class="text-sm text-slate-600">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tglPinjam"
                        class="border p-2 w-full rounded-lg text-sm">
                </div>

                {{-- DURASI --}}
                <div class="mb-3">
                    <label class="text-sm text-slate-600">Durasi</label>
                    <select id="durasi"
                        class="border p-2 w-full rounded-lg text-sm">
                        @for($i=1;$i<=9;$i++)
                        <option value="{{ $i }}">{{ $i }} hari</option>
                        @endfor
                    </select>
                </div>

                {{-- TANGGAL KEMBALI --}}
                <div class="mb-3">
                    <label class="text-sm text-slate-600">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali_rencana" id="tglKembali"
                        class="border p-2 w-full rounded-lg text-sm">
                </div>

                {{-- CART --}}
                <div id="cartList" class="space-y-2"></div>

                {{-- TOTAL --}}
                <div class="mt-4 text-lg font-bold text-slate-700">
                    Total: Rp <span id="totalHarga">0</span>
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    class="bg-green-600 text-white w-full py-2 mt-4 rounded-lg hover:bg-green-700">
                    Checkout
                </button>

            </form>

        </div>
    </div>

</div>

@endsection


{{-- =========================
    SCRIPT
========================= --}}
<script>

let cart = [];
let total = 0;
let lamaSewa = 1;


// TAMBAH CART
function addToCart(id,nama,harga){

    let item = cart.find(i => i.id === id);

    if(item){
        item.qty++;
    }else{
        cart.push({ id, nama, harga, qty:1 });
    }

    renderCart();
}


// RENDER CART
function renderCart(){

    let html = '';
    total = 0;

    lamaSewa = parseInt(document.getElementById('durasi').value);

    cart.forEach((item,i)=>{

        let sub = item.harga * item.qty * lamaSewa;
        total += sub;

        html += `
        <div class="flex justify-between items-center border-b pb-2">

            <div>
                <p class="text-sm font-medium">${item.nama}</p>
                <p class="text-xs text-slate-400">Rp ${item.harga.toLocaleString()}</p>

                <input type="hidden" name="barang_id[]" value="${item.id}">
                <input type="hidden" name="qty[]" value="${item.qty}">
            </div>

            <div class="flex items-center gap-2">
                <button type="button" onclick="kurangItem(${i})"
                    class="px-2 bg-red-500 text-white rounded">-</button>

                <span>${item.qty}</span>

                <button type="button" onclick="cart[${i}].qty++; renderCart()"
                    class="px-2 bg-green-500 text-white rounded">+</button>
            </div>

            <span class="text-sm font-semibold">
                Rp ${sub.toLocaleString()}
            </span>

        </div>
        `;
    });

    document.getElementById('cartList').innerHTML = html;
    document.getElementById('totalHarga').innerText = total.toLocaleString();
}


// KURANG ITEM
function kurangItem(i){
    cart[i].qty--;
    if(cart[i].qty <= 0){
        cart.splice(i,1);
    }
    renderCart();
}


// DURASI CHANGE
document.getElementById('durasi').addEventListener('change',()=>{

    lamaSewa = parseInt(document.getElementById('durasi').value);
    document.getElementById('durasiHidden').value = lamaSewa;

    updateTanggalKembali();
    renderCart();
});


// TANGGAL PINJAM
document.getElementById('tglPinjam').addEventListener('change',updateTanggalKembali);


// HITUNG TANGGAL KEMBALI
function updateTanggalKembali(){

    let tgl = document.getElementById('tglPinjam').value;
    if(!tgl) return;

    let pinjam = new Date(tgl);
    pinjam.setDate(pinjam.getDate() + lamaSewa);

    let yyyy = pinjam.getFullYear();
    let mm = String(pinjam.getMonth()+1).padStart(2,'0');
    let dd = String(pinjam.getDate()).padStart(2,'0');

    document.getElementById('tglKembali').value = `${yyyy}-${mm}-${dd}`;
}


// INIT
window.onload = function(){
    lamaSewa = parseInt(document.getElementById('durasi').value);
    document.getElementById('durasiHidden').value = lamaSewa;
}

</script>