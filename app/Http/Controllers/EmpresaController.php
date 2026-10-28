<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Rubro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::with('rubro')->orderBy('nombre')->paginate(10);

        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        $rubros = Rubro::where('activo', true)->orderBy('nombre')->get();

        return view('empresas.create', compact('rubros'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'rubro_id'    => 'required|exists:rubros,id',
            'nombre'      => 'required|string|max:255|unique:empresas,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Empresa::create($datos);

        return redirect()->route('empresas.index')->with('ok', 'Empresa creada.');
    }

    public function edit(Empresa $empresa)
    {
        $rubros = Rubro::where('activo', true)
            ->orWhere('id', $empresa->rubro_id)
            ->orderBy('nombre')
            ->get();

        return view('empresas.edit', compact('empresa', 'rubros'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $datos = $request->validate([
            'rubro_id'    => 'required|exists:rubros,id',
            'nombre'      => ['required', 'string', 'max:255', Rule::unique('empresas', 'nombre')->ignore($empresa)],
            'descripcion' => 'nullable|string',
        ]);

        $empresa->update($datos);

        return redirect()->route('empresas.index')->with('ok', 'Empresa actualizada.');
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->empleos()->exists()) {
            return redirect()->route('empresas.index')
                ->with('error', 'No se puede eliminar: la empresa tiene empleos asociados.');
        }

        $empresa->delete();

        return redirect()->route('empresas.index')->with('ok', 'Empresa eliminada.');
    }
}
