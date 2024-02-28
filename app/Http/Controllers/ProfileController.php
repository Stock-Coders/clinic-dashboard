<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    // show - method (1) ~ Better Method: -----> Handles existing and non-extant data with 403 for better privacy & security
    public function showProfile(string $username)
    {
        $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $user = User::where('username', $username)->firstOrFail();
        if((!$user || $user->id !== auth()->user()->id) && !in_array(auth()->user()->email, $developersEmails)){ // !$user is same as $user == null
            return abort(403);
        }
        if(!$user && in_array(auth()->user()->email, $developersEmails)){ // To handle the 403 response for non-extant data for some specific users only!
            return abort(403);
        }
        if(in_array($user->email, $developersEmails) && $user->id !== auth()->user()->id){ // To handle, the "developersEmails" cannot access each others profiles
            return abort(403);
        }
        return view('dashboard.profiles.show', compact('user'));
    }

    // // show - method (2) ~ Good Method: -----> Handles existing data only with 403 (and non-extant data with 404)
    // public function showProfile(User $user)
    // {
    //     $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
    //     if((!$user || $user->id !== auth()->user()->id) && !in_array(auth()->user()->email, $developersEmails)){ // !$user is same as $user == null
    //         return abort(403);
    //     }
    //     if(!$user && in_array(auth()->user()->email, $developersEmails)){ // To handle the 403 response for non-extant data for some specific users only!
    //         return abort(403);
    //     }
    //     if(in_array($user->email, $developersEmails) && $user->id !== auth()->user()->id){ // To handle, the "developersEmails" cannot access each others profiles
    //         return abort(403);
    //     }
    //     return view('dashboard.profiles.show', compact('user'));
    // }

    public function storeOrUpdate(ProfileRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // The allowed users only (by email)
            $authUserEmail = auth()->user()->email;
            $developersEmails = ["kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"]; // To allow these users only!

            // Ensure that the 'user_id' in the request matches the authenticated user's ID, except for the mentioned users above are allowed same as the authenticated users
            if ($validatedData['user_id'] != auth()->id() && !in_array($authUserEmail, $developersEmails)) {
                return redirect()->back()->with('error', 'Unauthorized access to user profile!');
            }
            // For non allowed users and non authenticated users. If the user is not allowed to create or update on other users' profiles, check and return error
            if (!in_array($authUserEmail, $developersEmails) && $userProfile->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized access to user profile!');
            }

            // Check if the user has an existing profile then update on it don't create and if it's non-existing then create
            $userProfile = Profile::firstOrNew(['user_id' => $validatedData['user_id']]);

            // Check if the "secondary_phone" number is not the same as the primary phone from the users table (by using the "user" function from Profile model)
            if ($validatedData['secondary_phone'] == $userProfile->user->phone){
                return redirect()->back()->with('error_secondary_phone', 'You cannot use the same phone number for the "Secondary Phone" field as your primary phone number! Please enter a different phone number for the secondary phone.');
            }
            // Validation for secondary_phone: Check if the secondary phone is unique for other users
            $existingSecondaryPhone = Profile::where('secondary_phone', $validatedData['secondary_phone'])->whereNotNull('secondary_phone')
            ->where('user_id', /*$userProfile->user_id*/ $validatedData['user_id']) // Exclude the current user
            ->exists();
            if ($existingSecondaryPhone) {
                return redirect()->back()->with('error', 'The secondary phone has already been taken.');
            }
            // Validation for gender: Check if the gender is left empty (gender is a required field but not required for codexsoftwareservices01@gmail.com)
            if (empty($validatedData['gender']) && $userProfile->user->email !== "codexsoftwareservices01@gmail.com"){
                return redirect()->back()->with('error', 'Please select a gender!');
            }
            // The gender field is null for user "codexsoftwareservices01@gmail.com"
            if($userProfile->user->email === "codexsoftwareservices01@gmail.com"){
                $validatedData['gender'] = null;
            }
            // Check if a file is present in the request (for "avatar")
            if ($request->hasFile('avatar')) {
                // Hashed file name
                    // $avatarRequest = $request->file('avatar');
                    // $avatarHashedName = $avatarRequest->hashName();
                    // $userUsername = $userProfile->user->username; // making a directory name with the user's username
                    // $avatarPath = Storage::putFileAs("public/assets/dashboard/images/users/profiles/avatars/$userUsername", $avatarRequest, $avatarName);
                // Actual file name
                    $avatarRequest = $request->file('avatar');
                    $avatarName = $avatarRequest->getClientOriginalName();
                    $userUsername = $userProfile->user->username; // making a directory name with the user's username
                    $avatarPath = Storage::putFileAs("public/assets/dashboard/images/users/profiles/avatars/$userUsername", $avatarRequest, $avatarName);
                $validatedData['avatar'] = $avatarPath;

                // Delete the old image if needed, you can customize this part based on your requirements
                // Storage::delete($validatedData['avatar']);
            }

            $userProfile->fill($validatedData); // Holds the validated data (array) that contains the columns that will be created or updated
            $userProfile->save();

            return redirect()->back()->with('success', 'Your profile has been saved.');
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

}
