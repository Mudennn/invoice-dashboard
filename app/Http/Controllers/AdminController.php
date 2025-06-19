<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Only super_admin can create new admins
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->route('admins.index')
                ->with('error', 'Only super admins can create new admins.');
        }
        
        return view('admins.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Only super_admin can create new admins
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->route('admins.index')
                ->with('error', 'Only super admins can create new admins.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Alert::toast('Admin created successfully.' , 'success');
        return redirect()->route('admins.index');
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        
        // Only super_admin can edit super_admin accounts
        if ($admin->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
            return redirect()->route('admins.index')
                ->with('error', 'You do not have permission to edit a super admin.');
        }
        
        return view('admins.edit', compact('admin'));
    }       

    /**
     * Update the specified admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        // Only super_admin can edit super_admin accounts
        if ($admin->role === 'super_admin' && Auth::user()->role !== 'super_admin') {
            return redirect()->route('admins.index')
                ->with('error', 'You do not have permission to edit a super admin.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($admin->id)
            ],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        Alert::toast('Admin updated successfully.' , 'success');
        return redirect()->route('admins.index');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('admins.show', compact('admin'));
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $currentUser = Auth::user();
        
        // Prevent deletion of super_admin by non-super_admin
        if ($admin->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return redirect()->route('admins.index')
                ->with('error', 'You do not have permission to delete a super admin.');
        }

        // Prevent self-deletion
        if ($admin->id === $currentUser->id) {
            return redirect()->route('admins.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        Alert::toast('Admin deleted successfully.' , 'success');
        return redirect()->route('admins.index');
    }
} 