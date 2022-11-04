<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AuthorController extends Controller
{
    private $rules = [
        'name' => ['required', 'max:45', 'min:2'],
        'first_surname' => ['required', 'max:45', 'min:2'],
        'second_surname' => ['nullable', 'max:45', 'min:2'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setJsonResponse(false, 'Operation failed', []);

        try
        {
            $this->setJsonResponse(
                true,
                self::GENERIC_MESSAGES['success'],
                Author::all()
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $errorMessages = $this->isValid(
                $request->all(),
                $this->rules
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

            $author = Author::create($request->all());

            $this->setJsonResponse(
                $author->save(),
                self::GENERIC_MESSAGES['success'],
                $author,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        try
        {
            $this->setJsonResponse(
                true,
                self::GENERIC_MESSAGES['success'],
                $author
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        try
        {
            DB::beginTransaction();

            $errorMessages = $this->isValid(
                $request->all(),
                $this->rules
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

            $author->update($request->all());

            $this->setJsonResponse(
                $author->save(),
                self::GENERIC_MESSAGES['success'],
                $author,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        try
        {
            DB::beginTransaction();

            $this->setJsonResponse(
                $author->delete(),
                self::GENERIC_MESSAGES['success'],
                []
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
}
