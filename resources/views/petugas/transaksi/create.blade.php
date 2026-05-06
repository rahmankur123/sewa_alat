@extends('layouts.app')
@section('title','Transaksi Baru')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

{{-- ===================== --}}
{{-- LEFT - BARANG --}}
{{-- ===================== --}}
<div class="lg:col-span-2">

    <h2 class="text-xl font-semibold mb-4 text-gray-800">
        Pilih Barang
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        @foreach($barang as $b)
        <div class="bg-white rounded-2xl shadow hover:shadow-md transition overflow-hidden">

            <div class="h-32 overflow-hidden">
                <img src="{{ asset('storage/'.$b->foto) }}"
                     class="w-full h-full object-cover hover:scale-105 transition">
            </div>

            <div class="p-3">
                <h3 class="font-semibold text-sm text-gray-800 line-clamp-1">
                    {{ $b->nama_barang }}
                </h3>

                <p class="text-xs text-indigo-600 font-medium">
                    Rp {{ number_format($b->harga_per_hari) }}/hari
                </p>

                <button onclick="addToCart({{ $b->id }}, '{{ $b->nama_barang }}', {{ $b->harga_per_hari }})"
                    class="mt-2 w-full bg-indigo-600 text-white text-xs py-1.5 rounded-lg hover:bg-indigo-700">
                    + Tambah
                </button>
            </div>

        </div>
        @endforeach

    </div>

</div>


{{-- ===================== --}}
{{-- RIGHT - KERANJANG --}}
{{-- ===================== --}}
<div class="bg-white rounded-2xl shadow p-4 h-fit sticky top-4">

    <h2 class="font-semibold text-lg mb-3 text-gray-800">
        Keranjang
    </h2>

    <form action="{{ route('petugas.transaksi.store') }}" method="POST">
        @csrf

        {{-- PILIH ANGGOTA --}}
        <div class="mb-4">
            <div class="flex gap-2 mb-2">
                <button type="button" onclick="showMember('lama')" class="px-3 py-1 bg-gray-100 rounded-lg text-xs">
                    Lama
                </button>
                <button type="button" onclick="showMember('baru')" class="px-3 py-1 bg-gray-100 rounded-lg text-xs">
                    Baru
                </button>
            </div>

            <div id="anggotaLama">
                <select name="user_id"
                    class="w-full bg-gray-50 px-3 py-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($users as $u)
                        @if($u->role == 'anggota')
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div id="anggotaBaru" class="hidden">
                <input type="email" name="email"
                    placeholder="Email anggota baru"
                    class="w-full bg-gray-50 px-3 py-2 rounded-lg text-sm">
            </div>
        </div>

        {{-- TANGGAL --}}
        <div class="mb-3">
            <label class="text-xs text-gray-500">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tglPinjam"
                class="w-full bg-gray-50 px-3 py-2 rounded-lg text-sm">
        </div>

        {{-- DURASI --}}
        <div class="mb-3">
            <label class="text-xs text-gray-500">Durasi</label>
            <select id="durasi"
                class="w-full bg-gray-50 px-3 py-2 rounded-lg text-sm">
                @for($i=1;$i<=9;$i++)
                <option value="{{ $i }}">{{ $i }} hari</option>
                @endfor
            </select>
            <input type="hidden" name="durasi" id="durasiHidden">
        </div>

        {{-- TANGGAL KEMBALI --}}
        <div class="mb-4">
            <label class="text-xs text-gray-500">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali_rencana" id="tglKembali"
                class="w-full bg-gray-50 px-3 py-2 rounded-lg text-sm">
        </div>

        {{-- CART --}}
        <div id="cartList" class="space-y-2 max-h-52 overflow-y-auto"></div>

        {{-- TOTAL --}}
        <div class="mt-4 text-lg font-semibold text-gray-800 flex justify-between">
            <span>Total</span>
            <span>Rp <span id="totalHarga">0</span></span>
        </div>

        <button class="bg-green-600 text-white w-full py-2 mt-4 rounded-lg hover:bg-green-700">
            Checkout
        </button>

    </form>

</div>

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