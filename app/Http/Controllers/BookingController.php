<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
        abort(403, 'Acceso no autorizado');
        }
        
        $search = $request->input('search');
        
        $booking = Booking::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                // Buscar por patente
                $q->where('license_plate', 'like', "%{$search}%")
                
                // Buscar por nombre de usuario
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                
                // Intentar convertir la fecha si coincide con el formato de búsqueda
                ->orWhere(function ($q) use ($search) {
                    try {
                        // Intentar parsear la fecha en formato d/m/Y H:i
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $search);
                        
                        // Buscar en el formato de la base de datos (Y-m-d H:i:s)
                        $q->whereDate('scheduled_at', $date->format('Y-m-d'));
                        
                        // También buscar solo por fecha sin hora
                        $q->orWhereDate('scheduled_at', $date->format('Y-m-d'));
                        
                    } catch (\Exception $e) {
                        // Si no es una fecha válida, buscar como texto simple
                        $q->orWhere('scheduled_at', 'like', "%{$search}%");
                    }
                });
            });
        })
        ->orderBy('scheduled_at', 'desc')
        ->get();
        
        return view('admin.booking', compact('booking'));
    }

    public function create()
    {
        return view('admin.booking.create'); // Si tienes una vista específica para el formulario
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'vehiculo' => 'required|string|max:255',
            'patente' => 'required|string|max:20',
            'fecha' => 'required|date',
            'hora' => 'required|string|max:10',
            'servicio' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'estado' => 'required|string|max:100',
        ]);

        Booking::create($request->all());

        return redirect()->route('admin.booking')->with('success', 'Reserva agregada con éxito.');
    }

    public function edit(Booking $booking)
    {
        return view('admin.booking.edit', compact('booking')); // Asegúrate que esta vista exista
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'vehiculo' => 'required|string|max:255',
            'patente' => 'required|string|max:20',
            'fecha' => 'required|date',
            'hora' => 'required|string|max:10',
            'servicio' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'estado' => 'required|string|max:100',
        ]);

        $booking->update($request->all());

        return redirect()->route('admin.booking')->with('success', 'Reserva actualizada con éxito.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.booking')->with('success', 'Reserva eliminada con éxito.');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pendiente,confirmado,completado,cancelado'
        ]);
        
        $booking->update([
            'status' => $request->status
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }
}
