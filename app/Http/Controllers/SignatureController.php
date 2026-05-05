<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    public function index()
    {
        $signatures = Signature::latest()->get();
        return view('signatures.index', compact('signatures'));
    }

    public function create()
    {
        return view('signatures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'role']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('signatures', 'public');
        }

        $data['is_active'] = false;

        Signature::create($data);

        return response()->json(['success' => 'Signature added successfully']);
    }

    public function edit(Signature $signature)
    {
        return response()->json(['signature' => $signature]);
    }

    public function update(Request $request, Signature $signature)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'role']);
        
        if ($request->hasFile('image')) {
            if ($signature->image) {
                Storage::disk('public')->delete($signature->image);
            }
            $data['image'] = $request->file('image')->store('signatures', 'public');
        }

        $signature->update($data);

        return response()->json(['success' => 'Signature updated successfully']);
    }

    public function destroy(Signature $signature)
    {
        if ($signature->image) {
            Storage::disk('public')->delete($signature->image);
        }
        $signature->delete();

        return response()->json(['success' => 'Signature deleted successfully']);
    }

    public function activate(Signature $signature)
    {
        Signature::where('is_active', true)->update(['is_active' => false]);
        $signature->update(['is_active' => true]);

        return response()->json(['success' => 'Signature activated successfully']);
    }
}
