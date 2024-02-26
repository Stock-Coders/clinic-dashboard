<?php

namespace App\Http\Controllers;

use App\Models\Representative;
use App\Http\Requests\RepresentativeRequest;

class DashboardRepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $representatives = Representative::get();
            return view('dashboard.representatives.index', compact('representatives'));
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.representatives.create');
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepresentativeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if($validatedData['phone'] === $validatedData['secondary_phone']){
                return redirect()->route('representatives.index')->with('error', 'You can\'t add the same number for "phone" and "secondary phone" fields!');
            }
            Representative::create($validatedData);
            return redirect()->route('representatives.index')->with('success', '"'.$validatedData['name'].'" has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('representatives.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $representative = Representative::findOrFail($id);
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.representatives.edit', compact('representative'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RepresentativeRequest $request, string $id)
    {
        $representative = Representative::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($representative->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('representatives.edit', $representative->id)->with('warning', 'No changes were made!');
            }
            if($validatedData['phone'] === $validatedData['secondary_phone']){
                return redirect()->route('representatives.index')->with('error', 'You can\'t update "phone" or "secondary phone" fields with the same number!');
            }
            $representative->update($validatedData);
            return redirect()->route('representatives.index')->with('success', '"' . $representative->name . '" has been updated successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('representatives.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $representative = Representative::findOrFail($id);
        try {
            $representative->delete();
            return redirect()->route('representatives.index')->with('success', "\"$representative->name\" has been deleted successfully.");
        } catch (\Exception $exception) {
            return redirect()->route('representatives.index')->with('error', 'Something went wrong!');
        }
    }
}
