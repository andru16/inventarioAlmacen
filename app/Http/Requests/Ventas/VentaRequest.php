<?php

namespace App\Http\Requests\Ventas;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha_factura' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'totalFactura' => 'required|numeric',
            'listaProductos' => 'required|array',
            'listaProductos.*.id' => 'required|exists:productos,id',
            'listaProductos.*.cantidad' => 'required|integer|min:1',
            'listaProductos.*.precio' => 'required|numeric|min:0',
            'listaProductos.*.total' => 'required|numeric|min:0',
        ];
    }
}
