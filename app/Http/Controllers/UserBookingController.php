<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Service;

class UserBookingController extends Controller
{
    public function index()
    {   
        $booking = auth()->user()->bookings;
        $brands = Brand::all();
        $services = Service::all();
        return view('user.booking', compact('booking','brands','services')); 
    
    }

    public function create()
    {
        return view('user.booking.create'); // Si tienes una vista específica para el formulario
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'license_plate' => 'required|string|max:20',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:pendiente,confirmado,completado,cancelado',
        ]);

        // Validar que no haya una reserva en la misma fecha/hora
        $existe = Booking::where('scheduled_at', $request->scheduled_at)->exists();
        if ($existe) {
            return back()->withErrors(['scheduled_at' => 'Esta fecha y hora ya están reservadas. Elige otra.'])->withInput();
        }

        Booking::create($request->all());

        return redirect()->route('user.booking')->with('success', 'Reserva realizada con éxito.');
    }

    public function edit(Booking $booking)
    {
        return view('user.booking.edit', compact('booking')); // Asegúrate que esta vista exista
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

        return redirect()->route('user.booking')->with('success', 'Reserva actualizada con éxito.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('user.booking')->with('success', 'Reserva eliminada con éxito.');
    }
}


