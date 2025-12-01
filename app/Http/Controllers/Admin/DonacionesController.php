<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donaciones;
use App\Models\User;
use Illuminate\Http\Request;

class DonacionesController extends Controller
{
    /**
     * Lista de todas las donaciones económicas y de bienes
     */
    public function index()
    {
        $donaciones = Donaciones::orderByDesc('id')
            ->paginate(20);

        $totalMonto = Donaciones::where('tipo_donacion', 'Efectivo')
            ->sum('monto');

        return view('admin.donaciones.index', compact('donaciones', 'totalMonto'));
    }

    /**
     * Ver detalle de una donación
     */
    public function show($id)
    {
        $donacion = Donaciones::findOrFail($id);
        return view('admin.donaciones.show', compact('donacion'));
    }

    /**
     * Formulario para registrar donación presencial (bienes o efectivo)
     */
    public function createPresencial()
    {
        return view('admin.donaciones.presencial');
    }

    /**
     * Guardar donación presencial
     */
    public function storePresencial(Request $request)
    {
        $data = $request->validate([
            'tipo_donacion'     => ['required', 'in:Efectivo,Alimentos,Medicinas,Otros'],
            'email_donante'     => ['nullable', 'email'],
            'nombre_donante'    => ['required', 'string', 'max:150'],
            'telefono'          => ['nullable', 'string', 'max:20'],
            'monto'             => ['required_if:tipo_donacion,Efectivo', 'nullable', 'numeric', 'min:0'],
            'tipo_bien'         => ['required_unless:tipo_donacion,Efectivo', 'nullable', 'string'],
            'descripcion'       => ['nullable', 'string'],
            'valor_estimado'    => ['nullable', 'numeric', 'min:0'],
            'observaciones'     => ['nullable', 'string'],
        ]);

        Donaciones::create([
            'donante_nombre'   => $data['nombre_donante'],
            'donante_email'    => $data['email_donante'],
            'donante_telefono' => $data['telefono'],
            'tipo_donacion'    => $data['tipo_donacion'],
            'tipo_bien'        => $data['tipo_bien'] ?? null,
            'monto'            => $data['monto'] ?? 0,
            'valor_estimado'   => $data['valor_estimado'],
            'descripcion'      => $data['descripcion'],
            'tipo_registro'    => 'presencial',
            'estado'           => 'Recibida',
            'fecha_donacion'   => now(),
            'comentarios'      => $data['observaciones'],
        ]);

        return redirect()->route('admin.donaciones.index')
            ->with('ok', 'Donación presencial registrada exitosamente.');
    }

    /**
     * Verificar donación (confirmar que el pago llegó)
     */
    public function verificar($id)
    {
        $donacion = Donaciones::findOrFail($id);
        
        $donacion->update([
            'estado' => 'Verificada',
        ]);

        return redirect()->route('admin.donaciones.index')
            ->with('ok', 'Donación verificada exitosamente.');
    }
}
