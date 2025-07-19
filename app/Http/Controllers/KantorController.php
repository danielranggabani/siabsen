<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kantor;
use Illuminate\Http\Request;
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
        $request->validate([
            'name' => 'min:3|required',
            'lokasi' => 'required'
        ]);

        $qr_code = QrCode::format('png')->generate($request->name);
        $qrImageName = $request->id . '.png';

        // Kantor::create([
        //     'name' => $request->name,
        //     'lokasi' => $request->lokasi,
        //     'qr_code' => $qrImageName,
        // ]);

        Storage::put('public/qr/' . $qrImageName, $qr_code);

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
