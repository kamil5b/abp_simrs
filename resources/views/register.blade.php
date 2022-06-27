@extends('layouts.main')

@section('body')


<section class="login-clean">
    <form method="post" action="/register">
        @csrf
        <h2>Admin Register</h2>
        <div class="illustration"><i class="icon ion-medkit"></i></div>
        <div class="mb-3"><input class="form-control" type="text" name="name" placeholder="Nama Lengkap"></div>
        <div class="mb-3"><input class="form-control" type="text" name="nomor_hp" placeholder="Nomor Telepon"></div>
        <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
        <div class="mb-3"><input class="form-control" type="password" name="password2" placeholder="Retry Password"></div>
        <div class="mb-3"><select class="form-select" name="kelamin">
                <optgroup label="Kelamin">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </optgroup>
            </select></div>
            
        <div class="mb-3"><input class="form-control" type="date" name="tanggal_lahir" placeholder="Tanggal Lahir"></div>
        <div class="mb-3"><textarea class="form-control" name="alamat" placeholder="Alamat" rows="3"></textarea></div>
        <div class="mb-3" id="div-gaji"><input class="form-control" type="number" id="gaji-honor" name="gaji_pokok" placeholder="Gaji Pokok"></div>
        <div class="mb-3" id="div-role">
        <select class="form-select" name="role" id="select-role">
                <option value="" selected disabled>Role</option>
                <option value="Perawat">Perawat</option>
                <option value="Apoteker">Apoteker</option>
                <option value="Dokter">Dokter</option>
                <option value="Admin">Admin</option>
            </select></div>
            
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" name="submit">Register</button></div>
        <a class="forgot" href="/">Back</a>
    </form>
</section>

@endsection