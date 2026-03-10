<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Store a newly uploaded document.
     */
    public function store(Request $request, CaseModel $case)
    {
        $request->validate([
            'document' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $file = $request->file('document');
            
            // Generate unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $uniqueName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            
            // Store file in storage/app/case-documents
            $filePath = $file->storeAs('case-documents', $uniqueName);
            
            // Create database record
            $document = Document::create([
                'case_id' => $case->id,
                'uploaded_by' => Auth::id(),
                'file_name' => $originalName,
                'file_path' => $filePath,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'description' => $request->description,
            ]);

            // Redirect back to where the upload was initiated from
            $redirectTo = $request->input('redirect_to', route('cases.show', $case));
            return redirect($redirectTo)
                ->with('success', 'Document uploaded successfully!');
                
        } catch (\Exception $e) {
            $redirectTo = $request->input('redirect_to', route('cases.show', $case));
            return redirect($redirectTo)
                ->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    /**
     * Download a document.
     */
    public function download(Document $document)
    {
        // Check if file exists
        if (!Storage::exists($document->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($document->file_path, $document->file_name);
    }

    /**
     * Delete a document.
     */
    public function destroy(Request $request, Document $document)
    {
        try {
            $caseId = $document->case_id;
            
            // Delete file from storage
            if (Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }
            
            // Delete database record
            $document->delete();

            // Stay on the same page
            return redirect()->back()
                ->with('success', 'Document deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete document: ' . $e->getMessage());
        }
    }
}
