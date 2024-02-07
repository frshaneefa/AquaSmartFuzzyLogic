<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\level;
use App\Models\flow;
use Illuminate\Support\Facades\DB;

class APIcontroller extends Controller
{
    public function __construct()
    {
        $this->level = new level();
        $this->flow = new flow();

    }

    public function listlevel()
    {
      $blocks = DB::table('level')
            ->select('Value')
            ->latest('DateTime')
            ->limit(1)
            ->pluck('Value');
            return (compact('blocks'));
    }

    public function listflow()
    {
      $blocks = DB::table('flow')
            ->select('Value')
            ->latest('DateTime')
            ->limit(1)
            ->pluck('Value');
            return (compact('blocks'));
    }
}