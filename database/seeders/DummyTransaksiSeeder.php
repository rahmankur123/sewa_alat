<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keterlambatan;
use App\Models\Kerusakan;
use App\Models\BarangHilang;

class DummyTransaksiSeeder extends Seeder
{
    public function run(): void
    {

        $users =
            User::where('role','anggota')->get();

        $barang =
            Barang::all();

        $statusList = [
            'tersewa',
            'dipinjam',
            'selesai',
            'terdenda'
        ];

        for($i=1; $i<=50; $i++){

            $user =
                $users->random();

            $status =
                $statusList[array_rand($statusList)];

            $tglPinjam =
                now()->subDays(rand(1,20));

            $durasi =
                rand(1,5);

            $tglKembali =
                (clone $tglPinjam)
                ->addDays($durasi);

            $transaksi = Transaksi::create([

                'user_id' =>
                    $user->id,

                'tanggal_pinjam' =>
                    $tglPinjam,

                'tanggal_kembali_rencana' =>
                    $tglKembali,

                'tanggal_kembali_real' =>
                    in_array($status,['selesai','terdenda'])
                    ? now()
                    : null,

                'total_harga' => 0,

                'total_denda' => 0,

                'status_transaksi' =>
                    $status,

                'status_pembayaran' =>
                    rand(0,1)
                    ? 'lunas'
                    : 'belum_bayar',

            ]);

            $pilihBarang =
                $barang->random(rand(1,2));

            $total = 0;
            $denda = 0;

            foreach($pilihBarang as $b){

                $qty =
                    rand(1,2);

                $subtotal =
                    $b->harga_per_hari *
                    $qty *
                    $durasi;

                $total += $subtotal;

                DetailTransaksi::create([

                    'transaksi_id' =>
                        $transaksi->id,

                    'barang_id' =>
                        $b->id,

                    'qty' =>
                        $qty,

                    'harga_per_hari' =>
                        $b->harga_per_hari,

                    'subtotal' =>
                        $subtotal,

                ]);

                // DENDA
                if($status == 'terdenda'){

                    // KETERLAMBATAN
                    if(rand(0,1)){

                        $hari =
                            rand(1,7);

                        $totalDenda =
                            $hari *
                            $b->denda_keterlambatan_per_hari;

                        Keterlambatan::create([

                            'transaksi_id' =>
                                $transaksi->id,

                            'barang_id' =>
                                $b->id,

                            'qty' => 1,

                            'durasi_hari' =>
                                $hari,

                            'total_denda' =>
                                $totalDenda,

                        ]);

                        $denda +=
                            $totalDenda;

                    }

                    // KERUSAKAN
                    if(rand(0,1)){

                        $jenis =
                            rand(0,1)
                            ? 'ringan'
                            : 'berat';

                        $nilai =
                            $jenis == 'ringan'
                            ? $b->denda_kerusakan
                            : $b->denda_kerusakan * 2;

                        Kerusakan::create([

                            'transaksi_id' =>
                                $transaksi->id,

                            'barang_id' =>
                                $b->id,

                            'qty' => 1,

                            'jenis_kerusakan' =>
                                $jenis,

                            'total_denda' =>
                                $nilai,

                        ]);

                        $denda +=
                            $nilai;

                    }

                    // HILANG
                    if(rand(1,10) <= 2){

                        BarangHilang::create([

                            'transaksi_id' =>
                                $transaksi->id,

                            'barang_id' =>
                                $b->id,

                            'qty' => 1,

                            'denda' =>
                                $b->denda_hilang,

                        ]);

                        $denda +=
                            $b->denda_hilang;

                    }

                }

            }

            $transaksi->update([

                'total_harga' =>
                    $total,

                'total_denda' =>
                    $denda,

            ]);

        }

    }
}