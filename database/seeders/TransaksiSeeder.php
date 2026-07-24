<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Kerusakan;
use App\Models\Keterlambatan;
use App\Models\BarangHilang;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Support\Facades\Schema; // <-- Tambahkan ini
use Carbon\Carbon;
class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        BarangHilang::truncate();
        Kerusakan::truncate();
        Keterlambatan::truncate();
        DetailTransaksi::truncate();
        Transaksi::truncate();

        Schema::enableForeignKeyConstraints();

        $users = User::where('role','anggota')->get();
        $barangs = Barang::all();

        if($users->isEmpty() || $barangs->isEmpty()){
            return;
        }

        $statusList = array_merge(
            array_fill(0,6,'tersewa'),
            array_fill(0,8,'dipinjam'),
            array_fill(0,10,'selesai'),
            array_fill(0,6,'terdenda'),
        );

        shuffle($statusList);

        $start = Carbon::create(2026,5,28);
        $end   = Carbon::create(2026,6,19);

        for($i=1;$i<=30;$i++){

            $user = $users->random();

            $tanggalPinjam = Carbon::createFromTimestamp(
                rand($start->timestamp,$end->timestamp)
            );

            $durasi = rand(1,5);

            $tanggalKembali = $tanggalPinjam->copy()->addDays($durasi);

            $status = $statusList[$i-1];

            $tanggalReal = null;

            if($status == 'selesai'){
                $tanggalReal = $tanggalKembali->copy()->addDays(rand(0,1));
            }

            if($status == 'terdenda'){
                $tanggalReal = $tanggalKembali->copy()->addDays(rand(2,6));
            }

            $transaksi = Transaksi::create([
                'user_id'=>$user->id,
                'tanggal_pinjam'=>$tanggalPinjam,
                'tanggal_kembali_rencana'=>$tanggalKembali,
                'tanggal_kembali_real'=>$tanggalReal,
                'total_harga'=>0,
                'status_pembayaran'=>'lunas',
                'status_transaksi'=>$status,
            ]);

            $jumlahBarang = rand(1,3);

            $barangDipilih = $barangs->random($jumlahBarang);

            $total = 0;

            foreach($barangDipilih as $barang){

                $qty = rand(1,2);

                $subtotal =
                    $barang->harga_per_hari *
                    $qty *
                    $durasi;

                DetailTransaksi::create([
                    'transaksi_id'=>$transaksi->id,
                    'barang_id'=>$barang->id,
                    'qty'=>$qty,
                    'harga_per_hari'=>$barang->harga_per_hari,
                    'subtotal'=>$subtotal,
                ]);

                $total += $subtotal;
            }

            $transaksi->update([
                'total_harga'=>$total
            ]);
        }
    }
}