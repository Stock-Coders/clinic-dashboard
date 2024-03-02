<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;
use App\Models\XRay;
use App\Models\Representative;
use App\Models\Material;

class DashboardSearchController extends Controller
{
    public function searchResults(Request $request)
    {
        $searchQuery = $request->input('search_query');
        if (empty($searchQuery)) {
            return redirect()->route('dashboard')->with('search_warning', "Please enter a query in the search.");
        }
        if(auth()->user()->user_type == "developer"){
            $users = User::where('username', 'like', "%$searchQuery%")
                        ->orWhere('user_type', 'like', "%$searchQuery%")
                        ->orWhere('user_role', 'like', "%$searchQuery%")
                        ->orWhere('email', 'like', "%$searchQuery%")->get();
        }
        elseif(auth()->user()->user_type == "doctor" || auth()->user()->user_type == "employee"){
            $users = User::where('user_type', '!=', "developer")
                ->where(function ($query) use ($searchQuery) {
                    $query->where('username', 'like', "%$searchQuery%")
                        ->orWhere('user_type', 'like', "%$searchQuery%")
                        ->orWhere('user_role', 'like', "%$searchQuery%")
                        ->orWhere('email', 'like', "%$searchQuery%");
                })->get();
        }
        $patients = Patient::where('first_name', 'like', "%$searchQuery%")
                        ->orWhere('last_name', 'like', "%$searchQuery%")
                        // ->orWhere(function($query) use ($searchQuery) {
                        //     $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$searchQuery%")
                        //         ->orWhere(DB::raw("CONCAT(first_name, '', last_name)"), 'like', "%$searchQuery%");
                        // })
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%$searchQuery%"])
                        ->orWhereRaw("CONCAT(first_name, '', last_name) like ?", ["%$searchQuery%"])
                        ->get();
        $xrays = XRay::where('timing', 'like', "%$searchQuery%")->latest()->get();
        $representatives = Representative::where('name', 'like', "%$searchQuery%")
                        ->orWhere('email', 'like', "%$searchQuery%")->get();
        $materials = Material::where('title', 'like', "%$searchQuery%")->get();
        $mergedResults = $users->merge($patients)->merge($xrays)->merge($representatives)->merge($materials);
        $authUserEmail = auth()->user()->email;
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        return view('dashboard.search-results', compact('searchQuery', 'mergedResults', 'authUserEmail', 'allowedUsersEmails'));
    }
}
