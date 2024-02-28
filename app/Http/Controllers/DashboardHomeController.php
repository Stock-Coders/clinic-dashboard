<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardHomeController extends Controller
{
    public function index(){
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.home', compact('allowedUsersEmails', 'developersEmails', 'authUserEmail'));
    }
}
