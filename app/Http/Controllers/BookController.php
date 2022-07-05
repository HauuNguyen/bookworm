<?php

namespace App\Http\Controllers;
use App\Models\Book ;
use App\Models\Review ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BookRepositories;
use Illuminate\Support\Facades\DB;
class BookController extends Controller
{
    private BookRepositories $book ;
    public function __construct(BookRepositories $Bookrepositories)
    {
        $this->book = $Bookrepositories ;
        $this -> query = Book::query() ;
        $this->review = Review::query() ;
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
    public function getAverageRating($book_id)
    {
        return response($this->book->getAvgRating($book_id));
    }
    public function getCategories()
    {
        return response($this->book->getCategories());
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
    public function getTopDiscount()
    {
        return response($this->book->getTop10DiscountBooks());
    }

    public function getRecommend()
    {
        return response($this->book->getRecommendBooks());
    }
    
    public function getBooksFinalPrice()
    {
        return response($this->book->finalPrice());
    }
    public function topMostPopular()
    {
        return response($this->book->getMostPopularBooks());
    }
    public function sortBySale(){
        return response($this->book->sortBySale());
    }
    public function sortByPopular(){
        return response($this->book->sortByPopular());
    }
    public function sortPriceLTH(){
        return response($this->book->sortByPriceLowToHigh());
    }
    public function sortPriceHTL(){
        return response($this->book->sortByPriceHighToLow());
    }

    // public function filterBook(Request $request){
    //     return response($this->book->filterBook($request->id));
    // }
    public function getListOfRating($num_star){
        return response($this->book->getListOfRating($num_star));
    }
    public function getAvgStar(){
        return $this->query
        ->join('review','review.book_id','=','book.id')
        ->selectRaw('book.id, round(avg(review.rating_start),2) AS averagestar')
        ->groupBy('book.id');
    }
    // public function starPrice(){
    //     $star = $this->query
    //         ->join('review','book.id','=','review.book_id')
    //         -> select('book.id',DB::raw('round(AVG(rating_start),1) as averagestar'))
    //         -> groupBy('book.id');
    //     return $this->query
    //     ->joinSub($star,'star',function ($joinstar){
    //         $joinstar-> on('star.id','=','book.id') ;
    //     })  
        
    // }
    public function filterBook(Request $request){
        $finalprice = $this->query 
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('book.*,
            (case  when    discount.discount_start_date <= current_date
                    and (   discount.discount_end_date >= current_date or 
                            discount.discount_end_date is null )    
                    then discount.discount_price
                    else book.book_price end  ) as finalprice
            '
        );
        if($request->category_id){
            return $this->query-> joinSub($finalprice,'finalprice',function ($join){
                $join-> on('finalprice.id','=','book.id') ;
            })
            ->join('category', 'category.id', '=', 'book.category_id')
            ->where('book.category_id',$request->category_id)
            ->orderBy('finalprice.finalprice')
            ->get();
        }
        if($request->author_id){    //  author isset    in category_id 
                // $book->where('book.author_id',$request->author_id); 
            return $this->query-> joinSub($finalprice,'finalprice',function ($join){
                $join-> on('finalprice.id','=','book.id') ;
            })    
            ->join('author', 'author.id', '=', 'book.author_id')
            ->where('book.author_id',$request->author_id)
            ->orderBy('finalprice.finalprice')
            ->get();
    
        }

        if($request->rating_star){
            $star = $this->query
            ->join('review','book.id','=','review.book_id')
            -> select('book.id',DB::raw('round(AVG(rating_start),1) as averagestar'))
            -> groupBy('book.id');
             return $this->query
            ->joinSub($finalprice,'finalprice',function ($join){
                $join-> on('finalprice.id','=','book.id') ;
            }) 
            ->joinSub($star,'star',function ($joinstar){
                $joinstar-> on('star.id','=','book.id') ;
            })  
            // ->selectRaw('book.*')
            // ->where('star.averagestar','=',$request->rating_star)
            // ->orWhere('star.averagestar','>',$request->rating_star)
            // ->groupBy('book.id')
            // ->get()
            //->leftjoin('review','review.book_id','=','book.id')
            ->where('star.averagestar','>=',$request->rating_star)
            ->groupBy('book.id','finalprice.finalprice','star.averagestar')
            ->get()
        ;}
    }   

    public function getFiltering(Request $request){
    //    $book = Book::with(['category','author']);
        
       if($request->id){
        return $this->query->where('book.id',$request->id)->get();
       } else {
        if($request->category_id){
            // $book->where('book.category_id',$request->category_id); 
            return $this->query
            ->join('category', 'category.id', '=', 'book.category_id')
            ->where('book.author_id',$request->category_id)
            ->get();

        }else {
            if($request->author_id){    //  author isset    in category_id 
                // $book->where('book.author_id',$request->author_id); 
                return $this->query    
                ->join('author', 'author.id', '=', 'book.author_id')
                ->where('book.author_id',$request->author_id)
                ->get();
    
            }
                else {
                    if($request->rate_star){
                        $avg_all = $this->getAvgAll();
                        return $this->query
                        ->joinSub($avg_all, 'avg_all', function ($join) {
                            $join->on('avg_all.id', '=', 'book.id');
                        })
                        ->selectRaw('book.*')
                        ->where('avg_all.average_rate','=',$request->rate_star)
                        ->orWhere('avg_all.average_rate','>',$request->rate_star)
                        ->groupBy('book.id')
                        ->paginate(5);
                    }
                }
            }               
            }
        // return $book->get();
    }
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
