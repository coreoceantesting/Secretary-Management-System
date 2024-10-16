<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectionDocumentHistory;
use Illuminate\Support\Facades\Auth;

class ElectionDocumentHistoryController extends Controller
{
    public function index()
    {
        $electionDocumentHistory = ElectionDocumentHistory::with(['user'])->get();

        return view('election.document-history.index')->with([
            'electionDocumentHistory' => $electionDocumentHistory
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('upload_files')) {
                $request['upload_file'] = $request->upload_files->store('election/document');
            }

            $request['created_by'] = Auth::user()->id;

            ElectionDocumentHistory::create($request->all());

            return response()->json([
                'success' => 'Document uploaded successfully'
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $document = ElectionDocumentHistory::find($id);
            $document->deleted_by = Auth::user()->id;
            $document->deleted_at = now();
            $document->save();

            return response()->json([
                'success' => 'Document delete successfully'
            ]);
        }
    }
}
