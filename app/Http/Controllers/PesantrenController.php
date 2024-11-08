<?php

namespace App\Http\Controllers;

use App\Models\Pesantren;
use Illuminate\Http\Request;

class PesantrenController extends Controller
{
    //
    public function index()
    {
        return view('pesantrens.index');
    }
    public function show($id)
    {
        $pesantren = Pesantren::with(['facilities', 'extracurriculars'])->findOrFail($id);
        return view('pesantrens.show', compact('pesantren'));
    }
}
