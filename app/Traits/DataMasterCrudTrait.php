<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait DataMasterCrudTrait
{
    /**
     * Check if user has permission to manage data master
     */
    protected function checkDataMasterPermission()
    {
    $user = Auth::user();
    if (!$user || !($user->role && in_array($user->role->nama, ['kaprodi', 'dekan']))) {
            abort(403, 'Anda tidak memiliki akses ke menu ini.');
        }
    }

    /**
     * Display a listing of the resource
     */
    public function index()
    {
        $this->checkDataMasterPermission();
        $records = $this->model::all();
        return view($this->viewPath . '.index', [
            'records' => $records
        ]);
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $this->checkDataMasterPermission();
        return view($this->viewPath . '.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $this->checkDataMasterPermission();
        $validated = $request->validate($this->validationRules);
        $record = $this->model::create($validated);
        
        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($id)
    {
        $this->checkDataMasterPermission();
        $record = $this->model::findOrFail($id);
        return view($this->viewPath . '.edit', [
            'record' => $record
        ]);
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, $id)
    {
        $this->checkDataMasterPermission();
        $validated = $request->validate($this->validationRules);
        $record = $this->model::findOrFail($id);
        $record->update($validated);
        
        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($id)
    {
        $this->checkDataMasterPermission();
        $record = $this->model::findOrFail($id);
        $record->delete();
        
        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', 'Data berhasil dihapus');
    }
}