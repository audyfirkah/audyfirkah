@auth
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    @if (auth()->user()->isAdmin())
        <h1 class="text-2xl mb-10 font-bold">Hello Admin, Daftar Jurnal PKL</h1>
    @else
        <h1 class="text-2xl mb-10 font-bold">Hello {{ auth()->user()->name }}, Daftar Jurnal PKL Anda</h1>
    @endif

    @foreach ($ringkasan as $tahun => $bulanData)
    <div class="my-8 bg-slate-300 py-5 px-10 shadow-lg rounded-xl">
        <h2 class="text-3xl font-bold">{{ $tahun }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($bulanData as $bulan => $dataBulan)
            <div class="bg-white p-2 rounded-xl shadow-lg mt-2 text-center">
                <div class="text-gray-800 py-1 rounded-xl text-center">
                    <h2 class="text-lg mb-1 font-bold">{{ $dataBulan['nama_bulan'] }}</h2>
                </div>
            
                {{-- Tombol untuk detail --}}
                <form action="{{ route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan]) }}" method="GET">
                    <button type="submit" class="bg-yellow-400 py-1 px-2 rounded-lg text-center mt-5 hover:bg-yellow-600">
                        <h2 class="text-sm font-bold">Lihat detail</h2>
                    </button>
                </form>
                
                {{-- Tombol untuk hapus --}}
                @if (auth()->user()->isAdmin())
                <form action="{{ route('jurnals.destroyByMonth', ['tahun' => $tahun, 'bulan' => $bulan]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus semua jurnal untuk bulan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 py-1 px-2 rounded-lg text-center mt-2 hover:bg-red-600">
                        <h2 class="text-sm font-bold">Hapus</h2>
                    </button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    
    @endforeach
</div>
@endsection

@else 
{{ url('/login') }}
@endauth