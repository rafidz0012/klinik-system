<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatAPIController extends Controller
{
    public function index(){
        $obats = Obat::all();
        return response()->json([
            'status' => true,
            'data' => $obats
        ]); 
    }
}
