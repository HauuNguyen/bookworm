<?php

namespace App\Repositories ;

use App\Models\Book ;
use App\Models\Review ;
use App\Repositories\BaseRepositories;

class BookRepositories extends BaseRepositories {

    public function __construct()
    {
        $this -> query = Book::query() ;
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
}