<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ActivityController extends Controller
{
    public function index()
    {
      
        // Verifica si el usuario tiene rol admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
        $activity = Activity::all();
        return view('admin.activity', compact('activity')); 
    
    }

    public function wall()
    {
        $activities = Activity::orderBy('activity_date', 'desc')->get();
        return view('wall', compact('activities'));
    }

    public function create()
    {
        return view('admin.activity.create'); 
    }

    public function store(Request $request)
    {
        // validamos los datos enviados del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activity_date' => 'required|date',
        ]);

        $data = $request->all();

        // Guardar imagen
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image_path'] = $imageName; 
        }

        Activity::create($data);

        return redirect()->route('admin.activity')->with('success', 'Actividad agregada con éxito.');
    }
    public function edit(Activity $activity)
    {
        return view('admin.activityEdit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // validamos los datos enviados del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activity_date' => 'required|date',
        ]);

        if ($request->hasFile('image_path')) {
            // Eliminar imagen anterior si existe
            if ($activity->image_path) {
                $oldImagePath = public_path('images/' . $activity->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Guardar nueva imagen
            $image = $request->file('image_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $activity->image_path = $imageName;
        }

        // Actualiza otros campos
        $activity->fill($request->except('image_path'));
        $activity->save();

        return redirect()->route('admin.activity')->with('success', 'Publicación actualizada con éxito.');
    }
    public function destroy(Activity $activity)
    {
        // Eliminar imagen si existe
        if ($activity->image_path) {
            $imagePath = public_path('images/' . $activity->image_path);
            
            // Verificar si el archivo existe y eliminarlo
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $activity->delete();

        return redirect()->route('admin.activity')->with('success', 'Actividad eliminada con éxito.');
    }
    
}
