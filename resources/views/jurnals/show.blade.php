@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-2xl mb-4">Detail Jurnal PKL</h1>
    <div class="mb-4">
        <strong>Tanggal:</strong>
        <p>{{ $jurnal->tanggal }}</p>
    </div>
    <div class="mb-4">
        <strong>Status Absen:</strong>
        <p>{{ $jurnal->status_absen }}</p>
    </div>
    <div class="mb-4">
        <strong>Kegiatan:</strong>
        <p>{{ $jurnal->kegiatan }}</p>
    </div>
    <div class="mb-4">
        <strong>Hasil:</strong>
        <p>{{ $jurnal->hasil }}</p>
    </div>
    <a href="{{ route('jurnals.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Kembali</a>
</div>
@endsection
