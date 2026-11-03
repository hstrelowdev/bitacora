<?php

namespace App\Http\Controllers;

use App\Models\Empleo;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::with(['empleo.empresa', 'asignado'])
            ->latest('fecha_solicitud')
            ->latest('id')
            ->paginate(10);

        return view('solicitudes.index', compact('solicitudes'));
    }

    public function create()
    {
        return view('solicitudes.create', $this->opciones());
    }

    public function store(Request $request)
    {
        $datos = $this->completar($this->validar($request));
        $datos['creado_por'] = $request->user()->id;

        Solicitud::create($datos);

        return redirect()->route('solicitudes.index')->with('ok', 'Solicitud creada.');
    }

    public function edit(Solicitud $solicitud)
    {
        $solicitud->load('historial.usuario');

        return view('solicitudes.edit', $this->opciones() + ['solicitud' => $solicitud]);
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $solicitud->update($this->completar($this->validar($request), $solicitud));

        return redirect()->route('solicitudes.index')->with('ok', 'Solicitud actualizada.');
    }

    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();

        return redirect()->route('solicitudes.index')->with('ok', 'Solicitud eliminada.');
    }

    private function opciones(): array
    {
        return [
            'empleos' => Empleo::with('empresa')->orderBy('nombre')->get(),
            'usuarios' => User::orderBy('nombre')->get(),
        ];
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'empleo_id' => 'required|exists:empleos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'solicitante' => 'required|string|max:255',
            'prioridad' => ['required', Rule::in(array_keys(Solicitud::PRIORIDADES))],
            'estado' => ['required', Rule::in(array_keys(Solicitud::ESTADOS))],
            'fecha_solicitud' => 'required|date',
            'asignado_a' => 'nullable|exists:usuarios,id',
        ]);
    }

    private function completar(array $datos, ?Solicitud $solicitud = null): array
    {
        $datos['fecha_cierre'] = $datos['estado'] === 'terminada'
            ? ($solicitud?->fecha_cierre ?? now()->toDateString())
            : null;

        return $datos;
    }
}
