<?php

namespace App\Http\Controllers;

use App\Models\Empleo;
use App\Models\Empresa;
use App\Models\Rubro;
use Illuminate\Http\Request;

class EmpleoController extends Controller
{
    public function index()
    {
        $empleos = Empleo::with(['empresa', 'rubro'])->latest()->paginate(10);

        return view('empleos.index', compact('empleos'));
    }

    public function create()
    {
        return view('empleos.create', [
            'empresas' => Empresa::orderBy('nombre')->get(),
            'rubros'   => Rubro::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Empleo::create($this->validar($request));

        return redirect()->route('empleos.index')->with('ok', 'Empleo creado.');
    }

    public function edit(Empleo $empleo)
    {
        return view('empleos.edit', [
            'empleo'   => $empleo,
            'empresas' => Empresa::orderBy('nombre')->get(),
            'rubros'   => Rubro::where('activo', true)
                ->orWhere('id', $empleo->rubro_id)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function update(Request $request, Empleo $empleo)
    {
        $empleo->update($this->validar($request));

        return redirect()->route('empleos.index')->with('ok', 'Empleo actualizado.');
    }

    public function destroy(Empleo $empleo)
    {
        if ($empleo->solicitudes()->exists()) {
            return redirect()->route('empleos.index')
                ->with('error', 'No se puede eliminar: el empleo tiene solicitudes asociadas.');
        }

        $empleo->delete();

        return redirect()->route('empleos.index')->with('ok', 'Empleo eliminado.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'empresa_id'  => 'required|exists:empresas,id',
            'rubro_id'    => 'required|exists:rubros,id',
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
    }
}
