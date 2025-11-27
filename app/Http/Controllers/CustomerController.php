<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Multipleuploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    // Detail customer
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        // Ambil file milik customer
        $customer->files = Multipleuploads::where('ref_table', 'pelanggan')
            ->where('ref_id', $id)
            ->get();

        return view('customers.detail', compact('customer'));
    }

    // Upload file pendukung
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
                    'ref_table' => $request->ref_table,
                    'ref_id' => $request->ref_id
                ]);
            }
        }

        return redirect()->back()->with('success', 'File berhasil diupload');
    }

    // Hapus file
    public function deleteFile($fileId)
    {
        $file = Multipleuploads::findOrFail($fileId);
        if (Storage::disk('public')->exists($file->filename)) {
            Storage::disk('public')->delete($file->filename);
        }
        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus');
    }
}
