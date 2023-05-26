<?php

namespace App\Http\Controllers;

use App\Models\BannerCategory;
use Illuminate\Http\Request;

class BannerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manajemen_produk.banner_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manajemen_produk.banner_category.form');
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
        return view('manajemen_produk.banner_category.form',[
            'id' => $id
        ]);
    }

}
