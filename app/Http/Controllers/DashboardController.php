<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    // Index
    public function index()
    {
        // if role nya owner
        if (auth()->user()->role == 'owner') {
            $users = User::all();
            $departments = Department::all();
            
            return view('dashboard.index', compact('users', 'departments'));
        }
        // jika role nya admin
        if (auth()->user()->role == 'admin') {
            $users = User::where('role', 'employee')
                ->orWhere('role', 'admin')
                ->get();

            $departments = Department::all();

            return view('dashboard.index', compact('users', 'departments'));
        }
        // jika role employee
        if (auth()->user()->role == 'employee') {
            $departments = Department::all();
            return view('dashboard.index', compact('departments'));
        }
    }

    public function store(Request $request)
    {
        // hanya role owner dan admin yang dapat create
        if (auth()->user()->role == 'owner' || auth()->user()->role == 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,employee',
                'department_id' => 'required|exists:departments,id',
            ], [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.string' => 'Kata sandi harus berupa teks.',
                'password.min' => 'Kata sandi minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
                'role.required' => 'Peran wajib diisi.',
                'role.in' => 'Peran yang dipilih tidak valid.',
                'department_id.required' => 'Departemen wajib diisi.',
                'department_id.exists' => 'Departemen tidak valid.',
            ]);
            

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'department_id' => $request->department_id,
            ]);

            // return redirect()->route('owner.dashboard'); and message success
            return redirect()->route('dashboard')->with('success', 'User created successfully');
        }
        // jika role bukan owner dan admin
        return redirect()->route('dashboard')->with('error', 'You are not allowed to create user because you are not owner or admin');
    }

    // Edit
    public function edit(User $user)
    {
        $departments = Department::all();
        return view('dashboard.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role == 'owner' || auth()->user()->role == 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:admin,employee',
                'department_id' => 'required|exists:departments,id',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'department_id' => $request->department_id,
            ]);

            if ($request->filled('password')) {
                $user->update(['password' => bcrypt($request->password)]);
            }

            // return redirect()->route('owner.dashboard'); and message success
            return redirect()->route('dashboard')->with('success', 'User updated successfully');
        }
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role == 'owner' || auth()->user()->role == 'admin') {
            $user->delete();
            // return redirect()->route('admin.dashboard'); and message success
            return redirect()->route('dashboard')->with('success', 'User deleted successfully');
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            // Delete the old avatar if it exists
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            // Create a unique name for the avatar
            $name = str_replace(' ', '_', $user->name);
            $date = date('Y-m-d_H-i-s');
            $extension = $request->avatar->extension();
            $avatarName = "{$name}-{$date}.{$extension}";

            // Save the new avatar
            $request->avatar->move(public_path('avatars'), $avatarName);
            $user->avatar = $avatarName;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    
}
