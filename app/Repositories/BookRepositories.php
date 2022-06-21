<?php

namespace App\Repositories ;

use App\Models\Book ;
use App\Models\Category;
use App\Models\Author ;


class BookRepositories {

    public function __construct()
    {
        $this -> query = Book::query() ;
        $this -> category = Category::query(); 
        $this -> author = Author::query();
        
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
} 