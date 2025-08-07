<?php

namespace App\Http\Controllers;

use App\Models\MasterDocument;
use App\Models\DocumentSubmission;
use App\Models\MasterDokument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:rektorat']);
    }

    public function index()
    {
        $subs = DocumentSubmission::with('masterDocument')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);

        return view('submissions.index', compact('subs'));
    }

    public function create()
    {
        $docs = MasterDokument::orderBy('nomor')->get();
        return view('submissions.create', compact('docs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'master_document_id' => 'required|exists:master_documents,id',
        ]);

        DocumentSubmission::create([
            'master_document_id' => $data['master_document_id'],
            'user_id'            => Auth::id(),
        ]);

        return redirect()->route('submissions.index')
                         ->with('success', 'Dokumen berhasil diajukan.');
    }
}
