<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Http\Requests\MaterialRequest;

class DashboardMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::latest()->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.materials.index', compact('materials', 'allowedUsersEmails', 'authUserEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $representatives = \App\Models\Representative::all();
            $treatments      = \App\Models\Treatment::all();
            return view('dashboard.materials.create', compact('representatives', 'treatments'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $material = Material::create($validatedData);
            if ($request->has('treatments')) {
                $material->treatments()->attach($request->input('treatments'));
            }
            return redirect()->route('materials.index')->with('success', '"'.$validatedData['title'].'" has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('materials.index')->with('error', 'Something went wrong!');
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
        $material = Material::findOrFail($id);
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $representatives = \App\Models\Representative::all();
            $treatments      = \App\Models\Treatment::all();
            return view('dashboard.materials.edit', compact('material', 'representatives', 'treatments'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, string $id)
    {
        $material = Material::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($material->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('materials.edit', $material->id)->with('warning', 'No changes were made!');
            }
            $material->update($validatedData);
            if ($request->has('treatments')) {
                $material->treatments()->sync($request->input('treatments'));
            } else {
                $material->treatments()->detach();
            }
            return redirect()->route('materials.index')->with('success', '"' . $material->title . '" has been updated successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('materials.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        try {
            $material->treatments()->detach();
            $material->delete();
            return redirect()->route('materials.index')->with('success', "\"$material->title\" has been deleted successfully.");
        } catch (\Exception $exception) {
            return redirect()->route('materials.index')->with('error', 'Something went wrong!');
        }
    }
}
