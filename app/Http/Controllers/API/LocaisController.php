<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Local;
use Validator;

class LocaisController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locais = Local::all();

        return $this->sendResponse($locais->toArray(), 'Locais listados com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cep' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        // Busca o local pelo cep informado 
        $url = "http://api.postmon.com.br/v1/cep/" . $request->cep;
        $data = json_decode(file_get_contents($url));


        $local = new Local;
        $local->bairro = $data->bairro;
        $local->cidade = $data->cidade;
        $local->logradouro = $data->logradouro;
        $local->cep = $data->cep;
        $local->estado = $data->estado;
        $local->save();


        return $this->sendResponse($local->toArray(), 'Local criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $local = Local::find($id);


        if (is_null($local)) {
            return $this->sendError('Local não encontrado.');
        }


        return $this->sendResponse($local->toArray(), 'Local encontrado com sucesso.');
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
            'bairro' => 'max:255',
            'cidade' => 'max:255',
            'logradouro' => 'max:255',
            'cep' => 'max:255',
            'estado' => 'max:2',
            'evento_id' => ''
        ]);


        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $local = Local::find($id);
        $local->fill($request->all());
        $local->save();


        return $this->sendResponse($local->toArray(), 'Local atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $local = Local::find($id);
        $local->delete();


        return $this->sendResponse($local->toArray(), 'Local deletado com sucesso.');
    }
}
