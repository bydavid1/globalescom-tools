<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function getTools()
    {
        $tools = Tool::all();

        return response()->json($tools);
    }
}
