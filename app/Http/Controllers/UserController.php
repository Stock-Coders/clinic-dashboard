<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AllUsers()
    {
        if(auth()->user()->user_type === "employee" || auth()->user()->user_type === "doctor"){
            $users = User::whereNotIn('user_type', ['developer'])->get();
            $authUserEmail = auth()->user()->email;
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            return view('dashboard.users.indexes.all-users', compact('users', 'authUserEmail', 'allowedUsersEmails', 'developersEmails'));
        }
        elseif(auth()->user()->user_type === "developer"){
            $users = User::all();
            $authUserEmail = auth()->user()->email;
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            return view('dashboard.users.indexes.all-users', compact('users', 'authUserEmail', 'allowedUsersEmails', 'developersEmails'));
        }
        else{
            return abort(403);
        }
    }

    public function AllDoctors()
    {
        $doctors = User::ofType('doctor')->get();
        $authUserEmail = auth()->user()->email;
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        return view('dashboard.users.indexes.all-doctors', compact('doctors', 'authUserEmail', 'allowedUsersEmails', 'developersEmails'));
    }

    public function AllEmployees()
    {
        $employees = User::ofType('employee')->get();
        $authUserEmail = auth()->user()->email;
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        return view('dashboard.users.indexes.all-employees', compact('employees', 'authUserEmail', 'allowedUsersEmails', 'developersEmails'));
    }

    public function AllDevelopers()
    {
        $authUserEmail = auth()->user()->email;
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        if(in_array($authUserEmail, $developersEmails)){
            $developers = User::ofType('developer')->get();
            return view('dashboard.users.indexes.all-developers', compact('developers'));
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.users.create');
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            // Check if the 'user_type' value is "developer" and there are already three rows with this value
            $checkingUserType = "developer";
            if ($validatedData['user_type'] === $checkingUserType && User::where('user_type', $checkingUserType)->count() >= 3) {
                return redirect()->route('users.UsersIndex')->with('error', 'You can\'t create a user with this user type!');
            }
            User::create($validatedData);
            return redirect()->route('users.UsersIndex')->with('success', '"'.$validatedData['username'].'" has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('users.UsersIndex')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        // "doctor1@gmail.com" and "doctor2@gmail.com" can't update on each others
        // developers can't update on each others
        // "doctor1@gmail.com" and "doctor2@gmail.com" can't update on developers
        if(
            ($user->email === "doctor1@gmail.com" && auth()->user()->email === "doctor2@gmail.com") ||
            ($user->email === "doctor2@gmail.com" && auth()->user()->email === "doctor1@gmail.com") ||

            ($user->email === "kareemtarekpk@gmail.com" && auth()->user()->email === "mr.hatab055@gmail.com") ||
            ($user->email === "mr.hatab055@gmail.com" && auth()->user()->email === "kareemtarekpk@gmail.com") ||

            ($user->email === "stockcoders99@gmail.com" && auth()->user()->email === "kareemtarekpk@gmail.com") ||
            ($user->email === "kareemtarekpk@gmail.com" && auth()->user()->email === "stockcoders99@gmail.com") ||

            ($user->email === "mr.hatab055@gmail.com" && auth()->user()->email === "stockcoders99@gmail.com") ||
            ($user->email === "stockcoders99@gmail.com" && auth()->user()->email === "mr.hatab055@gmail.com") ||

            (($user->email === "kareemtarekpk@gmail.com" || $user->email === "mr.hatab055@gmail.com" ||
            $user->email === "stockcoders99@gmail.com") && (auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com"))
        ){
            return abort(403);
        }
        // if the logged in user is a developer, and the fetched data is for "doctor1@gmail.com" or "doctor2@gmail.com" the  make access available
        elseif(((auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
        auth()->user()->email === "stockcoders99@gmail.com") && ($user->email === "doctor1@gmail.com" || $user->email === "doctor2@gmail.com"))){
            return view('dashboard.users.edit', compact('user'));
        }
        // if the logged in user is employee or doctor (but not "doctor1@gmail.com" or "doctor2@gmail.com"), then redirect the authenticated user to his/her own edit page
        elseif(auth()->user()->id !== $user->id && (auth()->user()->user_type === "employee" || (auth()->user()->user_type === "doctor" && (auth()->user()->email !== "doctor1@gmail.com" && auth()->user()->email !== "doctor2@gmail.com")))){
            return redirect()->route('users.edit', auth()->user()->id);
        }
        // any other condition like when the logged in users are the "developers", "doctor1@gmail.com" or "doctor2@gmail.com". Then they will be able to update on the all other users
        else{
            return view('dashboard.users.edit', compact('user'));
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($user->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('users.edit', $user->id)->with('warning', 'No changes were made!');
            }
            // Check if the 'user_type' value is "developer" and there are already three rows with this value
            $checkingUserType = "developer";
            if ($validatedData['user_type'] === $checkingUserType && User::where('user_type', $checkingUserType)->count() >= 3) {
                return redirect()->route('users.UsersIndex')->with('error', 'You can\'t use this user type!');
            }
            if(auth()->user()->id == $user->id){
                $message = 'Your data has been updated successfully.';
            }
            else{
                $message = '"' . $user->username . '" has been updated successfully.';
            }
            $user->update($validatedData);
            return redirect()->route('users.UsersIndex')->with('success', $message);
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('users.UsersIndex')->with('error', 'Something went wrong!');
        }
    }

    public function changePassword(/*string $id*/ string $username)
    {
        // $user = User::findOrFail($id);
        $user = User::where('username', $username)->firstOrFail();
        $authUserEmail = auth()->user()->email;
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        // The users are only available to access their own change password page no one else could access someone's else change password page
        if($user->id === auth()->user()->id || (in_array($authUserEmail, $developersEmails) && !in_array($user->email, $developersEmails))){
            return view('dashboard.users.change-password.changePassword', compact('user'));
        }
        elseif(in_array($authUserEmail, $developersEmails) && in_array($user->email, $developersEmails)){
            return abort(403);
        }
        // In any other case, the users will also be taken to their own change password page!
        else{
            return redirect()->route('users.changePassword', auth()->user()->id);
        }
    }

    public function updatePassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        try {
            // The old/current password is not matching the current password in the DB.
            if(!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('old_pass_req_not_matching_db', '"Current Password" did not match "the Current Password". Please try again!');
            }
            // New password is not matching the confirmation (confirm password).
            elseif($request->confirm_new_password != $request->new_password) {
                return redirect()->back()->with('confirm_not_matching_new', '"New Password" did not match "Confirm Password". Please try again!');
            }
            // New password is equal to the old/current password. So you must change it! It mst be a very new password.
            elseif(Hash::check($request->new_password, $user->password)) {
                return redirect()->back()->with('new_pass_req_is_matching_old', '"New Password" must be different than the "Current Password"');
            }
            // All the following field mustn't be empty: Old/Current password input + new password input + confirm password input.
            elseif(empty($request->old_password) || empty($request->new_password) || empty($request->confirm_new_password)){
                return redirect()->back()->with('fields_are_required', 'All the fields are required to be filled!');
            }
            elseif(strlen($request->new_password) < 8){
                return redirect()->back()->with('new_pass_must_8_more_char', 'Password must be at least 8 characters long.');
            }
            // The old/current password is matching the current password in the DB + the new password length equals to 8 or more characters.
            elseif(Hash::check($request->old_password, $user->password) && strlen($request->new_password) >= 8) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                if(auth()->user()->id === $user->id){
                    return redirect()->back()->with('password_changed_successfully', 'Your password has been updated successfully!');
                }
                else{
                    return redirect()->back()->with('password_changed_successfully', '"'.$user->username.'"\'s password has been updated successfully!');
                }
            }
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('users.changePassword')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $userEmail = $user->email;
        $preventUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        if(auth()->user()->id === $user->id || in_array($userEmail, $preventUsersEmails)){
            return abort(403);
        }
        else{
            try {
                $user->delete();
                return redirect()->route('users.UsersIndex')->with('success', "\"$user->username\" has been deleted successfully.");
            } catch (\Exception $exception) {
                return redirect()->route('users.UsersIndex')->with('error', 'Something went wrong!');
            }
        }
    }
}
