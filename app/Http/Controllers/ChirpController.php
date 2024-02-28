<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('chirps.index', [
            'chirps'=>chirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
      

    public function store(Request $request)
    {
      $validate=  $request->validate([
            'message'=>['required', 'min:3', 'max:255'],
        ]);
        auth()->user()->chirps()->create($validate);
     
       return to_route('chirps.index')
        ->with('status', __('Se ha creado el chirps de manera exitosa!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
      $this->authorize('update', $chirp);
        return view('chirps.edit',[
            'chirp'=>$chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        $validated=  $request->validate([
            'message'=>['required', 'min:3', 'max:255'],
        ]);
        $chirp->update($validated);
        return to_route('chirps.index')
         ->with('status', __('Chirp Update successfully!'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        $chirp->delete();
        return to_route('chirps.index')
        ->with('status', __('Chirp delete successfully!'));
    }
}
