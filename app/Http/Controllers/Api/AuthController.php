<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->hasFile('image')) {
                $path = 'uploads/users';
                $name = webpUploadImage($request->file('image'), $path);
                $user->image = $name;
                $user->save();
            }

            if ($user) {
                Auth::login($user);
                if (auth()->check()) {
                    return response()->json(['status' => 200, 'data' => UserResource::make($user), 'message' => '']);
                }
            }
            return response()->json(['status' => 400, 'message' => 'Something went wrong']);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => $request]);
        }
    }

    public function showProfile()
    {
        try {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user) {
                    return response()->json(['status' => 200, 'data' => UserResource::make($user)]);
                } else {
                    return response()->json(['status' => 400, 'message' => 'Not found']);
                }
            }
            return response()->json(['status' => 400, 'message' => 'Something went wrong']);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found')]);
        }
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        try {
            $user = auth()->user();
            if ($user) {
                $user->update($request->except('image', 'password', '_method', '_token'));

                if ($request->has('password') && $request->password) {
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                }

                if ($request->hasFile('image')) {
                    $path = 'uploads/users';
                    $name = webpUploadImage($request->file('image'), $path);
                    $user->image = $name;
                    $user->save();
                }
                return response()->json(['status' => 200, 'message' => '', 'data' => UserResource::make($user)]);
            }
            return response()->json(['status' => 400, 'message' => '']);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => $request]);
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            if ($request->has('email') && $request->has('password') && $request->email) {
                $user = User::where('email', $request->email)->first();
                if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                    if (!auth()->user()->active) {
                        if (Auth::check()) {
                            $token = auth()->user()->tokens()->delete();
                        }
                        return response()->json(['status' => 300, 'message' => 'Invalid Login Activation']);
                    }
                    return response()->json(['status' => 200, 'message' => '', 'data' => UserResource::make($user)]);
                }
            }
            return response()->json(['status' => 400, 'message' => '']);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => $request]);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                $token = auth()->user()->tokens()->delete();
                return response()->json(['status' => 200, 'message' => '']);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => $request]);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $record = User::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return response()->json(['status' => 200, 'message' => __('Changed Successfully'), 'data' => '']);
            } else {
                return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => '']);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['status' => 400, 'message' => __('Model not found'), 'data' => $request]);
        }
    }
}
