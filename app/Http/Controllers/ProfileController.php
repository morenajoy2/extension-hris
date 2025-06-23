<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use App\Models\Department;
use App\Models\DepartmentTeam;
use App\Models\Position;
use App\Models\EmploymentType;
use App\Models\Group;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'roles' => Role::all(),
            'departments' => Department::all(),
            'departmentTeams' => DepartmentTeam::all(),
            'positions' => Position::all(),
            'employmentTypes' => EmploymentType::all(),
            'groups' => Group::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showProfile()
    {
        $user = Auth::user(); 
        return view('profile.view', compact('user'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Target: public/5/profile_photos/
            $folder = $user->id;
            $path = $file->storeAs($folder, $filename, 'public');
            
            $user->photo = $path;
            $user->save();
        }

        return back()->with('success', 'Profile photo updated successfully!');
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = null;
        $user->save();

        return back()->with('success', 'Profile photo deleted successfully!');
    }

}
