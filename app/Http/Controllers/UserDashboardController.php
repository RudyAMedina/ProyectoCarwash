<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Service;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function dashboard()
    {

        if (!auth()->check() || auth()->user()->role !== 'cliente') {
            abort(403, 'Acceso no autorizado');
        }
        

    return view('user.dashboardUser');    
    }

    public function index()
    {   
        
        $booking = auth()->user()->bookings;
        $brands = Brand::all();
        $services = Service::all();
        return view('user.dashboardUser', compact('booking','brands','services')); 
    
    }
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('user.dashboardUser')->with('success', 'Reserva cancelada con éxito.');
    }
}
