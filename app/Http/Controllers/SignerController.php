<?php

namespace App\Http\Controllers;

use App\Models\Signer;
use Illuminate\Http\Request;

class SignerController extends Controller
{
    public function index()
    {
        $signers = Signer::latest()
            ->paginate(10);

        return view(
            'signers.index',
            compact('signers')
        );
    }

    public function create()
    {
        return view('signers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'position' => [
                'nullable',
                'string',
                'max:255',
            ],
            'organization' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        Signer::create($validated);

        return redirect()
            ->route('admin.signers.index')
            ->with(
                'success',
                'Penandatangan berjaya ditambah.'
            );
    }

    public function show(Signer $signer)
    {
        return view(
            'signers.show',
            compact('signer')
        );
    }

    public function edit(Signer $signer)
    {
        return view(
            'signers.edit',
            compact('signer')
        );
    }

    public function update(
        Request $request,
        Signer $signer
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'position' => [
                'nullable',
                'string',
                'max:255',
            ],
            'organization' => [
                'nullable',
                'string',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        $signer->update($validated);

        return redirect()
            ->route('admin.signers.index')
            ->with(
                'success',
                'Maklumat penandatangan berjaya dikemaskini.'
            );
    }

    public function toggleStatus(Signer $signer)
    {
        $signer->update([
            'is_active' => !$signer->is_active,
        ]);

        $message = $signer->is_active
            ? 'Penandatangan berjaya diaktifkan.'
            : 'Penandatangan berjaya dinyahaktifkan.';

        return redirect()
            ->route('admin.signers.index')
            ->with(
                'success',
                $message
            );
    }

    public function destroy(Signer $signer)
    {
        $signer->update([
            'is_active' => false,
        ]);

        $signer->delete();

        return redirect()
            ->route('admin.signers.index')
            ->with(
                'success',
                'Penandatangan berjaya dipadam.'
            );
    }
}