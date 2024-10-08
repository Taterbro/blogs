<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class authcontroller extends Controller
{
    public function login(Request $request){
        $incomingFields = $request->validate([
            'Lname' => 'required',
            'Lpassword' => 'required'
        ]);
        if (Auth::attempt(['name'=>$incomingFields['Lname'], 'password'=>$incomingFields['Lpassword']])){
            $request->session()->regenerate();
            return redirect('/blogs');
        }
        return redirect('/');
    }

    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required','min:3', 'max:10',Rule::unique('users', 'name')],
            'email' => ['required', 'email',Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:16']
        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->guard()->login($user);
        return redirect('/blogs');
    }
    public function logout(){
        auth()->guard()->logout();
        return redirect('/');
    }

    
}
