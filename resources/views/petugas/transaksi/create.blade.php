
@extends('layouts.app')
@section('title','Transaksi Baru')

@section('content')
<div class="grid grid-cols-12 gap-4">

{{-- 70% BARANG --}}
<div class="col-span-8">
    <h2 class="text-xl font-bold mb-3">Daftar Barang</h2>

    <div class="grid grid-cols-3 gap-4">
        @foreach($barang as $b)
        <div class="bg-white p-3 shadow rounded">
            <img src="{{ asset('storage/'.$b->foto) }}" class="h-32 w-full object-cover rounded">
            <h3 class="font-bold mt-2">{{ $b->nama_barang }}</h3>
            <p>Rp {{ number_format($b->harga_per_hari) }}/hari</p>
            <button onclick="addToCart({{ $b->id }}, '{{ $b->nama_barang }}', {{ $b->harga_per_hari }})"
                class="bg-blue-600 text-white w-full py-1 mt-2 rounded">
                + Tambah
            </button>
        </div>
        @endforeach
    </div>
</div>


{{-- 30% KERANJANG --}}
<div class="col-span-4 bg-white p-4 shadow rounded">
    <h2 class="font-bold text-lg mb-2">Keranjang</h2>

    <form action="{{ route('petugas.transaksi.store') }}" method="POST">
        @csrf
        {{-- SLIDER ANGGOTA --}}
        <div class="mt-4">
            <div class="flex space-x-2">
                <button type="button" onclick="showMember('lama')" class="px-2 py-1 bg-gray-200 rounded">Anggota Lama</button>
                <button type="button" onclick="showMember('baru')" class="px-2 py-1 bg-gray-200 rounded">Anggota Baru</button>
            </div>

            <div id="anggotaLama" class="mt-2">
                <select name="user_id" class="border p-2 w-full">
    <option value="">-- Pilih Anggota --</option>
    @foreach($users as $u)
        @if($u->role == 'anggota')
            <option value="{{ $u->id }}">{{ $u->name }}</option>
        @endif
    @endforeach
</select>
            </div>

            <div id="anggotaBaru" class="mt-2 hidden">
                <input type="email" name="email" placeholder="Email anggota baru" class="border p-2 w-full">
            </div>
        </div>

        {{-- TANGGAL --}}
        <div class="mt-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tglPinjam" class="border p-2 w-full">
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
        
        <div class="mt-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali_rencana" id="tglKembali"class="border p-2 w-full">
        </div>

        
        <div id="cartList"></div>

        <div class="mt-3 font-bold text-xl">
            Total: Rp <span id="totalHarga">0</span>
        </div>

        <button class="bg-green-600 text-white w-full py-2 mt-4 rounded">
            CHECKOUT
        </button>
    </form>
</div>

</div>
@endsection
<script>
let cart = [];
let total = 0;
let lamaSewa = 1; // GANTI NAMA VARIABEL

// TAMBAH KE CART
function addToCart(id, nama, harga){
    let item = cart.find(i => i.id === id);
    if(item){
        item.qty++;
    }else{
        cart.push({id, nama, harga, qty:1});
    }
    renderCart();
}

// RENDER CART
function renderCart(){
    let html = '';
    total = 0;

    // AMBIL LANGSUNG DARI SELECT (ANTI BUG)
    lamaSewa = parseInt(document.getElementById('durasi').value);

    cart.forEach((item,i)=>{
        let harga = parseFloat(item.harga);
        let sub = harga * item.qty * lamaSewa;
        total += sub;

        html += `
        <div class="flex justify-between border-b py-1 items-center">
            <input type="hidden" name="barang_id[]" value="${item.id}">
            <input type="hidden" name="qty[]" value="${item.qty}">

            <span>${item.nama}</span>

            <div class="flex items-center gap-2">
                <button type="button" onclick="kurangItem(${i})" class="px-2 bg-red-500 text-white">-</button>
                <span>${item.qty}</span>
                <button type="button" onclick="cart[${i}].qty++; renderCart()" class="px-2 bg-green-500 text-white">+</button>
            </div>

            <span>Rp ${sub.toLocaleString()}</span>
        </div>`;
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

// SLIDE ANGGOTA
function showMember(type){
    document.getElementById('anggotaLama').classList.toggle('hidden', type!='lama');
    document.getElementById('anggotaBaru').classList.toggle('hidden', type!='baru');
}

// DURASI CHANGE
document.getElementById('durasi').addEventListener('change', ()=>{
    lamaSewa = parseInt(document.getElementById('durasi').value);
    document.getElementById('durasiHidden').value = lamaSewa;
    updateTanggalKembali();
    renderCart();
});

// TANGGAL PINJAM
document.getElementById('tglPinjam').addEventListener('change', updateTanggalKembali);

// UPDATE TANGGAL KEMBALI (FIX TIMEZONE)
function updateTanggalKembali(){
    let tgl = document.getElementById('tglPinjam').value;
    if(!tgl) return;

    let pinjam = new Date(tgl);
    pinjam.setDate(pinjam.getDate() + lamaSewa);

    // FIX timezone
    let yyyy = pinjam.getFullYear();
    let mm = String(pinjam.getMonth()+1).padStart(2,'0');
    let dd = String(pinjam.getDate()).padStart(2,'0');

    document.getElementById('tglKembali').value = `${yyyy}-${mm}-${dd}`;
}

// SET DEFAULT
window.onload = function(){
    lamaSewa = parseInt(document.getElementById('durasi').value);
    document.getElementById('durasiHidden').value = lamaSewa;
}
</script>