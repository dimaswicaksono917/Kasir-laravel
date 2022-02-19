<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexm()
    {
        $menu = Menu::paginate(7);

        return view('manager.index', compact('menu'))
        ->with('i',(request()->input('page', 1) - 1) * 7);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createm()
    {
        return view('manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|min:0',
            'deskripsi' ,
            'ketersediaan' => 'required|min:0',
        ]);
        $store= Menu::create($request->all());

        if($store){
            return redirect()->route('indexm')
            ->with('succes','Berhasil Menambah Menu !');
        }else{
            return redirect()->route('createm')
            ->with('error','Opps sepertinya ada yang salah !');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function editm($id)
    {
        $data= Menu::find($id);
        return view('manager.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function updatem(Request $request, $id)
    {
        $data= Menu::find($id);
        
        $store= $data->update($request->all());

        if($store){
            return redirect()->route('indexm')
            ->with('succes','Berhasil Mengedit !');
        }else{
            return redirect()->route('editm')
            ->with('error','Opps sepertinya ada yang salah !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroym($id)
    {
        $data= Menu::find($id);
        $delete= $data->delete();
        
        if($delete){
        return redirect()->route('indexm')
        ->with('succes','Berhasil Menghapus!');
        }else{
            return redirect()->route('indexm')
            ->with('error','Gabisa'); 
        }
    }

    public function laporan(){
        $report = Transaksi::latest()->paginate(7);

        return view('manager.laporan', compact('report'))
        ->with('i',(request()->input('page', 1) - 1) * 7);
    }
}
