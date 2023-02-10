<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        

        return view('series.index')->with('series', $series)    
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $nomeSerie = $request->input('nome');
        $serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();

        return redirect(route('series.index'))
            ->with('mensagem.sucesso', "A serie '{$serie->nome}' foi adicionada com sucesso");
    }

    public function destroy(Serie $series)
    {
        $series->DELETE();

        return redirect(route('series.index'))
            ->with('mensagem.sucesso', "A serie '{$series->nome}' foi removida com sucesso");
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all());
        $series->save();

        return redirect(route('series.index'))
            ->with('mensagem.sucesso', "A série '{$series->nome}' Foi atualizada com sucesso");

    }
}
