<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    // Tampilkan ajuan dengan status pending
    public function pending()
    {
        $subs = DocumentSubmission::with(['masterDocument','user'])
                ->where('status', 'pending')
                ->latest()
                ->paginate(10);

        return view('admin.submissions.pending', compact('subs'));
    }

    // Form validasi
    public function edit(DocumentSubmission $submission)
    {
        return view('admin.submissions.edit', compact('submission'));
    }

    // Proses validasi
    public function update(Request $request, DocumentSubmission $submission)
    {
        $data = $request->validate([
            'status'    => 'required|in:pending,approved,rejected',
            'deskripsi' => 'nullable|string',
        ]);

        $submission->status = $data['status'];
        if ($submission->status !== 'pending' && is_null($submission->tanggal_pengesahan)) {
            $submission->tanggal_pengesahan = now();
        }
        $submission->deskripsi = $data['deskripsi'];
        $submission->save();

        return redirect()->route('admin.submissions.pending')
                         ->with('success', 'Ajuan dokumen berhasil divalidasi.');
    }
}
