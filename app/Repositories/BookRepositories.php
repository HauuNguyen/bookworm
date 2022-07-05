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
        return $this->query->paginate(12); //all ??
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
    public function getListOfRating($num_star){
        $avg = $this->query
        ->  join('review','book.id','=','review.book_id')
        ->  select('book.id',DB::raw('round(AVG(rating_start),1) as averagestar'))
        ->  groupBy('book.id');
        $sub = $this->query 
        -> joinSub($avg,'avg',function ($join){
            $join-> on('avg.id','=','book.id') ;
        })
        ->select('book.*','avg.averagestar')
        -> where('avg.averagestar','>=',$num_star)
                    //[  'avg.averagestar','<',1+$num_star],])
        ->groupBy('avg.averagestar','book.id')
        ->orderBy('avg.averagestar')
        -> get();
        return $sub ;
    }
    public function getCategories(){
        //return $this->category->orderBy('category_name')->get(); //Get id of Cate
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
        ->join('author','author.id','=','book.author_id')
        -> selectRaw('book.book_title,author.author_name,book.book_cover_photo,book.book_price,(book.book_price-discount.discount_price) as getdiscount')
        -> where([  [  'discount.discount_start_date','<=',today()],
                    [  'discount.discount_end_date','>=',today()],])
        -> orwhere([[  'discount.discount_start_date','<=',today()], 
                    [  'discount.discount_end_date','=',null],])
        -> orderBy('getdiscount','desc')
        -> take(10)
        -> get();
        return $discount;
    } 
    
    public function finalPrice()
    {
        $bookrcm = $this->query 
            ->  leftJoin('discount','book.id','=','discount.book_id')
            ->  selectRaw('book.id,
                (case  when    discount.discount_start_date <= current_date
                        and (   discount.discount_end_date >= current_date or 
                                discount.discount_end_date is null )    
                        then discount.discount_price
                        else book.book_price end  ) as finalprice
                '
            )
            ->groupBy('book.id','finalprice')
            ->get();
            return $bookrcm ;
    }

    public function getRecommendBooks(){

        $recommend = $this->query
            ->join('review','book.id','=','review.book_id')
            -> select('book.id',DB::raw('round(AVG(rating_start),1) as averagestar'))
            -> groupBy('book.id');
        
        $sub = $this->query 
        -> joinSub($recommend,'recommend',function ($join){
            $join-> on('recommend.id','=','book.id') ;
        })
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->join('author','book.author_id','=','author.id')
        ->  selectRaw('     book.id,book.book_title,book.book_price,author.author_name,book.book_cover_photo,recommend.averagestar ,
                            (case   when    discount.discount_start_date <= current_date
                                    and (   discount.discount_end_date >= current_date or 
                                            discount.discount_end_date is null )    
                                    then discount.discount_price
                                    else book.book_price end  ) as finalprice     ' )

        ->groupBy('book.id','recommend.averagestar','finalprice','book.book_title','author.author_name','book.book_price')
        -> orderBy('recommend.averagestar','desc')->orderby('finalprice')
        ->take(8)
        -> get();
        return $sub ;
        // $recommend = $this->query
        //     -> join('review','book.id','=','review.book_id')
        //     -> select('book.*',DB::raw('round(AVG(rating_start),1) as averagestar'))
        //     -> groupBy('book.id')
        //     -> orderBy('averagestar','desc')
        //     -> get();
        // return $recommend ;
    } 

    public function getMostPopularBooks(){
        $mostreview = $this -> query
            -> leftjoin('review','review.book_id','=','book.id')
            -> select('book.id',DB::raw('COUNT(review.book_id) as total_review'))
            -> groupBy('book.id') ;
        $sub = $this->query 
        -> joinSub($mostreview,'mostreview',function ($join){
            $join-> on('mostreview.id','=','book.id') ;
        })
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->join('author','book.author_id','=','author.id')
        ->  selectRaw('     book.id,book.book_price,mostreview.total_review ,book.book_title,book.book_price,author.author_name,book.book_cover_photo,
                            (case   when    discount.discount_start_date <= current_date
                                    and (   discount.discount_end_date >= current_date or 
                                            discount.discount_end_date is null )    
                                    then discount.discount_price
                                    else book.book_price end  ) as finalprice     ' )

        ->  groupBy('book.id','mostreview.total_review','finalprice','book.book_title','author.author_name','book.book_cover_photo')
        ->  orderBy('mostreview.total_review','desc')->orderby('finalprice')
        ->  take(8)
        ->  get() ;
        return $sub ;
    }
    public function sortBySale(){
         return  $this->query
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('     book.id,
                             (case   when    discount.discount_start_date <= current_date
                                     and (   discount.discount_end_date >= current_date or 
                                             discount.discount_end_date is null )    
                                     then discount.discount_price
                                     else book.book_price end  ) as finalprice ,
                                     (case   when    discount.discount_start_date <= current_date
                                     and (   discount.discount_end_date >= current_date or 
                                             discount.discount_end_date is null )    
                                     then (book.book_price-discount.discount_price)
                                     else 0 end  ) as sub    ' )
 
        -> groupBy('book.id','finalprice', 'sub')
        ->  orderBy('sub','desc')->orderBy('finalprice')
        ->  get();
    }
    public function sortByPopular(){
        $mostreview = $this -> query
            -> leftjoin('review','review.book_id','=','book.id')
            -> select('book.id',DB::raw('COUNT(review.book_id) as total_review'))
            -> groupBy('book.id') ;
        $sub = $this->query 
        -> joinSub($mostreview,'mostreview',function ($join){
            $join-> on('mostreview.id','=','book.id') ;
        })
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('     book.id,book.book_price,mostreview.total_review ,
                            (case   when    discount.discount_start_date <= current_date
                                    and (   discount.discount_end_date >= current_date or 
                                            discount.discount_end_date is null )    
                                    then discount.discount_price
                                    else book.book_price end  ) as finalprice     ' )

        ->  groupBy('book.id','mostreview.total_review','finalprice')
        ->  orderBy('mostreview.total_review','desc')->orderby('finalprice')
        ->  get() ;
        return $sub ;       
    }

    public function sortByPriceLowToHigh(){
        $sort = $this -> finalPrice() ;
        return $this->query
        -> joinSub($sort,'sort',function ($join){
            $join-> on('sort.id','=','book.id') ;
        })
        ->orderBy('sort.finalprice')
        ->get();
    }
    public function sortByPriceHighToLow(){
        $sort = $this -> finalPrice() ;
        return $this->query
        -> joinSub($sort,'sort',function ($join){
            $join-> on('sort.id','=','book.id') ;
        })
        ->orderBy('sort.finalprice','desc')
        ->get();
    }
} 