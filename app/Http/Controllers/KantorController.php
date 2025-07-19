<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kantor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantor = Kantor::all();

        return Inertia::render('kantor/kantor', compact('kantor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('kantor/create-kantor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // validasi jika valid
        $request->validate([
            'name' => 'min:3|required',
            'lokasi' => 'required',
        ]);

        // buat data untuk qr biar bisa di confirm
        $qr_data = (Auth::user()->id . Carbon::now()->timestamp);

        $data_ecription = encrypt($qr_data);

        //untuk keperluan name file supaya tidak ada spasi jadi saya tangkap dan slug
        $nameOri = $request->name;

        //untuk kebutuhan warna supaya pas dengan backround dan keren
        QrCode::color(0, 0, 255, 25);
        QrCode::backgroundColor(255, 0, 0);

        // jadi slug
        $name = Str::slug($nameOri);

        // buat qr code
        $qr_code = QrCode::color(250, 250, 250)->backgroundColor(18, 18, 18)->format('svg')->generate($data_ecription);
        $qrImageName = $name . '.svg';
        $qrImageNameAsli = $qrImageName;
        $count = 1;

        //supaya nama file tidak sama saya confirm dulu gak ada baru saya buat
        while (Kantor::where('qr_code', $qrImageName)->exists()) {
            $qrImageName = $count . $qrImageNameAsli;
            $count++;
        }

        $path = Storage::url('public/' . $qrImageName);

        Kantor::create([
            'name' => $request->name,
            'lokasi' => $request->lokasi,
            'qr_code' => $path,
        ]);

        // dd($qr_code);


        // Storage::disk('public')->put('public/qr', $qr_code);

        Storage::put('public/' . $qrImageName, $qr_code);

        return redirect()->route('kantor.index')->with('message', 'Berhasil Membuat Kantor');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Kantor::where('id', $id)->get();

        return Inertia::render('kantor/edit-kantor', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Kantor::where('id', $id)->firstOrFail();

        $data->update($request->all());

        return redirect()->route('kantor.index')->with('message', 'Berhasil Mengupdate Kantor');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kantor::where('id', $id)->firstOrFail();

        $data->delete();

        return redirect()->route('kantor.index')->with('message', 'Berhasil Menghapus Kantor');
    }
}
