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
            $cls='success';
            $capt='PAKAI';
            if($p->dipakai){
                $cls='danger';
                $capt='MENGEMBALIKAN';
            }
            $pakai = `<a href="/peralatan/pakai/$p->id"><button class='btn btn-$cls'>$capt</button></a>`;
        
            $tmp = [
                'id'=>$p->id,
                'nama_peralatan'=>$p->nama_peralatan,
                'kode_peralatan'=>$p->kode_peralatan,
                'lokasi'=>$p->lokasi,
                'dipakai'=>[
                    'id'=>$p->id,
                    'cls'=>$cls,
                    'capt'=>$capt
                ],
            ];
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
                'ID','Nama Peralatan', 'Kode Peralatan','Lokasi', 'Dipakai'
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
                    'type' => 'text',
                    'name' => 'lokasi',
                    'placeholder' => 'Lokasi'
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
                'lokasi' => $request->lokasi,
                'dipakai' => false,
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect('/peralatan/add')->withErrors("Nomor HP sudah terdaftar");
        }
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/peralatan');
    }
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
                    'type' => 'text',
                    'name' => 'lokasi',
                    'placeholder' => 'Lokasi',
                    'value' => $data->lokasi
                ],
            ]
        ]);
    }
    public function change_status($id){
        $peralatan = peralatan::find($id);
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
