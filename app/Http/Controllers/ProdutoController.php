<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $produtos = Produto::latest() -> paginate(5);

        return view('produtos.index', compact('produtos'))
            -> with('i', (request() -> input('page', 1) -1 ) *5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request -> validate([
            'descricao' => 'required',
            'qtd' => 'required',
            'precoUnitario' => 'required',
            'precoVenda' => 'required',
        ]);

        Produto::create($request -> all());

        return redirect() -> route('produtos.index')
                            -> with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produtos): View
    {
        return view('produtos.show', compact('produtos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produtos): View
    {
        return view('produtos.edit', compact('produtos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produtos): RedirectResponse
    {
        $request -> validate([
            'descricao' =>'required',
            'qtd' =>'required',
            'precoUnitario' =>'required',
            'precoVenda' =>'required',
        ]);

        $produtos -> update($request -> all());

        return redirect() -> route('produtos.index')
                            -> with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produtos): RedirectResponse
    {
        $produtos -> delete();

        return redirect() -> route('produtos.index')
                            -> with('success', 'Produto deletado com sucesso.');
    }
}
