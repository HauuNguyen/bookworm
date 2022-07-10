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
            $final = $this->query 
            ->  leftJoin('discount','book.id','=','discount.book_id')
            ->  selectRaw('book.id,
                (case  when    discount.discount_start_date <= current_date
                        and (   discount.discount_end_date >= current_date or 
                                discount.discount_end_date is null )    
                        then discount.discount_price
                        else book.book_price end  ) as finalprice
                '
            )
            ->groupBy('book.id','finalprice');
             $bookdetail = $this->query
             -> joinSub($final,'final',function($join){
                $join->on('final.id','=','book.id');
             })
            ->join('category','category.id','=','book.category_id')
            ->join('author','author.id','=','book.author_id')
            ->select('book.book_title','book_summary','book.book_price','final.finalprice','author.author_name','category.category_name','book.book_cover_photo')
            ->groupBy('book.book_title','book_summary','book.book_price','final.finalprice','author.author_name','category.category_name','book.book_cover_photo')
            ->where('book.id','=',$id)->get() ;
            return $bookdetail;
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
        -> select('category.category_name','category.id')->distinct()
        ->orderBy('category.category_name')
        -> get();
        return $cate;
    }    

    public function getAllBookOfCate($category_id=null){
        $recommend = $this->query 
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('book.id,
            (case  when    discount.discount_start_date <= current_date
                    and (   discount.discount_end_date >= current_date or 
                            discount.discount_end_date is null )    
                    then discount.discount_price
                    else book.book_price end  ) as finalprice
            '
        )
        ->groupBy('book.id','finalprice') ;
        $recommend = $this->query
        -> joinSub($recommend,'recommend',function ($join){
            $join-> on('recommend.id','=','book.id') ;
        })
        ->join('author','author.id','book.author_id')
        ->join('category','book.category_id','=','category.id')
        ->select('book.book_title','book.id','author.author_name','book.book_price','book.book_cover_photo','recommend.finalprice')
        ->groupBy('book.book_title','book.id','author.id','book.book_price','book.book_cover_photo','recommend.finalprice')
        ->where('category_id', $category_id)->paginate(12);
        return $recommend;
    }
    public function getAllAuthors(){
        $auth = $this->query
        -> join('author','book.author_id','=','author.id')
        -> select('author.author_name','author.id')->distinct()
        ->orderBy('author.author_name')
        -> get();
        return $auth;
    }    
    public function getAllBooksOfAuthor($author_id)
    {
        $recommend = $this->query 
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('book.id,
            (case  when    discount.discount_start_date <= current_date
                    and (   discount.discount_end_date >= current_date or 
                            discount.discount_end_date is null )    
                    then discount.discount_price
                    else book.book_price end  ) as finalprice
            '
        )
        ->groupBy('book.id','finalprice') ;
        $recommend = $this->query
        -> joinSub($recommend,'recommend',function ($join){
            $join-> on('recommend.id','=','book.id') ;
        })
        ->join('author','author.id','book.author_id')
        ->join('category','book.category_id','=','category.id')
        ->select('book.book_title','book.id','author.author_name','book.book_price','book.book_cover_photo','recommend.finalprice')
        ->groupBy('book.book_title','book.id','author.id','book.book_price','book.book_cover_photo','recommend.finalprice')
        ->where('author_id', $author_id)->paginate(12);
        return $recommend;
    }
    public function getTop10DiscountBooks(){
        $recommend = $this->query
        ->join('review','book.id','=','review.book_id')
        -> select('book.id',DB::raw('round(AVG(rating_start),1) as averagestar'))
        -> groupBy('book.id');
    
        $discount =  $this->query
        -> joinSub($recommend,'recommend',function ($join){
            $join-> on('recommend.id','=','book.id') ;
        })
        -> join('discount','discount.book_id','=','book.id')
        ->join('author','author.id','=','book.author_id')
        -> selectRaw('book.book_title,author.author_name,book.book_cover_photo,book.book_price,(book.book_price-discount.discount_price) as getdiscount,recommend.averagestar')
        -> where([  [  'discount.discount_start_date','<=',today()],
                    [  'discount.discount_end_date','>=',today()],])
        -> orwhere([[  'discount.discount_start_date','<=',today()], 
                    [  'discount.discount_end_date','=',null],])
        ->groupBy('book.book_title','author.author_name','book.book_cover_photo','book.book_price','recommend.averagestar','getdiscount')
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
        ->  join('author','book.author_id','=','author.id')
        ->  selectRaw('     book.id,book.book_title,book.book_price,author.author_name,book.book_cover_photo,recommend.averagestar,
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
    } 

    public function getMostPopularBooks(){
        $mostreview = $this -> query
            -> leftjoin('review','review.book_id','=','book.id')
            -> select('book.id',DB::raw('COUNT(review.book_id) as total_review'),DB::raw('round(AVG(rating_start),1) as averagestar'))
            -> groupBy('book.id') ;
        $sub = $this->query 
        -> joinSub($mostreview,'mostreview',function ($join){
            $join-> on('mostreview.id','=','book.id') ;
        })
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->join('author','book.author_id','=','author.id')
        ->  selectRaw('     book.id,book.book_price,mostreview.total_review ,mostreview.averagestar,book.book_title,book.book_price,author.author_name,book.book_cover_photo,
                            (case   when    discount.discount_start_date <= current_date
                                    and (   discount.discount_end_date >= current_date or 
                                            discount.discount_end_date is null )    
                                    then discount.discount_price
                                    else book.book_price end  ) as finalprice     ' )

        ->  groupBy('book.id','mostreview.total_review','finalprice','book.book_title','author.author_name','book.book_cover_photo','mostreview.averagestar')
        ->  orderBy('mostreview.total_review','desc')->orderby('finalprice')
        ->  take(8)
        ->  get() ;
        return $sub ;
    }
    public function sortBySale(){
         return  $this->query
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->join('author','author.id','=','book.author_id')
        ->  selectRaw('     book.id,book.book_title,author.author_name,book.book_price,book.book_cover_photo,
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
 
        -> groupBy('book.id','finalprice', 'sub','book.book_title','author.author_name','book.book_price','book.book_cover_photo')
        ->  orderBy('sub','desc')->orderBy('finalprice')
        ->  paginate(12);
    }
    public function sortByPopular(){
        $mostreview = $this -> query
            -> leftjoin('review','review.book_id','=','book.id')
            -> select('book.id',DB::raw('COUNT(review.book_id) as total_review'),DB::raw('round(AVG(rating_start),1) as averagestar'))
            -> groupBy('book.id') ;
        $sub = $this->query 
        -> joinSub($mostreview,'mostreview',function ($join){
            $join-> on('mostreview.id','=','book.id') ;
        })
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->join('author','book.author_id','=','author.id')
        ->  selectRaw('     book.id,book.book_price,mostreview.total_review ,mostreview.averagestar,book.book_title,book.book_price,author.author_name,book.book_cover_photo,
                            (case   when    discount.discount_start_date <= current_date
                                    and (   discount.discount_end_date >= current_date or 
                                            discount.discount_end_date is null )    
                                    then discount.discount_price
                                    else book.book_price end  ) as finalprice     ' )

        ->  groupBy('book.id','mostreview.total_review','finalprice','book.book_title','author.author_name','book.book_cover_photo','mostreview.averagestar')
        ->  orderBy('mostreview.total_review','desc')->orderby('finalprice')
        ->  paginate(12);
        return $sub ;       
    }

    public function sortByPriceLowToHigh(){
        $sort = $this->query 
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('book.id,
            (case  when    discount.discount_start_date <= current_date
                    and (   discount.discount_end_date >= current_date or 
                            discount.discount_end_date is null )    
                    then discount.discount_price
                    else book.book_price end  ) as finalprice
            '
        )
        ->groupBy('book.id','finalprice') ;
        return $this->query
        -> joinSub($sort,'sort',function ($join){
            $join-> on('sort.id','=','book.id') ;
        })
        ->join('author','author.id','=','book.author_id')
        ->join('review','review.book_id','=','book.id')
        ->select('book.id','book.book_title','book.book_price','author.author_name','book.book_cover_photo','sort.finalprice')
        ->groupBy('book.id','book.book_title','book.book_price','author.author_name','book.book_cover_photo','sort.finalprice') 
        ->orderBy('sort.finalprice','desc')
        ->paginate(12);
    }
    public function sortByPriceHighToLow(){
        $sort = $this->query 
        ->  leftJoin('discount','book.id','=','discount.book_id')
        ->  selectRaw('book.id,
            (case  when    discount.discount_start_date <= current_date
                    and (   discount.discount_end_date >= current_date or 
                            discount.discount_end_date is null )    
                    then discount.discount_price
                    else book.book_price end  ) as finalprice
            '
        )
        ->groupBy('book.id','finalprice') ;
        return $this->query
        -> joinSub($sort,'sort',function ($join){
            $join-> on('sort.id','=','book.id') ;
        })
        ->join('author','author.id','=','book.author_id')
        ->join('review','review.book_id','=','book.id')
        ->select('book.id','book.book_title','book.book_price','author.author_name','book.book_cover_photo','sort.finalprice')
        ->groupBy('book.id','book.book_title','book.book_price','author.author_name','book.book_cover_photo','sort.finalprice') 
        ->orderBy('sort.finalprice')
        ->paginate(12);
    }
} 