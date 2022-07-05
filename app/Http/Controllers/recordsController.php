<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\records;
use App\Models\orang;
use App\Models\pasien;
use App\Models\User;
use Illuminate\Database\QueryException;

class recordsController extends Controller
{

    //private $admin = true;

    public function index(){
        $user = session()->get('data');
        
        $data = [];
        $records = records::all();
        /*
        if($user->role == "Dokter"){
            $records = records::where('dokter_id',$user->);
        }*/
        foreach($records as $p){
            $User = User::where('id', $p->dokter_id )->first();
            $pasien = pasien::where('id', $p->pasien_id )->first();
            $orang = orang::where('id', $pasien->orang_id )->first();
            $tmp = [
                $p->id,
                $p->tanggal,
                $user->name,
                $orang->nama_lengkap,
            ];
            array_push($data,$tmp);
        }
        //echo $data;
        $contents = [
            'title' => 'records',
            'route' => 'records',
            'description' => 'Data seluruh records',
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
                'ID','Tanggal', 'Nama Dokter','Nama Pasien'
            ],
            "edit" => $user->role == "Dokter",
            "id" => $user->id
        ];
        if($user->role != "Dokter" && $user->role != "Perawat" ){
            $contents = [
                'title' => 'records',
                'route' => 'records',
                'description' => 'Data seluruh records',
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
                    'ID','Tanggal', 'Nama Dokter','Nama Pasien'
                ],
                "edit" => $user->role == "Dokter",
                "no_add" => true,
                "id" => $user->id
            ];
        }
        /*if(self::admin == true){
            $contents["edit"] = true;
        }*/
        return view('dashboard',$contents);
    }

    public function detail(Request $request){
        
        $id = $request->id;
        $key = $request->key;

        echo "<script>console.log('Debug Objects: MASUK GATE 3:' );</script>";
        $rec = records::where('id', $id )->first();
        echo "<script>console.log('Debug Objects: MASUK DETAIL:' );</script>";
        //DECODE
        $cipher = "AES-128-CBC";
        
        $ciphertext = $rec->encode_record;
        $c = base64_decode($ciphertext);

        $digest = openssl_digest($key, 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);

        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $decrypt = openssl_decrypt($ciphertext_raw, $cipher, $digest, OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $digest, true);
        
        echo "<script>console.log('Debug Objects: MASUK DECODE 1:' );</script>";
        if (!hash_equals($hmac, $calcmac)){
            return redirect(`/records/gate/$id`);
        }
        echo "<script>console.log('Debug Objects: MASUK DECODE 2:' );</script>";
        $obj_rec = json_decode($decrypt);
        $psn = pasien::where('id',$rec->pasien_id)->first();
        $doc = User::where('id',$rec->dokter_id)->first();
        $pas = orang::where('id',$psn->orang_id)->first();
        return view('detail',[
            'nama_pasien' => $pas->nama_lengkap,
            'nama_dokter' => $doc->name,
            'tanggal' => $rec->tanggal,
            'gejala' => $obj_rec->gejala,
            'informasi' => $obj_rec->informasi,
            'diagnosis' => $obj_rec->diagnosis,
            'id' => $id
        ]);
    }

    public function gate($id){ //id user
        
        echo "<script>console.log('Debug Objects: MASUK GATE 1:' );</script>";
        return view('gate',[
            'title' => 'records',
            'route' => 'records',
            'method' => 'gate',
            'id' => $id,
        ]);
    }

    public function gate_action(Request $request){
        
        echo "<script>console.log('Debug Objects: MASUK GATE 2:' );</script>";
        $id = $request->id;
        $key = $request->key;
        echo "<script>console.log('Debug Objects: MASUK GATE 2B:' );</script>";
        // alihkan halaman ke halaman sebelumnya
        return redirect(`/records/$id/$key`);
    }

    public function add($id){ //id user
        $user = User::where('id',$id)->first();
        $data = [
                
            [
                'type' => 'text',
                'name' => 'nomor_hp',
                'placeholder' => "Nomor HP Pasien"
            ],
            [
                'type' => 'textarea',
                'name' => 'gejala',
                'placeholder' => 'Gejala'
            ],
            [
                'type' => 'textarea',
                'name' => 'informasi',
                'placeholder' => 'Informasi Tambahan'
            ],
            
            [
                'type' => 'textarea',
                'name' => 'diagnosis',
                'placeholder' => 'diagnosis'
            ],

            [
                'type' => 'password',
                'name' => 'key',
                'placeholder' => 'Key'
            ]
        ];
        if($user->role != 'Dokter'){
            $tmp = [
                [
                    'type' => 'text',
                    'name' => 'nomor_hp_doc',
                    'placeholder' => "Nomor HP Dokter"
                ],
                ...$data
            ];
            $data = $tmp;
        }
        return view('add',[
            'title' => 'records',
            'route' => 'records',
            'method' => 'add',
            'id' => $id,
            'data' => $data
        ]);
    }

    public function add_action(Request $request){
        $json_record = [
            'gejala' => $request->gejala,
            'informasi' => $request->informasi,
            'diagnosis' => $request->diagnosis,
        ];
        $orang = orang::where('nomor_hp',$request->nomor_hp)->first();
        $psn = pasien::where('orang_id',$orang->id)->first();
        $str_json = json_encode($json_record);
        $cipher = "AES-128-CBC";
        //ENCODE
        $digest = openssl_digest($request->key, 'SHA256', TRUE);
        $plaintext = $str_json;
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        // binary cipher
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $digest, OPENSSL_RAW_DATA, $iv);
        // or replace OPENSSL_RAW_DATA & $iv with 0 & bin2hex($iv) for hex cipher (eg. for transmission over internet)

        // or increase security with hashed cipher; (hex or base64 printable eg. for transmission over internet)
        $hmac = hash_hmac('sha256', $ciphertext_raw, $digest, true);
        $encrypted = base64_encode($iv . $hmac . $ciphertext_raw);
        //$encrypted = openssl_encrypt($str_json,'aes-128-cbc-hmac-sha256', $request->key);
        
        
        $id = $request->id;
        $user = User::where('id',$id)->first();
        if($user->role == "Perawat"){
            $doctor = User::where('nomor_hp',$request->nomor_hp_doc)->first();
            $id = $doctor->id;
        }
        records::create([
            'tanggal' => date('Y-m-d',time()),
            'pasien_id' => $psn->id,
            'dokter_id' => $id,
            'encode_record' => $encrypted
        ]);
        /*
        try
        {
            records::create([
                'tanggal' => date('Y-m-d',time()),
                'pasien_id' => $psn->id,
                'dokter_id' => $id,
                'encode_record' => $encrypted
            ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            $id = $request->id;
            return redirect(`/records/add/$id`);
        }*/
        
        // alihkan halaman ke halaman sebelumnya
        return redirect('/records');
    }
}