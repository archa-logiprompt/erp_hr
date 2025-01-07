<?php

namespace App\Http\Controllers;

use App\Models\ClientDetails;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


public function dashboard()
    {

        $clientdetails = ClientDetails::all();
        $projectdetails = Project::all();
        $totalClients = $clientdetails->count();
        $totalProjects = $projectdetails->count();
        return view('dashboard',compact('clientdetails','projectdetails','totalClients','totalProjects'));
    }

}