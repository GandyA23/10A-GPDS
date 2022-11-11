<?php

namespace App\Http\Controllers;

use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookReviewController extends Controller
{
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
                BookReview::with('user', 'book')->orderBy('id', 'DESC')->get()
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
                BookReview::$rules
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

            $bookReview = new BookReview($request->all());
            $bookReview->user()->associate($request->user());

            $this->setJsonResponse(
                $bookReview->save(),
                self::GENERIC_MESSAGES['success'],
                $bookReview,
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
     * @param  \App\Models\BookReview  $bookReview
     * @return \Illuminate\Http\Response
     */
    public function show(BookReview $bookReview)
    {
        try
        {
            // Get relationship data
            $bookReview->user = $bookReview->user()->get();
            $bookReview->book = $bookReview->book()->get();

            $this->setJsonResponse(
                true,
                self::GENERIC_MESSAGES['success'],
                $bookReview
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
     * @param  \App\Models\BookReview  $bookReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookReview $bookReview)
    {
        try
        {
            DB::beginTransaction();

            $errorMessages = $this->isValid(
                $request->all(),
                BookReview::$rules
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

            // Check if the review belongs to user
            if ($bookReview->user_id != $request->user()->id)
            {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    ["You do not have permission to access this resource"],
                    403
                );

                return response()
                    ->json(...$this->getResponse());
            }

            $bookReview->update($request->all());
            $bookReview->edited = true;

            $this->setJsonResponse(
                $bookReview->save(),
                self::GENERIC_MESSAGES['success'],
                $bookReview,
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
     * @param  \App\Models\BookReview  $bookReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BookReview $bookReview)
    {
        try
        {
            DB::beginTransaction();

            // Check if the review belongs to user
            if ($bookReview->user_id != $request->user()->id)
            {
                $this->setJsonResponse(
                    false,
                    self::GENERIC_MESSAGES['error'],
                    ["You do not have permission to access this resource"],
                    403
                );

                return response()
                    ->json(...$this->getResponse());
            }

            $this->setJsonResponse(
                $bookReview->delete(),
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
