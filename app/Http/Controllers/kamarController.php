<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kamar;
use App\Models\pasien;
use App\Models\orang;
use Illuminate\Database\QueryException;
class kamarController extends Controller
{

    //private $admin = true;

    public function index(){
        $user = session()->get('data');
        
        $data = [];
        $kamar = kamar::all();
        foreach($kamar as $p){
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
            'title' => 'kamar',
            'route' => 'kamar',
            'description' => 'Data seluruh kamar',
            'name' => $user->nama_lengkap,
            'sidebar_items' => [
                "Pasien" => '/pasien',
                "Karyawan" => '/karyawan',
                "Obat" => '/obat',
                "Peralatan" => '/peralatan',
            ],
            'data' => $data,
            'head' => [
                'ID','Nama Lengkap', 'Nomor HP','Tanggal Lahir', 'Kelamin', 'Alamat'
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
            'title' => 'kamar',
            'route' => 'kamar',
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
        
            kamar::create([
                'orang_id' => $orang->id
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect('/kamar/add')->withErrors("Nomor HP sudah terdaftar");
        }
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/kamar');
    }

    public function edit($id){
        $kamar = kamar::where('id', $id)->first();
        $data = orang::where('id',$kamar->orang_id)->first();
        return view('add',[
            'title' => 'kamar',
            'route' => 'kamar',
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
        $kamar = kamar::where('id', $request->id)->first();
        $orang = orang::find($kamar->orang_id);
        $orang->nama_lengkap = $request->nama_lengkap;
        $orang->nomor_hp = $request->nomor_hp;
        $orang->tanggal_lahir = $request->tanggal_lahir;
        $orang->kelamin = $request->kelamin;
        $orang->alamat = $request->alamat;
        $orang->save();
        // alihkan halaman ke halaman sebelumnya
        return redirect('/kamar');
    }

    public function delete($id){
        kamar::destroy($id);
        return redirect('/kamar');
    }

}
