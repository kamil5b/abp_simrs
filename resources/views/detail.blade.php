@extends('layouts.main')

@section('body')

<section class="login-clean">
    <form>
        <h2>Medical Record</h2>
        <div class="illustration"><i class="icon ion-medkit"></i></div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Nama Pasien</h5>
            <div class="container" style="height: 25px;">
                <p>{{ $nama_pasien }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Nama Dokter</h5>
            <div class="container" style="height: 25px;">
                <p>{{ $nama_dokter }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Tanggal Record</h5>
            <div class="container"><input class="form-control" type="date" disabled readonly value={{ $tanggal }}></div>
        </div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Gejala</h5>
            <div class="container">
                <p>{{ $gejala }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Informasi tambahan</h5>
            <div class="container">
                <p>{{ $informasi }}</p>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="fw-bold" style="padding: 0px;margin: 0px 10px 8px;">Diagnosis</h5>
            <div class="container">
                <p>{{ $diagnosis }}</p>
            </div>
        </div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100"><a href="/records">Back</a></button></div>
    </form>
</section>

@endsection