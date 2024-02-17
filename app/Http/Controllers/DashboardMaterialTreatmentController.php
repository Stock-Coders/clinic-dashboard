<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;

class DashboardMaterialTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialsTreatments = Treatment::with('materials')->latest()->get();
        foreach ($materialsTreatments as $treatment) {
            // Check if the treatment has associated materials
            if ($treatment->materials->isEmpty()) {
                // Treatment has no associated materials
                // Handle the case when there are no associated materials
                // For example, you can set $materialsTreatments to null or take any other action
                $materialsTreatments = null;
                break; // Break the loop since we've found a treatment with no associated materials
            }
        }
        $allowedUsersEmails  = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail       = auth()->user()->email;
        return view('dashboard.materials-treatments.index', compact('materialsTreatments', 'allowedUsersEmails', 'authUserEmail'));
    }
}
