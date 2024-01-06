<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('chirps.index', [
           //'chirps' => Chirp::orderBy('created_at', 'desc')->get()
           'chirps' => Chirp::with('user')
           ->latest()//es lo mismo que ordenar por fecha
           ->get() 

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
        $validated =  $request ->validate([
            'mensaje'=>['required', 'min:3', 'max:255']
        ]);
        
         // de aca a la base de datos
        $request->user()->chirps()->create($validated);


              return to_route('chirps.index')
              ->with('status', __('Chirp created successfully!'));
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
    public function edit(Chirp $chirp) //al colocar el Chirp como definción laravel lo busca automaticamente o retorna el ID buscado
    {
        $this->authorize('update', $chirp);

       return view('chirps.edit', ['chirp'=>$chirp]);//
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        $validated =  $request ->validate([
            'mensaje'=>['required', 'min:3', 'max:255']
        ]);
        $chirp->update($validated);
        return to_route('chirps.index') ->with('status', __('Chirp updated successfully!'));
       //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {

        $this->authorize('delete', $chirp);
        $chirp->delete();

        return to_route('chirps.index') ->with('status', __('Chirp deleted successfully!')); 

    }
}

