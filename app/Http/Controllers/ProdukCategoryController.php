<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manajemen_produk.produk_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manajemen_produk.produk_category.form');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('manajemen_produk.produk_category.form',[
            'id' => $id
        ]);
    }
}
