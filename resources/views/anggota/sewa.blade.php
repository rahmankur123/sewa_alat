@extends('layouts.app')
@section('title','Sewa Barang')

@section('content')

<div class="grid grid-cols-12 gap-4">

{{-- 70% DAFTAR BARANG --}}
<div class="col-span-8">
    <h2 class="text-xl font-bold mb-3">Daftar Barang</h2>

    <div class="grid grid-cols-3 gap-4">

        @foreach($barang as $b)

        <div class="bg-white p-3 shadow rounded">

            <img src="{{ asset('storage/'.$b->foto) }}"
                 class="h-32 w-full object-cover rounded">

            <h3 class="font-bold mt-2">
                {{ $b->nama_barang }}
            </h3>

            <p class="text-sm text-gray-600">
                Rp {{ number_format($b->harga_per_hari) }}/hari
            </p>

            <p class="text-sm text-gray-500">
                Stok : {{ $b->stok }}
            </p>

            @if($b->stok == 0)

            <button class="bg-gray-400 text-white w-full py-1 mt-2 rounded" disabled>
                Stok Habis
            </button>

            @else

            <button
                onclick="addToCart({{ $b->id }}, '{{ $b->nama_barang }}', {{ $b->harga_per_hari }})"
                class="bg-blue-600 text-white w-full py-1 mt-2 rounded">

                + Tambah

            </button>

            @endif

        </div>

        @endforeach

    </div>
</div>


{{-- 30% KERANJANG --}}
<div class="col-span-4 bg-white p-4 shadow rounded">

<h2 class="font-bold text-lg mb-2">
Keranjang Sewa
</h2>

<form action="{{ route('sewa.store') }}" method="POST">
@csrf

{{-- USER ID OTOMATIS --}}
<input type="hidden" name="user_id" value="{{ auth()->id() }}">

{{-- TANGGAL PINJAM --}}
<div class="mt-3">
<label>Tanggal Pinjam</label>

<input
type="date"
name="tanggal_pinjam"
id="tglPinjam"
class="border p-2 w-full">
</div>


{{-- DURASI --}}
<div class="mt-2">
<label>Durasi (hari)</label>

<select id="durasi" class="border p-2 w-full">
@for($i=1;$i<=9;$i++)
<option value="{{ $i }}">{{ $i }} hari</option>
@endfor
</select>

<input type="hidden" name="durasi" id="durasiHidden">

</div>


{{-- TANGGAL KEMBALI --}}
<div class="mt-3">
<label>Tanggal Kembali</label>

<input
type="date"
name="tanggal_kembali_rencana"
id="tglKembali"
class="border p-2 w-full"
>
</div>


{{-- LIST CART --}}
<div id="cartList" class="mt-3"></div>


{{-- TOTAL --}}
<div class="mt-3 font-bold text-xl">
Total: Rp <span id="totalHarga">0</span>
</div>


<button class="bg-green-600 text-white w-full py-2 mt-4 rounded">
Checkout
</button>

</form>

</div>

</div>

@endsection



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
    cart.push({
        id,
        nama,
        harga,
        qty:1
    });
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
<div class="flex justify-between border-b py-1 items-center">

<input type="hidden" name="barang_id[]" value="${item.id}">
<input type="hidden" name="qty[]" value="${item.qty}">

<span>${item.nama}</span>

<div class="flex items-center gap-2">

<button type="button"
onclick="kurangItem(${i})"
class="px-2 bg-red-500 text-white">-</button>

<span>${item.qty}</span>

<button type="button"
onclick="cart[${i}].qty++; renderCart()"
class="px-2 bg-green-500 text-white">+</button>

</div>

<span>Rp ${sub.toLocaleString()}</span>

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



// DURASI
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

pinjam.setDate(pinjam.getDate()+lamaSewa);

let yyyy = pinjam.getFullYear();
let mm = String(pinjam.getMonth()+1).padStart(2,'0');
let dd = String(pinjam.getDate()).padStart(2,'0');

document.getElementById('tglKembali').value =
`${yyyy}-${mm}-${dd}`;

}



// DEFAULT
window.onload = function(){

lamaSewa = parseInt(document.getElementById('durasi').value);

document.getElementById('durasiHidden').value = lamaSewa;

}

</script>