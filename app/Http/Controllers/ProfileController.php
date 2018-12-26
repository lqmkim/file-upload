<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Load view
     */
    public function index()
    {
        return view('profile');
    }

    /**
     * Upload image
     */
    public function upload(Request $request)
    {
        /**
         * file()->store() will return image path
         * storage/app/{returned path}
         */
        $path = $request->file('avatar')->store('avatars');

        /**
         * Get current user
         */
        $user = Auth::user();

        /**
         * Store image path to database
         */
        $user->image = $path;
        $user->save();
    }

    /**
     * Save video id to database
     */
    public function videoid(Request $request)
    {
        /**
         * Get video URI
         */
        $uri = $request->input('uri');

        /**
         * Get current user
         */
        $user = Auth::user();

        /**
         * Store image path to database
         */
        $user->video = $uri;
        $user->save();
    }
}
