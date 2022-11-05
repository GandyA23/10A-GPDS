<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookController extends Controller
{
    private $download = [
        'total_downloads' => 0
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
                Book::with('authors', 'category', 'editorial', 'bookDownload')->orderBy('published_date', 'DESC')->get()
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
                Book::$rules
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

            $book = Book::create($request->all());
            $book->authors()->attach($request->authors);
            $book->bookDownload()->create($this->download);

            $this->setJsonResponse(
                $book->save(),
                self::GENERIC_MESSAGES['success'],
                $book,
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        try
        {
            // Get relationship data
            $book->category = $book->category()->get();
            $book->editorial = $book->editorial()->get();
            $book->authors = $book->authors()->get();
            $book->bookDownload = $book->bookDownload()->get();

            $this->setJsonResponse(
                true,
                self::GENERIC_MESSAGES['success'],
                $book
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        try
        {
            DB::beginTransaction();

            // Exclude this id to isbn validation
            Book::$rules['isbn'][2] .= "," . $book->id;

            $errorMessages = $this->isValid(
                $request->all(),
                Book::$rules
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

            $book->update($request->all());
            $book->authors()->sync($request->authors);

            $this->setJsonResponse(
                $book->save(),
                self::GENERIC_MESSAGES['success'],
                $book,
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        try
        {
            DB::beginTransaction();

            $this->setJsonResponse(
                $book->delete(),
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
