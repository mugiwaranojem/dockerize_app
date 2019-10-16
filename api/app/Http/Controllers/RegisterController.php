<?php
namespace App\Http\Controllers; 

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        $name = $request->get('name', null);
        $email = $request->get('email');
        $password = $request->get('password');

        $uuid = Uuid::generate()->string;
        $user = new User;
        $user->id = $uuid;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->save();

        return response()->json([
            'id' => $uuid,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => date('c', strtotime($user->created_at)),
            'updated_at' => date('c', strtotime($user->updated_at))
        ], 200);
    }
}