<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orang;
use App\Models\karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class loginController extends Controller
{
    public function index()
    {
        return view('login');
    }
 
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nomor_hp' => ['required'],
            'password' => ['required']
        ]);
 
        if (Auth::attempt($credentials)) {
            $orang = User::where('nomor_hp', $request->nomor_hp)->first();
            $request->session()->regenerate();
            $request->session()->put('data',$orang);
            
            return redirect()->intended('/');
        }
 
        return back()->with('loginError', 'Login failed');
    }
 
    public function logout(Request $request)
    {
        Auth::logout();
 
        request()->session()->invalidate();
        $request->session()->forget('data');
        request()->session()->regenerateToken();
 
        return redirect('/');
    }

    public function register(Request $request)
    {
        if($request->password == $request->password2){
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'nomor_hp' => 'required',
                'password' => 'required',
                'role' => 'required'
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
        
            $user = User::create($validatedData);
            $orang = orang::where('nomor_hp',$request->nomor_hp)->first();
            if(orang::where('nomor_hp',$request->nomor_hp)->doesntExist()){
                $orang = orang::create([
                    'nama_lengkap' => $request->name,
                    'nomor_hp' => $request->nomor_hp,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'kelamin' => $request->kelamin,
                    'alamat' => $request->alamat
                ]);
            }
            
            karyawan::create([
                'user_id' => $user->id,
                'orang_id' => $orang->id,
                'gaji_pokok' => $request->gaji_pokok
            ]);

            return redirect('/')->with('success', 'Register success');
        }
        return redirect('/register')->with('registerError', 'Register failed');

    }
}
