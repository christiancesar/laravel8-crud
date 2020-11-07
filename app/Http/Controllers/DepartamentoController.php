<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [ 
                'nome' => 'required|min:2|unique:departamentos',
            ],
            [
              'nome.required' => 'O nome do departamento é obrigatório'  ,
              'nome.min' => 'O nome de departamento deve ter no mínimo 2 letras'  ,
              'nome.unique' => 'Este departamento já está cadastrado'  ,
            ]
        );

        $departamento = new Departamento();
        $departamento->nome = $request->nome;
        $departamento->save();
        
        return redirect()->route('departamentos.index')
            ->with('msg_success', 'Departamento cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        return view(
            'departamentos.edit', 
            compact(['departamento'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        $request->validate(
            [ 
                'nome' => [
                    'required',
                    'min:2',
                    Rule::unique('departamentos')->ignore($departamento->id)
                ],
            ],
            [
              'nome.required' => 'O nome do departamento é obrigatório'  ,
              'nome.min' => 'O nome de departamento deve ter no mínimo 2 letras'  ,
              'nome.unique' => 'Este departamento já está cadastrado'  ,
            ]
        );

        $departamento->nome = $request->nome;
        $departamento->save();

        return redirect()->route('departamentos.index')
            ->with('msg_success', 'Departamento atualizado com sucesso');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        // TODO 
        
        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('msg_success', 'Departamento removido com sucesso.');
    }
}
