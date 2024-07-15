@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl mb-10 font-bold">Detail Jurnal PKL untuk {{ $namaBulan }} {{ $tahun }}</h1>
@if (auth()->user()->isAdmin())
    <form method="GET" action="{{ route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="mb-5">
        <div class="flex items-center space-x-2">
            
                <select name="user_id" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">Pilih User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $selectedUser == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
           

            <select name="tanggal" class="border border-gray-300 rounded px-3 py-2">
                <option value="">Pilih Tanggal</option>
                @for ($i = 1; $i <= Carbon\Carbon::now()->daysInMonth; $i++)
                    @php
                        $date = Carbon\Carbon::createFromDate($tahun, $bulanNumber, $i);
                    @endphp
                    <option value="{{ $date->toDateString() }}" {{ $selectedDate == $date->toDateString() ? 'selected' : '' }}>
                        {{ $date->isoFormat('D MMMM') }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        </div>
    </form>
 @endif
    @if($jurnals->isEmpty())
        <p>Kosong</p>
    @else

    @if(session('success'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 011.415 0l.007.007a1 1 0 010 1.415L11.415 12l4.355 4.355a1 1 0 01-1.415 1.415L10 13.415 5.652 17.77a1 1 0 01-1.415-1.415L8.585 12 4.23 7.652a1 1 0 011.415-1.415L10 10.585l4.348-4.348z"/></svg>
        </span>
    </div>
    @endif
    <table class="min-w-full table-fixed">
        <thead>
            <tr class="text-center bg-gray-100">
                <th class="px-4 py-2 w-1/12">No</th>
                <th class="px-4 py-2 w-2/12">Tanggal</th>
                <th class="px-4 py-2 w-2/12">Nama</th>
                <th class="px-4 py-2 w-2/12">Status Absen</th>
                <th class="px-4 py-2 w-2/12">Kegiatan</th>
                <th class="px-4 py-2 w-2/12">Hasil</th>
                @if (auth()->user()->isAdmin())
                    <th class="px-4 py-2 w-1/12">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnals as $jurnal)
            <tr class="border-b">
                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 text-center">{{ $jurnal->tanggal->format('d F Y') }}</td>
                <td class="px-4 py-2 text-center">
                    @if (auth()->user()->isAdmin())
                        {{ $jurnal->user->name ?? 'Nama Pengguna Tidak Tersedia' }}
                    @else
                        {{ auth()->user()->name }}
                    @endif
                </td>
                <td class="px-4 py-2 text-center">
                    <span class="inline-block px-3 py-1 text-sm font-semibold {{ $jurnal->status_absen == 'Hadir' ? 'text-green-800 bg-green-200' : 'text-red-800 bg-red-200' }}">
                        {{ $jurnal->status_absen }}
                    </span>
                </td>
                <td class="px-4 py-2 text-center">{{ $jurnal->kegiatan }}</td>
                <td class="px-4 py-2 text-center">
                    @if ($jurnal->hasil)
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $jurnal->hasil) }}" alt="Hasil Image" class="w-20 h-20 object-cover rounded mb-2">
                        </div>
                    @else
                        <span class="text-red-500">Belum ada hasil</span>
                    @endif
                </td>
                @if (auth()->user()->isAdmin())
                    <td class="px-4 py-2 text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a href="{{ route('jurnals.edit', $jurnal->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded">Edit</a>
                            <form action="{{ route('jurnals.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus jurnal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">Hapus</button>
                            </form>
                        </div>
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @endif
</div>
@endsection
