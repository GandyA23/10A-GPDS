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
                    200
                );
            }
            else
            {
                $token = explode('|', $request->user()->createToken($request->device_name)->plainTextToken);

                $this->setJsonResponse(
                    true,
                    self::GENERIC_MESSAGES['success'],
                    [
                        'token_id' => $token[0],
                        'token' => $token[1]
                    ]
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
            $isDeleted = $request->user()->currentAccessToken()->delete();

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

    public function userProfile(Request $request)
    {
        try
        {
            $this->setJsonResponse(
                true,
                self::GENERIC_MESSAGES['success'],
                $request->user()
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

    public function changePassword(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $errorMessages = $this->isValid(
                $request->all(),
                User::$rules['change-password']
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

            $user = $request->user();

            if (Hash::check($request->old_password, $user->password))
            {
                $user->password = Hash::make($request->password);
                $user->save();

                // Drop all tokens to login again

                $this->setJsonResponse(
                    $user->tokens()->delete(),
                    self::GENERIC_MESSAGES['success'],
                    'Change password successful, please login again!'
                );
            }
            else
            {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    'Wrong password!',
                    200
                );
            }

            DB::commit();
        }
        catch(Throwable $t)
        {
            report($t);
            $this->setJsonResponse(
                false,
                self::GENERIC_MESSAGES['error'],
                [ self::GENERIC_MESSAGES['try_later'] ]
            );

            DB::rollBack();
        }

        return response()
            ->json(...$this->getResponse());
    }
}
