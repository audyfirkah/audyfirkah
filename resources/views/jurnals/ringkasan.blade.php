@auth
@extends('layouts.app')

@section('content')
<h1 class="text-2xl mb-2 font-bold">Ringkasan Jurnal PKL</h1>

@if($ringkasan)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($ringkasan as $bulan => $dataBulan)
        <div class="bg-white p-4 rounded-2xl shadow-lg mx-auto mt-5 text-center max-w-xs w-full">
            <div class="bg-slate-800 text-gray-200 py-2 rounded-xl text-center">
                <h2 class="text-xl mb-1 font-bold">{{ $dataBulan['nama_bulan'] }}</h2>
            </div>

            <div class="my-2">
                <h3 class="text-lg font-semibold">Kehadiran</h3>
                <p class="text-green-500 text-3xl font-bold">
                    {{ number_format(($dataBulan['hadir'] / ($dataBulan['hadir'] + $dataBulan['tidak_hadir'])) * 100, 2) }}%
                </p>
            </div>
            
            <hr class="my-2">
            
            <div class="my-2">
                <h3 class="text-lg font-semibold">Total Kehadiran</h3>
                <p class="text-green-500 font-bold">{{ $dataBulan['hadir'] }} Hadir</p>
            </div>
            
            <div class="my-2">
                <h3 class="text-lg font-semibold">Total Tidak Hadir</h3>
                <p class="text-red-500 font-bold">{{ $dataBulan['tidak_hadir'] }} Tidak Hadir</p>
            </div>

            <form action="{{ route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan]) }}" method="GET">
                <button type="submit" class="bg-yellow-400 py-1 px-2 rounded-lg text-center mt-5 hover:bg-yellow-600">
                    <h2 class="text-sm font-bold">Lihat detail</h2>
                </button>
            </form>
        </div>
        @endforeach
    </div>
@else
    <p class="text-center text-gray-500 mt-10">Tidak ada data jurnal tersedia.</p>
@endif
@endsection

@else
    {{ url('/login') }}
@endauth
