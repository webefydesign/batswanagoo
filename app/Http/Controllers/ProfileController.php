<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
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

        if(isset($request->address)){
            $request->user()->address = $request->address;
        }

        if(isset($request->country)){
            $request->user()->country = $request->country;
        }

        if(isset($request->state)){
            $request->user()->state = $request->state;
        }

        if(isset($request->city)){
            $request->user()->city = $request->city;
        }

        if(isset($request->website_url)){
            $request->user()->website_url = $request->website_url;
        }

        if(isset($request->contact_detail)){
            $request->user()->contact_detail = $request->contact_detail;
        }

        if(isset($request->phone)){
            $request->user()->phone = $request->phone;
        }

        /* Make Images Directory */
            $uploadDir = public_path().'/uploads/user_image/';
            File::isDirectory($uploadDir) or File::makeDirectory($uploadDir, 0777, true, true);
        /* Make Images Directory */
        $name = $request->name.rand(0,9);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_ext = $file->getClientOriginalExtension();
            $filename = $name.$file->getClientOriginalName();
            // $file->move($uploadDir, $filename);
            $filepath = $uploadDir.$filename;

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            $image = $manager->read($request->file('image'));

            $image->resize(300, 300)->save($filepath);
            $data['image'] = $filename;

            $request->user()->image = $filename;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'profile Updated');
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
}
