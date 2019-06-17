<?php

namespace BjornvanSchie\LaravelInstaller\Helpers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserType;
use BenSampo\Enum\Rules\EnumValue;

class UserManager
{
    public function saveUser(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'zip_code' => ['required', 'postal_code:NL']
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'zip_code' => preg_replace('/\s+/', '', $request->zip_code),
            'house_number' => $request->house_number,
            'password' => Hash::make($request->password),
        ]);

        $user->type = UserType::Admin;
        $user->save();
    }
}
