<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        if(User::all()->count()<0)
        {
            return responder()->error(User::all())->respond(404, ['success' => false]);
        }
        else
            return responder()->success(User::all())->respond(200, ['success' => true]);
    }

    public function user_by_id($id)
    {
        if(User::where('id',$id)->exists())
        {
            return responder()->success(User::whereId($id)->get())->respond();
        }
        else
            return responder()->error()->respond();
    }

    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;

            if ($user->save()) {
                return responder()->success(['message'=>'user saved successfully'])->respond();
            }
        } catch (\Exception $err){
            return responder()->error('',$err->getMessage())->respond();

        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if($user->save()) {
                return responder()->success(['message'=>'user updated successfully'])->respond();
            }
        } catch (\Exception $err) {
            return responder()->error('',$err->getMessage())->respond();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if($user->delete()) {
                return responder()->success(['message'=>'user deleted successfully'])->respond();
            }
        } catch (\Exception $err) {
            return responder()->error('',$err->getMessage())->respond();
        }
    }
}
