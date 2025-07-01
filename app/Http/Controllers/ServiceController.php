<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
      
        // Verifica si el usuario tiene rol admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        $services = Service::all();
        return view('admin.services', compact('services')); // Vista: resources/views/admin/services.blade.php
    
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration_minutes' => 'required|integer',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services')->with('success', 'Servicio agregado con éxito.');
    }

    public function edit(Service $service)
    {
        return view('admin.servicesEdit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration_minutes' => 'required|integer',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.services')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Servicio eliminado.');
    }

    public function showServices()
    {
        $services = Service::orderBy('price', 'asc')->get();
        
        if($services->isEmpty()) {
            // Puedes redirigir o mostrar un mensaje diferente si no hay servicios
            return view('welcome')->with('message', 'Actualmente no hay servicios disponibles');
        }
        
        return view('welcome', compact('services'));
    }

}
