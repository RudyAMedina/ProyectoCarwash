<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {

        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        // Agrupar usuarios por año y mes (últimos 6 meses)
        $userCountsRaw = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->where('created_at', '<=', now()->endOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create($item->year, $item->month)->format('F') => $item->count];
        });

        // Agrupar reservas por año y mes
        $reservaCountsRaw = Booking::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->where('created_at', '<=', now()->endOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create($item->year, $item->month)->format('F') => $item->count];
        });

        // Nombres de los meses para los últimos 6 meses
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('F');
        })->reverse()->values();

        // Rellenar con 0 los meses sin datos para usuarios
        $userCounts = $months->mapWithKeys(function ($month) use ($userCountsRaw) {
            return [$month => $userCountsRaw->get($month, 0)];
        });

        $reservaCounts = $months->mapWithKeys(function ($month) use ($reservaCountsRaw) {
            return [$month => $reservaCountsRaw->get($month, 0)];
        });       

        return view('admin.dashboardAdmin', compact('userCounts', 'reservaCounts', 'months'));    
    }
}
