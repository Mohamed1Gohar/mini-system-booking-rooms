<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Admin']);
    }

    public function index()
    {
        $users = User::with('roles')->latest()->paginate(5);
        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
