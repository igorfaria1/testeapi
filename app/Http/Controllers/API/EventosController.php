<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Evento;
use Validator;

class EventosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evento = Evento::with('local')->get();
        return $this->sendResponse($evento->toArray(), 'Eventos listados com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'tipo' => 'required|max:255',
            'titulo' => 'required|max:255',
            'descricao' => 'required|max:255',
            'data' => 'required|date',
        ]);


        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $evento = Evento::create($input);


        return $this->sendResponse($evento->toArray(), 'Evento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = Evento::find($id);


        if (is_null($evento)) {
            return $this->sendError('Evento não encontrado.');
        }


        return $this->sendResponse($evento->toArray(), 'Evento encontrado com sucesso.');
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
            'tipo' => 'max:255',
            'titulo' => 'max:255',
            'descricao' => 'max:255',
            'data' => 'date'
        ]);


        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $evento = Evento::find($id);
        $evento->fill($request->all());
        $evento->save();


        return $this->sendResponse($evento->toArray(), 'Evento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = Evento::find($id);
        $evento->delete();


        return $this->sendResponse($evento->toArray(), 'Evento deletado com sucesso.');
    }

        /**
     * Pesquisa o evento por titulo, data, tipo e descricao
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {

        $evento = Evento::where(function ($query) use($request)
        {
            if(isset($request->titulo) && ($request->titulo != null))
            {
                $query->where('titulo', $request->titulo);
            }
            if(isset($request->data) && ($request->data != null))
            {
                $query->where('data', $request->data);
            }
            if(isset($request->tipo) && ($request->tipo != null))
            {
                $query->where('tipo', $request->tipo);
            }
            if(isset($request->descricao) && ($request->descricao != null))
            {
                $query->where('descricao', $request->descricao);
            }
        })->get();

        $evento = Evento::with('local')->get();
        return response()->json($evento, 201);
    }
}
