<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\orang;
use Illuminate\Database\QueryException;
class pasienController extends Controller
{

    //private $admin = true;

    public function APIGet(){
        $data = [];
        $pasien = pasien::all();
        foreach($pasien as $p){
            $orang = orang::where('id', $p->orang_id )->first();
            $tmp = [
                "id" => $p->id,
                "nama_lengkap" => $orang->nama_lengkap,
                "nomor_hp" => $orang->nomor_hp,
                "tanggal_lahir" => $orang->tanggal_lahir,
                "kelamin" => $orang->kelamin,
                "alamat" => $orang->alamat
            ];
            array_push($data,$tmp);
        }
        return $data;
    }

    public function index(){
        $user = session()->get('data');
        
        $data = [];
        $pasien = pasien::all();
        foreach($pasien as $p){
            $orang = orang::where('id', $p->orang_id )->first();
            $tmp = [
                $p->id,
                $orang->nama_lengkap,
                $orang->nomor_hp,
                $orang->tanggal_lahir,
                $orang->kelamin,
                $orang->alamat
            ];
            array_push($data,$tmp);
        }
        //echo $data;
        $contents = [
            'title' => 'Pasien',
            'route' => 'pasien',
            'description' => 'Data seluruh pasien',
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
                'ID','Nama Lengkap', 'Nomor HP','Tanggal Lahir', 'Kelamin', 'Alamat'
            ],
            "edit" => $user->role == "Admin" || $user->role == "Perawat",
            "no_add" => $user->role == "Admin" || $user->role == "Perawat"
        ];
        /*if(self::admin == true){
            $contents["edit"] = true;
        }*/
        return view('dashboard',$contents);
    }

    public function add(){
        
        return view('add',[
            'title' => 'Pasien',
            'route' => 'pasien',
            'method' => 'add',
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_lengkap',
                    'placeholder' => 'Nama Lengkap'
                ],
                
                [
                    'type' => 'text',
                    'name' => 'nomor_hp',
                    'placeholder' => "NomorHP"
                ],
                
                [
                    'type' => 'date',
                    'name' => 'tanggal_lahir',
                    'placeholder' => 'Tanggal Lahir'
                ],
                
                [
                    'type' => 'select',
                    'name' => 'kelamin',
                    'placeholder' => 'Kelamin',
                    'options' => [
                        'Pria' => 'Pria',
                        'Wanita' => 'Wanita'
                    ]
                ],
                
                [
                    'type' => 'textarea',
                    'name' => 'alamat',
                    'placeholder' => 'Alamat'
                ]
            ]
        ]);
    }

    public function add_action(Request $request){
        try
        {
            $orang = orang::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_hp' => $request->nomor_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kelamin' => $request->kelamin,
                'alamat' => $request->alamat
            ]);
        
            pasien::create([
                'orang_id' => $orang->id
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect('/pasien/add')->withErrors("Nomor HP sudah terdaftar");
        }
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/pasien');
    }

    public function edit($id){
        $pasien = pasien::where('id', $id)->first();
        $data = orang::where('id',$pasien->orang_id)->first();
        return view('add',[
            'title' => 'Pasien',
            'route' => 'pasien',
            'method' => 'edit',
            'id' => $id,
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_lengkap',
                    'placeholder' => 'Nama Lengkap',
                    'value' => $data->nama_lengkap
                ],
                
                [
                    'type' => 'text',
                    'name' => 'nomor_hp',
                    'placeholder' => "NomorHP",
                    'value' => $data->nomor_hp
                ],
                
                [
                    'type' => 'date',
                    'name' => 'tanggal_lahir',
                    'placeholder' => 'Tanggal Lahir',
                    'value' => $data->tanggal_lahir
                ],
                
                [
                    'type' => 'select',
                    'name' => 'kelamin',
                    'placeholder' => 'Kelamin',
                    'options' => [
                        'Pria' => 'Pria',
                        'Wanita' => 'Wanita'
                    ],
                    'value' => $data->kelamin
                ],
                
                [
                    'type' => 'textarea',
                    'name' => 'alamat',
                    'placeholder' => 'Alamat',
                    'value' => $data->alamat
                ]
            ]
        ]);
    }

    public function edit_action(Request $request){
        $pasien = pasien::where('id', $request->id)->first();
        $orang = orang::find($pasien->orang_id);
        $orang->nama_lengkap = $request->nama_lengkap;
        $orang->nomor_hp = $request->nomor_hp;
        $orang->tanggal_lahir = $request->tanggal_lahir;
        $orang->kelamin = $request->kelamin;
        $orang->alamat = $request->alamat;
        $orang->save();
        // alihkan halaman ke halaman sebelumnya
        return redirect('/pasien');
    }

    public function delete($id){
        pasien::destroy($id);
        return redirect('/pasien');
    }

}
