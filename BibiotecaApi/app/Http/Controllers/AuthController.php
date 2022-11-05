<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $errorMessages = $this->isValid(
                $request->all(),
                User::$rules['register']
            );

            if ($errorMessages)
            {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    $errorMessages,
                    400
                );

                return response()
                    ->json(...$this->getResponse());
            }

            $user = new User($request->all());
            $user->password = Hash::make($request->password);

            $this->setJsonResponse(
                $user->save(),
                self::GENERIC_MESSAGES['success'],
                $user,
                201
            );

            DB::commit();
        }
        catch(Throwable $t)
        {
            DB::rollBack();

            report($t);
            $this->setJsonResponse(
                false,
                self::GENERIC_MESSAGES['error'],
                [ self::GENERIC_MESSAGES['try_later'] ]
            );
        }

        return response()
            ->json(...$this->getResponse());
    }

    public function login(Request $request)
    {
        try
        {
            $errorMessages = $this->isValid(
                $request->all(),
                User::$rules['login']
            );

            if ($errorMessages)
            {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    $errorMessages,
                    400
                );

                return response()
                    ->json(...$this->getResponse());
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    'The provided credentials are incorrect.',
                    400
                );
            }
            else
            {
                $this->setJsonResponse(
                    true,
                    self::GENERIC_MESSAGES['success'],
                    ['token' => $request->user()->createToken($request->device_name)->plainTextToken]
                );
            }

        }
        catch(Throwable $t)
        {
            report($t);
            $this->setJsonResponse(
                false,
                self::GENERIC_MESSAGES['error'],
                [ self::GENERIC_MESSAGES['try_later'] ]
            );
        }

        return response()
            ->json(...$this->getResponse());
    }

    public function logout(Request $request)
    {
        try
        {
            $isDeleted = $request->user()->tokens()->delete();
            
            $this->setJsonResponse(
                $isDeleted,
                self::GENERIC_MESSAGES[$isDeleted ? 'success' : 'error'],
                []
            );
        }
        catch(Throwable $t)
        {
            report($t);
            $this->setJsonResponse(
                false,
                self::GENERIC_MESSAGES['error'],
                [ self::GENERIC_MESSAGES['try_later'] ]
            );
        }

        return response()
            ->json(...$this->getResponse());
    }
}
