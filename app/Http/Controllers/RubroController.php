<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RubroController extends Controller
{
    public function index()
    {
        $rubros = Rubro::orderBy('nombre')->paginate(10);

        return view('rubros.index', compact('rubros'));
    }

    public function create()
    {
        return view('rubros.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100|unique:rubros,nombre',
        ]);
        $datos['activo'] = $request->boolean('activo');

        Rubro::create($datos);

        return redirect()->route('rubros.index')->with('ok', 'Rubro creado.');
    }

    public function edit(Rubro $rubro)
    {
        return view('rubros.edit', compact('rubro'));
    }

    public function update(Request $request, Rubro $rubro)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('rubros', 'nombre')->ignore($rubro)],
        ]);
        $datos['activo'] = $request->boolean('activo');

        $rubro->update($datos);

        return redirect()->route('rubros.index')->with('ok', 'Rubro actualizado.');
    }

    public function destroy(Rubro $rubro)
    {
        if ($rubro->empresas()->exists() || $rubro->empleos()->exists()) {
            return redirect()->route('rubros.index')
                ->with('error', 'No se puede eliminar: hay empresas o empleos que usan este rubro. Desactívalo en su lugar.');
        }

        $rubro->delete();

        return redirect()->route('rubros.index')->with('ok', 'Rubro eliminado.');
    }
}
