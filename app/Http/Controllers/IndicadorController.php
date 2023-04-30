<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicador;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
                    self::insertMasivo($result);
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
        Indicador::insert($data);
    }
}
