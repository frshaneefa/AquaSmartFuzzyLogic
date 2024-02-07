<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\level; // the volateg change to table name('device1 exmple')
use App\Models\flow;
use App\Models\vibration;
use App\Models\alarmstat;
use Illuminate\Support\Facades\DB;

class dbcontroller extends Controller
{
    public function __construct()
    {
        $this->level = new level();
        $this->flow = new flow();
        $this->vibration = new vibration();
        $this->alarmstat = new alarmstat();
    }

    public function getlevel()
    {
        $blocks = DB::table('level')
                ->select('Value')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('Value');

        $blocks2 = DB::table('level')
                ->select('Value','DateTime')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('DateTime');
        return (compact('blocks','blocks2'));
    }

    public function getflow()
    {
        $blocks = DB::table('flow')
                ->select('Value')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('Value');

        $blocks2 = DB::table('flow')
                ->select('Value','DateTime')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('DateTime');
        return (compact('blocks','blocks2'));
    }

    public function getvibration()
    {
        $blocks = DB::table('vibration')
                ->select('Value')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('Value');

        $blocks2 = DB::table('vibration')
                ->select('Value','DateTime')
                ->latest('DateTime')
                ->limit(5)
                ->pluck('DateTime');
        return (compact('blocks','blocks2'));
    }

    public function getalarmstat()
    {
        $blocks = DB::table('alarmstat')
                ->select('Value')
                ->latest('DateTime')
                ->limit(4)
                ->pluck('Value');

        $blocks2 = DB::table('alarmstat')
                ->select('Value','DateTime')
                ->latest('DateTime')
                ->limit(4)
                ->pluck('DateTime');
        return (compact('blocks','blocks2'));
    }
        
}



