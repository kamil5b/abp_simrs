<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\peralatan;
use Illuminate\Database\QueryException;
class peralatanController extends Controller
{

    //private $admin = true;

    public function index(){
        $user = session()->get('data');
        
        $data = [];
        $peralatan = peralatan::all();
        foreach($peralatan as $p){
            $tmp = array($p);
            array_push($data,$tmp);
        }
        //echo $data;
        $contents = [
            'title' => 'peralatan',
            'route' => 'peralatan',
            'description' => 'Data seluruh peralatan',
            'name' => $user->nama_lengkap,
            'sidebar_items' => [
                "Pasien" => '/pasien',
                "Karyawan" => '/karyawan',
                "Obat" => '/obat',
                "Peralatan" => '/peralatan',
            ],
            'data' => $data,
            'head' => [
                'ID','Nama Peralatan', 'Kode Peralatan','Kandungan', 'Kuantitas', 'Tipe_Kuantitas','Harga'
            ],
            "edit" => true
        ];
        /*if(self::admin == true){
            $contents["edit"] = true;
        }*/
        return view('dashboard',$contents);
    }

    public function add(){
        
        return view('add',[
            'title' => 'peralatan',
            'route' => 'peralatan',
            'method' => 'add',
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_peralatan',
                    'placeholder' => 'Nama Peralatan'
                ],
                
                [
                    'type' => 'text',
                    'name' => 'kode_peralatan',
                    'placeholder' => "Kode Peralatan"
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
            peralatan::create([
                'nama_peralatan' => $request->nama_peralatan,
                'kode_peralatan' => $request->kode_peralatan,
                'kuantitas' => $request->kuantitas,
                'kandungan' => $request->kandungan,
                'tipe_kuantitas' => $request->tipe_kuantitas,
                'harga' => $request->harga
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect('/peralatan/add')->withErrors("Nomor HP sudah terdaftar");
        }
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/peralatan');
    }
/*
    public function edit($id){
        $data = peralatan::where('id', $id)->first();
        return view('add',[
            'title' => 'peralatan',
            'route' => 'peralatan',
            'method' => 'edit',
            'id' => $id,
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_peralatan',
                    'placeholder' => 'Nama Peralatan',
                    'value' => $data->nama_peralatan 
                ],
                
                [
                    'type' => 'text',
                    'name' => 'kode_peralatan',
                    'placeholder' => "Kode Peralatan",
                    'value' => $data->kode_peralatan
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
*/
    public function change_status(Request $request){
        $peralatan = peralatan::find($request->id);
        $peralatan->dipakai = !$peralatan->dipakai;
        $peralatan->save();
        // alihkan halaman ke halaman sebelumnya
        return redirect('/peralatan');
    }

    public function delete($id){
        peralatan::destroy($id);
        return redirect('/peralatan');
    }

}
