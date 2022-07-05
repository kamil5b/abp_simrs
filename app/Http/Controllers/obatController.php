<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\obat;
use Illuminate\Database\QueryException;
class obatController extends Controller
{

    //private $admin = true;

    public function index(){
        $user = session()->get('data');
        
        $data = [];
        $obat = obat::all();
        foreach($obat as $p){
            $tmp = [
                'id'=>$p->id,
                'nama_obat'=>$p->nama_obat,
                'kode_obat'=>$p->kode_obat,
                'kandungan'=>$p->kandungan,
                'kuantitas'=>$p->kuantitas,
                'tipe_kuantitas'=>$p->tipe_kuantitas,
                'harga'=>$p->harga
            ];
            array_push($data,$tmp);
        }
        $contents = [
            'title' => 'obat',
            'route' => 'obat',
            'description' => 'Data seluruh obat',
            'name' =>$user->name,
            'sidebar_items' => [
                "Pasien" => '/pasien',
                "Karyawan" => '/karyawan',
                "Obat" => '/obat',
                "Peralatan" => '/peralatan',
                "Kamar" => '/kamar',
                "Medical Record" => '/records'
            ],
            'data' => $data,
            'head' => [
                'ID','Nama Obat', 'Kode Obat','Kandungan', 'Kuantitas', 'Tipe_Kuantitas','Harga'
            ],
            "edit" =>false,
            'no_add'=>true
        ];
        if($user->role == "Apoteker"){
            $contents = [
                'title' => 'obat',
                'route' => 'obat',
                'description' => 'Data seluruh obat',
                'name' => $user->name,
                'sidebar_items' => [
                    "Pasien" => '/pasien',
                    "Karyawan" => '/karyawan',
                    "Obat" => '/obat',
                    "Peralatan" => '/peralatan',
                    "Kamar" => '/kamar',
                    "Medical Record" => '/records'
                ],
                'data' => $data,
                'head' => [
                    'ID','Nama Obat', 'Kode Obat','Kandungan', 'Kuantitas', 'Tipe_Kuantitas','Harga'
                ],
                'edit' => true,
            ];
        }
        /*if(self::admin == true){
            $contents["edit"] = true;
        }*/
        return view('dashboard',$contents);
    }

    public function add(){
        
        return view('add',[
            'title' => 'obat',
            'route' => 'obat',
            'method' => 'add',
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_obat',
                    'placeholder' => 'Nama Obat'
                ],
                
                [
                    'type' => 'text',
                    'name' => 'kode_obat',
                    'placeholder' => "Kode Obat"
                ],
                
                [
                    'type' => 'textarea',
                    'name' => 'kandungan',
                    'placeholder' => 'Kandungan'
                ],
                [
                    'type' => 'number',
                    'name' => 'kuantitas',
                    'placeholder' => 'Kuantitas'
                ],
                
                [
                    'type' => 'text',
                    'name' => 'tipe_kuantitas',
                    'placeholder' => 'Tipe Kuantitas'
                ],
                
                [
                    'type' => 'number',
                    'name' => 'harga',
                    'placeholder' => 'Harga'
                ],
                
            ]
        ]);
    }

    public function add_action(Request $request){
        try
        {
            obat::create([
                'nama_obat' => $request->nama_obat,
                'kode_obat' => $request->kode_obat,
                'kuantitas' => $request->kuantitas,
                'kandungan' => $request->kandungan,
                'tipe_kuantitas' => $request->tipe_kuantitas,
                'harga' => $request->harga
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect('/obat/add')->withErrors("Nomor HP sudah terdaftar");
        }
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/obat');
    }

    public function edit($id){
        $data = obat::where('id', $id)->first();
        return view('add',[
            'title' => 'obat',
            'route' => 'obat',
            'method' => 'edit',
            'id' => $id,
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_obat',
                    'placeholder' => 'Nama Obat',
                    'value' => $data->nama_obat 
                ],
                
                [
                    'type' => 'text',
                    'name' => 'kode_obat',
                    'placeholder' => "Kode Obat",
                    'value' => $data->kode_obat
                ],
                
                [
                    'type' => 'textarea',
                    'name' => 'kandungan',
                    'placeholder' => 'Kandungan',
                    'value' => $data->kandungan 
                ],
                [
                    'type' => 'number',
                    'name' => 'kuantitas',
                    'placeholder' => 'Kuantitas',
                    'value' => $data->kuantitas 
                ],
                
                [
                    'type' => 'text',
                    'name' => 'tipe_kuantitas',
                    'placeholder' => 'Tipe Kuantitas',
                    'value' => $data->tipe_kuantitas 
                ],
                
                [
                    'type' => 'number',
                    'name' => 'harga',
                    'placeholder' => 'Harga',
                    'value' => $data->harga 
                ],
            ]
        ]);
    }

    public function edit_action(Request $request){
        $obat = obat::find($request->id);
        $obat->nama_obat = $request->nama_obat;
        $obat->kode_obat = $request->kode_obat;
        $obat->kuantitas = $request->kuantitas;
        $obat->kandungan = $request->kandungan;
        $obat->tipe_kuantitas = $request->tipe_kuantitas;
        $obat->harga = $request->harga;
        $obat->save();
        // alihkan halaman ke halaman sebelumnya
        return redirect('/obat');
    }

    public function delete($id){
        obat::destroy($id);
        return redirect('/obat');
    }

}
