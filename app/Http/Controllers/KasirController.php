<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class KasirController extends Controller
{
    public function indexk()
    {
        $trans = Transaksi::latest()->paginate(7);

        return view('kasir.index', compact('trans'))
        ->with('i',(request()->input('page', 1) - 1) * 7);
    }

    public function createk()
    {
        $menu= Menu::all();
        return view('kasir.create', compact('menu'));
    }

    public function storek(Request $request)
    {
        $timezone = 'Asia/Jakarta';
        $date = new DateTime('now',new DateTimeZone($timezone));
        $tanggal = $date->format('y-m-d');
        $request->validate([
            'nama_pelanggan' => 'required',
            'nama_menu' => 'required',
            'jumlah' => 'required|min:1',
        ]);
        $menu= Menu::whereNamaMenu($request->nama_menu)->first();
        if(!$menu){
            return back()->with('error', 'menu tidak ada');
        }
        $store= Transaksi::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'nama_menu' => $request->nama_menu,
            'jumlah' => $request->jumlah,
            'harga' => $menu->harga,
            'total_harga' => $menu->harga * $request->jumlah,
            'nama_pegawai' => auth()->user()->nama,
            'tanggal' => $tanggal,
        ]);
        $menu->update([
            'ketersediaan' => $menu->ketersediaan - $request->jumlah,
        ]);
        if($store){
            return redirect()->route('indexk')
            ->with('succes','Berhasil menambah transaksi !');
        }else{
            return redirect()->route('createk')
            ->with('error','Opps sepertinya ada yang salah');
        }
    }

    
}
