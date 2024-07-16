@auth
@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow max-w-lg mx-auto mt-10">
    <h1 class="text-2xl mb-4">Edit Jurnal PKL</h1>
    <form action="{{ route('jurnals.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Menampilkan dropdown nama hanya jika user adalah admin --}}
        @if(auth()->user()->status === 'admin')
        <div class="mb-4">
            <label for="user_id" class="block text-gray-700">Nama:</label>
            <select name="user_id" id="user_id" class="border rounded w-full py-2 px-3 @error('user_id') border-red-500 @enderror">
                @foreach($users as $user)
                    @if($user->status === 'user')
                        <option value="{{ $user->id }}" {{ $jurnal->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        @else
        {{-- Hidden input untuk user --}}
        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama:</label>
            <input type="text" id="nama" name="nama" value="{{ auth()->user()->name }}" readonly class="border rounded w-full py-2 px-3 bg-gray-100">
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        @endif

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700">Tanggal:</label>
            @php
                $today = now()->format('Y-m-d');
                $minDate = now()->subDay()->format('Y-m-d');
                $maxDate = now()->addDay()->format('Y-m-d');
            @endphp
                <input type="date" name="tanggal" id="tanggal" value="{{ $jurnal->tanggal->format('Y-m-d')}}" class="border rounded w-full py-2 px-3 @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Status Absen:</label>
            <div>
                <label class="inline-flex items-center">
                    <input type="radio" name="status_absen" value="Hadir" class="form-radio text-blue-500" {{ $jurnal->status_absen == 'Hadir' ? 'checked' : '' }}>
                    <span class="ml-2">Hadir</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="status_absen" value="Tidak Hadir" class="form-radio text-blue-500" {{ $jurnal->status_absen == 'Tidak Hadir' ? 'checked' : '' }}>
                    <span class="ml-2">Tidak Hadir</span>
                </label>
            </div>
        </div>
        <div class="mb-4">
            <label for="kegiatan" class="block text-gray-700">Kegiatan:</label>
            <textarea name="kegiatan" id="kegiatan" rows="4" class="border rounded w-full py-2 px-3 @error('kegiatan') border-red-500 @enderror">{{ $jurnal->kegiatan }}</textarea>
            @error('kegiatan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="hasil" class="block text-gray-700">Bukti Hasil (Gambar):</label>
            
            @if($jurnal->hasil)
                <img src="{{ asset('storage/' . $jurnal->hasil) }}" alt="Hasil Image" class="w-20 h-20 object-cover rounded mb-2">
            @else
                <span class="text-red-500">Belum ada hasil</span>
            @endif
            
            <input type="file" name="hasil" id="hasil" class="border rounded w-full py-2 px-3 @error('hasil') border-red-500 @enderror">
            @error('hasil')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection

@else
{{ url('/login') }}
@endauth