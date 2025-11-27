<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Multipleuploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    // ===========================
    // INDEX
    // ===========================
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name', 'last_name', 'email'];

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString();

        return view('admin.pelanggan.index', $data);
    }

    // ===========================
    // CREATE
    // ===========================
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email',
            'phone' => 'required|string',
            
        ]);

        Pelanggan::create($request->only(['first_name', 'last_name', 'birthday', 'gender', 'email', 'phone']));

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }

    // ===========================
    // SHOW DETAIL PELANGGAN + FILES
    // ===========================
    public function show(string $id)
    {
        $pelanggan = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    // ===========================
    // EDIT & UPDATE
    // ===========================
    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email',
            'phone' => 'required|string',
            'files.*' => 'nullable|file|max:10240' // max 10MB per file
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->only(['first_name', 'last_name', 'birthday', 'gender', 'email', 'phone']));
        // Handle multiple file upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('files', 'public');

                Multipleuploads::create([
                    'filename' => $path,
                    'ref_table' => 'pelanggan',
                    'ref_id' => $id
                ]);
            }
        }
        return redirect()->route('pelanggan.index')->with('success', 'Perubahan data berhasil');
    }

    // ===========================
    // DELETE PELANGGAN
    // ===========================
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil dihapus');
    }

    // ===========================
    // UPLOAD FILE PENDUKUNG
    // ===========================
    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240' // max 10MB per file
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('files', 'public');

                Multipleuploads::create([
                    'filename' => $path,
                    'ref_table' => 'pelanggan',
                    'ref_id' => $id
                ]);
            }
        }

        return redirect()->back()->with('success', 'File berhasil diupload');
    }

    // ===========================
    // DELETE FILE
    // ===========================
    public function deleteFile($id)
    {
        $file = Multipleuploads::findOrFail($id);
        Storage::disk('public')->delete($file->filename);
        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus');
    }
}
