<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GraficoController extends Controller
{
    //
    public function getData(Request $request)
    {
        $validator = Validator::make($request->all(), [
        "fechaDesde" => "required|date",
        "fechaHasta" => "required|date",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' =>$validator->errors(),
            ], 422);
        }

        $fecha1 = strtotime($request->input("fechaDesde"));
        $fecha2 = strtotime($request->input("fechaHasta"));

        if($fecha1<$fecha2)
        {
            $data = DB::select(" SELECT MAX(valorIndicador) as max,date_format(fechaIndicador, '%m-%Y') as date FROM indicador
            WHERE fechaIndicador BETWEEN '".$request->input("fechaDesde")."' AND '".$request->input("fechaHasta")."'
            group BY date_format(fechaIndicador, '%m-%Y') ");

            return $data;
        }
        else{
            return response()->json([
                'error' => 'Error en Rango de Fechas',
            ], 422);
        }
    }
}
