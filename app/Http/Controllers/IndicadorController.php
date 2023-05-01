<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Indicador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "nombreIndicador" => "required",
            "codigoIndicador" => "required",
            "unidadMedidaIndicador" => "required",
            "valorIndicador" => "required",
            "fechaIndicador" => "required|date",
            "tiempoIndicador" => "required|date",
            //"origenIndicador" => "required|url"
            "origenIndicador" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' =>$validator->errors(),
            ], 422);
        }

            Indicador::create([
            "nombreIndicador" => $request->input('nombreIndicador'),
            "codigoIndicador" => $request->input('codigoIndicador'),
            "unidadMedidaIndicador" => $request->input('unidadMedidaIndicador'),
            "valorIndicador" => $request->input('valorIndicador'),
            "fechaIndicador" => $request->input('fechaIndicador'),
            "tiempoIndicador" => $request->input('tiempoIndicador'),
            //"origenIndicador" => "required|url"
            "origenIndicador" => $request->input('origenIndicador')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "nombreIndicador" => "required",
            "codigoIndicador" => "required",
            "unidadMedidaIndicador" => "required",
            "valorIndicador" => "required",
            "fechaIndicador" => "required|date",
            "tiempoIndicador" => "required|date",
            //"origenIndicador" => "required|url"
            "origenIndicador" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' =>$validator->errors(),
            ], 422);
        }

            Indicador::where("id",$id)
            ->update([
            "nombreIndicador" => $request->input('nombreIndicador'),
            "codigoIndicador" => $request->input('codigoIndicador'),
            "unidadMedidaIndicador" => $request->input('unidadMedidaIndicador'),
            "valorIndicador" => $request->input('valorIndicador'),
            "fechaIndicador" => $request->input('fechaIndicador'),
            "tiempoIndicador" => $request->input('tiempoIndicador'),
            //"origenIndicador" => "required|url"
            "origenIndicador" => $request->input('origenIndicador')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Indicador::where('id', $id)->delete();
        return true;
    }

    public function getIndicador()
    {
        $token = self::getToken();
        if($token)
        {
            $data = self::getData($token);
            if(count($data))
            {
                $result = self::procesarData($data,"UF");
                if($result)
                {
                    $count = self::insertMasivo($result);
                    if($count>0)
                    {
                        echo "se insertaron ".$count. " filas";
                    }
                    else
                    {
                        echo $count;
                    }
                }
            }
            else{
                echo "Error al traer datos";
            }

        }
        else{
            echo "Error al crear token";
        }
    }


    public function getToken()
    {
        $url        = "https://postulaciones.solutoria.cl/api/acceso";
        $header     =  [
                        "Content-Type"=>"application/json"
                        ];
        $type       = "post";
        $post       =  [
                        "userName"=> "sebastiancordova4_hcb@indeedemail.com",
                        "flagJson"=> true
                        ];
        $result= curl($url,$header,$type,$post);
        if($result["code"]==200)
        {
            return $result["body"]["token"];
        }
        else
        {
            return false;
        }
    }


    public function getData($token)
    {
        $url        = "https://postulaciones.solutoria.cl/api/indicadores";
        $header     =  [
                        "Content-Type"=>"application/json",
                        'Authorization'=>'Bearer '.$token
                        ];
        $type       = "get";
        $result= curl($url,$header,$type);
        if($result["code"]==200)
        {
            return $result["body"];
        }
        else
        {
            return false;
        }
    }

    public function procesarData($data,$filtro)
    {
        $indicadorFiltrado = [];
        if(count($data))
        {
            foreach($data as $key => $valor)
            {
                if($valor['codigoIndicador'] == $filtro)
                {
                    $indicadorFiltrado[] =  $valor;
                }
            }
            return $indicadorFiltrado;
        }
        else
        {
            return false;
        }
    }

    public function insertMasivo($data)
    {
        try
        {
            Indicador::truncate();
            $result = Indicador::insert($data);
            if($result)
            {
                return Indicador::all()->count();
            }
        }
        catch (Exception $e) {
            Indicador::rollback();
            return $e;
        }
    }

    public function getIndicadoresLocal($page)
    {
        $perPage = 10;
        $from = ($page * $perPage) -  $perPage;
        $data  = Indicador::orderBy('fechaIndicador', 'desc')
        ->skip($from)->take($perPage)
        ->get();
        $page_count = ceil(count(Indicador::all())/$perPage);
        return ["data"=>$data,"page_count"=>$page_count];
    }
}
