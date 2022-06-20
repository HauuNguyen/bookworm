<?php 

namespace App\Repositories ;

abstract class BaseRepositories {
    protected $query ;
    public abstract function getById($id) ;
    public abstract function getReview($book_id,$review_id);
}