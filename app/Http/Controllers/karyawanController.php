<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\karyawan;
use App\Models\orang;
use App\Models\User;
use Illuminate\Database\QueryException;

class karyawanController extends Controller
{
    public function index(){
        $User = session()->get('data');
        
        $data = [];
        $karyawan = karyawan::all();
        foreach($karyawan as $p){
            $orang = orang::where('id', $p->orang_id )->first();
            $user = User::where('id', $p->user_id )->first();
            $tmp = [
                $p->id,
                $orang->nama_lengkap,
                $orang->nomor_hp,
                $orang->tanggal_lahir,
                $orang->kelamin,
                $orang->alamat,
                $p->gaji_pokok,
                $user->role,
            ];
            array_push($data,$tmp);
        }
        //echo $data;
        $contents = [
            'title' => 'karyawan',
            'route' => 'karyawan',
            'description' => 'Data seluruh karyawan',
            'name' => $User->name,
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
                'ID','Nama Lengkap', 'Nomor HP','Tanggal Lahir', 'Kelamin', 'Alamat', 'Gaji', 'Role'
            ],
            "edit" => $User->role == "Admin",
            "no_add" => true
        ];
        /*if(self::admin == true){
            $contents["edit"] = true;
        }*/
        return view('dashboard',$contents);
    }

    public function add(){
        
        return view('add',[
            'title' => 'karyawan',
            'route' => 'karyawan',
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
                ],
                [
                    'type' => 'number',
                    'name' => 'gaji_pokok',
                    'placeholder' => 'Gaji Pokok'
                ],
                
                [
                    'type' => 'select',
                    'name' => 'role',
                    'placeholder' => 'Role',
                    'options' => [
                        'Perawat' => 'Perawat',
                        'Apoteker' => 'Apoteker',
                        'Dokter' => 'Dokter',
                        'Admin' => 'Admin'
                    ]
                ]
            ]
        ]);
    }


    public function edit($id){
        $karyawan = karyawan::where('id', $id)->first();
        $orang = orang::where('id',$karyawan->orang_id)->first();
        $User = User::where('id',$karyawan->user_id)->first();
        return view('add',[
            'title' => 'karyawan',
            'route' => 'karyawan',
            'method' => 'edit',
            'id' => $id,
            'data' => [
                [
                    'type' => 'text',
                    'name' => 'nama_lengkap',
                    'placeholder' => 'Nama Lengkap',
                    'value' => `$orang->nama_lengkap`
                ],
                
                [
                    'type' => 'date',
                    'name' => 'tanggal_lahir',
                    'placeholder' => 'Tanggal Lahir',
                    'value' => $orang->tanggal_lahir
                ],
                
                [
                    'type' => 'select',
                    'name' => 'kelamin',
                    'placeholder' => 'Kelamin',
                    'options' => [
                        'Pria' => 'Pria',
                        'Wanita' => 'Wanita'
                    ],
                    'value' => $orang->kelamin
                ],
                
                [
                    'type' => 'textarea',
                    'name' => 'alamat',
                    'placeholder' => 'Alamat',
                    'value' => `$orang->alamat`
                ],
                [
                    'type' => 'number',
                    'name' => 'gaji_pokok',
                    'placeholder' => 'Gaji Pokok',
                    'value' => $karyawan->gaji_pokok
                ],
                
                [
                    'type' => 'select',
                    'name' => 'role',
                    'placeholder' => 'Role',
                    'options' => [
                        'Perawat' => 'Perawat',
                        'Apoteker' => 'Apoteker',
                        'Dokter' => 'Dokter',
                        'Admin' => 'Admin'
                    ],
                    'value' => $User->role
                ]
            ]
        ]);
    }

    public function edit_action(Request $request){
        $karyawan = karyawan::where('id', $request->id)->first();
        $orang = orang::find($karyawan->orang_id);
        $orang->nama_lengkap = $request->nama_lengkap;
        $orang->tanggal_lahir = $request->tanggal_lahir;
        $orang->kelamin = $request->kelamin;
        $orang->alamat = $request->alamat;
        $orang->save();

        $user = User::find($karyawan->user_id);
        $user->name = $request->nama_lengkap;
        $user->role = $request->role;
        $user->save();
        // alihkan halaman ke halaman sebelumnya
        return redirect('/karyawan');
    }

    public function delete($id){
        karyawan::destroy($id);
        return redirect('/karyawan');
    }
}
