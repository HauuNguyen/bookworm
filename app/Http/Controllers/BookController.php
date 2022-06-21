<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BookRepositories;

class BookController extends Controller
{
    private BookRepositories $book ;
    public function __construct(BookRepositories $Bookrepositories)
    {
        $this->book = $Bookrepositories ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {   
        return response($this->book->getById($id));
    }

    public function review($book_id=null,$review_id=null)
    { 
        return response($this->book->getReview($book_id,$review_id));
    }
    public function getCategories()
    {
        $category = new BookRepositories();
        return response($category->getCategories());
    }

    public function getBooksOfCategory($category_id)
    {
        $cate = new BookRepositories();
        return response($cate->getAllBookOfCate($category_id));
    }

    public function getAuthors()
    {
        $author = new BookRepositories();
        return response($author->getAllAuthors());
    }

    public function getBooksOfAuthor($author_id)
    {
        $auth = new BookRepositories();
        return response($auth->getAllBooksOfAuthor($author_id));
    }

    // public function sortByPrice(){
    //     $book = new BookRepositories();
    //     return response($book->sortByPriceHighToLow());
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Book  $book
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Book $book)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Book  $book
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Book $book)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Book  $book
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Book $book)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Book  $book
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Book $book)
    // {
    //     //
    // }
}
