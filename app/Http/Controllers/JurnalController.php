<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class JurnalController extends Controller
{
    //halaman index jurnal untuk mengelompokkan berdasarkan bulan
    public function index()
    {
        $jurnals = Jurnal::orderBy('tanggal', 'desc')->get();

        $ringkasan = $jurnals->groupBy(function ($item) {
            return $item->tanggal->format('Y');
        })->map(function ($yearGroup) {
            return $yearGroup->groupBy(function ($item) {
                return $item->tanggal->format('F');
            })->map(function ($monthGroup) {
                return [
                    'nama_bulan' => Carbon::createFromDate(null, $monthGroup->first()->tanggal->month)->locale('id')->monthName . ' ',
                    'hadir' => $monthGroup->where('status_absen', 'Hadir')->count(),
                    'tidak_hadir' => $monthGroup->where('status_absen', 'Tidak Hadir')->count()
                ];
            });
        });

        return view('jurnals.index', compact('ringkasan'));
    }



    //menampilkan form create
    public function create()
    {
        if (auth()->user()->status === 'admin') {
            $users = User::all();
        } else {
            $users = null;
        }

        return view('jurnals.create', compact('users'));
    }



    // Menyimpan jurnal baru ke database
    public function store(Request $request)
    {
        if (auth()->user()->status === 'admin') {
            $request->validate([
                'user_id' => 'required',
                'tanggal' => 'required|date',
                'status_absen' => 'required',
                'kegiatan' => 'required|string',
                'hasil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } else {
            $request->validate([
                'user_id' => 'required',
                'tanggal' => 'required|date|after_or_equal:' . now()->subDay()->format('Y-m-d') . '|
                                    before_or_equal:' . now()->addDay()->format('Y-m-d'),

                'status_absen' => 'required',
                'kegiatan' => 'required|string',
                'hasil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }

        $data = $request->all();

        if (auth()->user()->status === 'admin') {

            $data['user_id'] = $request->user_id;
        } else {

            $data['user_id'] = auth()->id();
        }

        if ($request->hasFile('hasil')) {
            $imagePath = $request->file('hasil')->store('images', 'public');
            $data['hasil'] = $imagePath;
        }


        Jurnal::create($data);

        $tahun =  date('Y', strtotime($request->tanggal));
        $bulan =  date('m', strtotime($request->tanggal));

        return redirect()->route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan])->with('success', 'Jurnal PKL berhasil ditambahkan.');
    }



    // Menampilkan form untuk mengedit jurnal tertentu
    public function edit(Jurnal $jurnal)
    {
        if (auth()->user()->status === 'admin' || $jurnal->user_id === auth()->id()) {
            $users = User::where('status', 'user')->get();
            return view('jurnals.edit', compact('jurnal', 'users'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }



    // Menyimpan perubahan jurnal ke database
    public function update(Request $request, Jurnal $jurnal)
    {
        if (auth()->user()->status === 'admin') {
            $request->validate([
                'user_id' => 'required',
                'tanggal' => 'required|date',
                'status_absen' => 'required',
                'kegiatan' => 'required|string',
                'hasil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } else {
            $request->validate([
                'user_id' => 'required',
                'tanggal' => 'required|date|after_or_equal:' . now()->subDay()->format('Y-m-d') . '|
                                    before_or_equal:' . now()->addDay()->format('Y-m-d'),

                'status_absen' => 'required',
                'kegiatan' => 'required|string',
                'hasil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }



        $data = $request->all();

        // Hanya admin atau pemilik jurnal yang dapat mengedit
        if (auth()->user()->status === 'admin' || $jurnal->user_id === auth()->id()) {
            if ($request->hasFile('hasil')) {
                if ($jurnal->hasil) {
                    Storage::disk('public')->delete($jurnal->hasil);
                }
                $data['hasil'] = $request->file('hasil')->store('images', 'public');
            }

            $jurnal->update($data);

            $tahun =  date('Y', strtotime($request->tanggal));
            $bulan =  date('m', strtotime($request->tanggal));

            return redirect()->route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan])
                ->with('success', 'Jurnal Berhasil di edit');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }



    // Menghapus jurnal
    public function destroy(Jurnal $jurnal)
    {
        if (auth()->user()->status === 'admin' || $jurnal->user_id === auth()->id()) {
            if ($jurnal->hasil) {
                Storage::disk('public')->delete($jurnal->hasil);
            }

            $jurnal->delete();

            $tahun =  date('Y', strtotime($jurnal->tanggal));
            $bulan =  date('m', strtotime($jurnal->tanggal));

            return redirect()->route('jurnals.detail', ['tahun' => $tahun, 'bulan' => $bulan])->with('success', 'Jurnal berhasil dihapus.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }



    // Menampilkan ringkasan jurnal berdasarkan bulan
    public function ringkasan()
    {
        $user_id = auth()->id();

        if (auth()->user()->status === 'user') {
            $jurnals = Jurnal::where('user_id', $user_id)->get();
        } else {
            $jurnals = Jurnal::all();
        }

        $ringkasan = [];

        foreach ($jurnals as $jurnal) {
            $bulan = $jurnal->tanggal->format('Y-m');
            $namaBulan = Carbon::createFromDate(null, $jurnal->tanggal->month)->locale('id')
                ->monthName . ' ' . $jurnal->tanggal->year;

            if (!isset($ringkasan[$bulan])) {
                $ringkasan[$bulan] = [
                    'nama_bulan' => $namaBulan,
                    'hadir' => 0,
                    'tidak_hadir' => 0,
                    'details' => []
                ];
            }

            if ($jurnal->status_absen == 'Hadir') {
                $ringkasan[$bulan]['hadir']++;
            } else {
                $ringkasan[$bulan]['tidak_hadir']++;
            }

            $ringkasan[$bulan]['details'][] = [
                'tanggal' => $jurnal->tanggal,
                'status_absen' => $jurnal->status_absen
            ];
        }

        // Menetapkan nilai default untuk tahun dan bulan jika $jurnal kosong
        $tahun = $jurnals->isNotEmpty() ? $jurnals->first()->tanggal->format('Y') : date('Y');
        $bulan = $jurnals->isNotEmpty() ? $jurnals->first()->tanggal->format('m') : date('m');

        return view('jurnals.ringkasan', compact('ringkasan', 'tahun', 'bulan'));
    }




    // Untuk menampilkan detail berdasarkan bulan dan tahun
    public function detail($tahun, $bulan)
    {
        $bulanNumber = is_numeric($bulan) ? $bulan : Carbon::parse($bulan)->month;

        $selectedUser = request()->input('user_id');
        $selectedDate = request()->input('tanggal');
        $users = User::where('status', 'user')->get();

        $query = Jurnal::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanNumber)
            ->orderBy('updated_at', 'desc');

        if (auth()->user()->status === 'admin') {
            if ($selectedUser) {
                $query->where('user_id', $selectedUser);
            }
        } else {
            $query->where('user_id', auth()->id());
        }

        if ($selectedDate) {
            $query->whereDate('tanggal', $selectedDate);
        }

        $jurnals = $query->get();

        $namaBulan = Carbon::createFromDate(null, $bulanNumber)->locale('id')->monthName;

        return view('jurnals.detail', compact('jurnals', 'namaBulan', 'tahun', 'bulan', 'users', 'selectedUser', 'selectedDate', 'bulanNumber'));
    }






    // untuk menghapus data perbulan di index
    public function destroyByMonth($tahun, $bulan)
    {
        $bulan = Carbon::parse($bulan)->month;
        Jurnal::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->delete();

        return redirect()->route('jurnals.index')->with('success', 'Jurnal bulan tersebut berhasil dihapus.');
    }
}
