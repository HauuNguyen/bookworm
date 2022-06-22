<?php

namespace App\Repositories ;

use App\Models\Book ;
use App\Models\Category;
use App\Models\Author ;
use App\Models\Discount;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class BookRepositories {

    public function __construct()
    {
        $this -> query = Book::query() ;
        $this -> category = Category::query(); 
        $this -> author = Author::query();
        $this -> review = Review::query();
        $this -> discount = Discount::query();
    }
    public function getById($id)
    {
        if($id){
            return $this->query->find($id);
        }
        return $this->query->get(); //all ??
    }
    public function getReview($book_id,$review_id)
    {
        if($review_id){
            return $this->query->find($book_id)->bookReview()->where('id',$review_id)->get();
        }
        return $this->query->find($book_id)->bookReview()->get();
    }

    public function getAvgRating($book_id){
        return $this->review->where('book_id',$book_id)->avg('rating_start');
    }

    public function getCategories(){
        //return $this -> category->orderBy('category_name')->get(); //Get id of Cate
        $cate = $this->query
        -> join('category','book.category_id','=','category.id')
        -> select('category.category_name')->distinct()
        -> get();
        return $cate;
    }    

    public function getAllBookOfCate($category_id=null){

        $cateId = $this->query->where('category_id', $category_id)->get();
        return $cateId;
    }
    public function getAllAuthors(){
        //return $this -> author ->orderBy('author_name')->get();
        $auth = $this->query
        -> join('author','book.author_id','=','author.id')
        -> select('author.author_name')->distinct()
        -> get();
        return $auth;
    }    
    public function getAllBooksOfAuthor($author_id)
    {
        $authId = $this->query->where('author_id', $author_id)->get();
        return $authId;
    }
    public function getTop10DiscountBooks(){
        $discount =  $this->query
            -> join('discount','discount.book_id','=','book.id')
            -> selectRaw('book.*,(book.book_price-discount.discount_price) as getdiscount')
            -> where([  [  'discount.discount_start_date','<=',today()],
                        [  'discount.discount_end_date','>=',today()],])
            -> orwhere([[  'discount.discount_start_date','<=',today()], 
                        [  'discount.discount_end_date','=',null],])
            -> orderBy('getdiscount','desc')
            -> take(10)
            -> get();
        return $discount;
    } 


    public function getRecommendBooks(){
        $recommend = $this->query
            -> join('review','book.id','=','review.book_id')
            -> select('book.*',DB::raw('round(AVG(rating_start),1) as averagestar'))
            -> groupBy('book.id')
            -> orderBy('averagestar','desc')
            -> take(8)
            -> get();
        return $recommend ;
    } 
    public function topRecommend()
    {
        $bookrcm = $this->query 
            ->  join('discount','book.id','=','discount.book_id')
            ->  selectRaw(
                'case   when    discount.discount_start_date <= current_date
                        and (   discount.discount_end_date >= current_date or 
                                discount.discount_end_date is null )    
                        then discount.discount_price
                        else book.book_price    
                '
            );
            return $bookrcm ;
    }

}