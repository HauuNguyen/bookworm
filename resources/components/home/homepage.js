import "./homepage.css";
import { Button } from 'reactstrap';


import React, {Component} from "react";
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Autoplay } from "swiper";
import "swiper/css/navigation";
import 'swiper/css';
import axios from "axios";
import { bookCoverPhoto } from "../../js/bookcoverphoto";
import StarRatings from "react-star-ratings";

class Home extends Component {
    state = {
        books:[],
        rcm:[],
        ppl:[]
    }

    async componentDidMount(){
        const discount = await axios.get('http://127.0.0.1:8000/api/books/discount').then(respone=>{
            this.setState({books:respone.data});
        });
        const recommend = await axios.get('http://127.0.0.1:8000/api/recommend/books').then(respone=>{
            this.setState({rcm:respone.data});
        });
        const poppular = await axios.get('http://127.0.0.1:8000/api/popular/books').then(respone=>{
            this.setState({ppl:respone.data});
        });
        await Promise.all([discount,recommend,poppular]);
    }
    render(){


    return (
    <section className="home-page">
        <div className="container">
            <div className="row align-items-center mb-4">
                <div className="col-lg-6">
                    <h4>On Sale</h4>
                </div>
                <div className="col-lg-6 d-flex justify-content-end">
                    <Button color="primary" size="sm" href="/#/shop">
                        View All &nbsp; <i class="fas fa-angle-right"></i> 
                    </Button>
                </div>
            </div>
            <Swiper 
                spaceBetween={50} 
                slidesPerView={4} 
                navigation={true} 
                loop={true}
                loopFillGroupWithBlank={true}
                modules={[Autoplay, Navigation]}
                autoplay={{
                    delay: 2500,
                    disableOnInteraction: false,
                }}
            >
                {
                //arraySrcBook2.map(book => {   
                this.state.books.map(book=>{
                    return (
                        <SwiperSlide key={book} className="carousel">
                            {/* <div className="card">
                                <div className="card p-2">
                                <a className="card-block stretched-link text-decoration-none text-dark" href="#">
                                <img className="card-img-top img-fluid" src={bookCoverPhoto[book.book_cover_photo]} alt="Books" />
                                <div className="card-body">
                                    <p className="book-title font-18px">{book.book_title}</p>
                                    <p className="book-author font-14px">{book.author_name}</p>
                                </div>
                                <div className="card-footer text-muted font-14px"><strike>{book.book_price}$</strike>&nbsp;<b>{book.getdiscount}$</b></div>
        
                                </a>
                            </div>
                            </div> */}
                            <div className="card">
                                <img className="card-img-top img-fluid" src={bookCoverPhoto[book.book_cover_photo]} alt="Books" />
                                <div className="card-body">
                                    <a href="#" className="text-decoration-none"><p className="book-title font-18px">{book.book_title}</p></a>
                                    <p className="book-author font-14px">{book.author_name}</p>
                                    <StarRatings
                                        rating={Number(book.averagestar)}
                                        starRatedColor='yellow'
                                        starDimension="20px"
                                        starSpacing="10px"
                                    />
                                </div>
                                <div className="card-footer text-muted font-14px"><strike>{book.book_price}$</strike>&nbsp;<b>{book.getdiscount}$</b></div>
                            </div>
                        </SwiperSlide>)})
                })

            </Swiper>
            <div className="book-list">
                <div className="text-center">
                    <p className="section-title font-20px mb-3"><h4>Featured Books</h4></p>
                    <div className="mb-4">
                    <div className="btn-rcm-ppl">
                    
                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Recommend
                        </a> &ensp;
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                            Popular
                        </button>
                       
                    </div>

                    </div>
                </div>
                    <div class="collapse" id="collapseExample">
                            <p>8 Most recommend books</p>
                            <div class="card card-body">
                            <div id="mainRow" className="row">
                                {
                                    this.state.rcm.map(book1 => {
                                        return (
                                        <div className="col-lg-3 col-md-4 col-sm-6 mb-4" key={book1}>
                                            <div className="card">
                                            <img className="card-img-top img-fluid" src={bookCoverPhoto[book1.book_cover_photo]} alt={book1.book_cover_photo} />
                                                <div className="card-body">
                                                <a href="#" className="text-decoration-none"><p className="book-title font-18px ">{book1.book_title}</p></a>
                                                    <p className="book-author font-14px">{book1.author_name}</p>
                                                    <StarRatings
                                                        rating={Number(book1.averagestar) }
                                                        starRatedColor='yellow'
                                                        starDimension="20px"
                                                        starSpacing="10px"
                                                    />
                                                </div>
                                                <div className="card-footer text-muted font-14px"><strike>{book1.book_price}$</strike>&nbsp;<b>{book1.finalprice}$</b></div>
                                            </div>
                                        </div>
                                        )
                                    })
                                }
                            </div>
                        </div>
                    </div>
                        <div class="collapse" id="collapseExample1">
                            <p>8 Most popular books</p>
                            <div class="card card-body">
                            <div id="mainRow" className="row">
                                {
                                    this.state.ppl.map(book2 => {
                                        return (
                                        <div className="col-lg-3 col-md-4 col-sm-6 mb-4" key={book2}>
                                            <div className="card">
                                            <img className="card-img-top img-fluid" src={bookCoverPhoto[book2.book_cover_photo]} alt={book2.book_cover_photo} />
                                                <div className="card-body">
                                                <a href="#" className="text-decoration-none"><p className="book-title font-18px ">{book2.book_title}</p></a>
                                                    <p className="book-author font-14px">{book2.author_name}</p>
                                                    <StarRatings
                                                        rating={Number(book2.averagestar)}
                                                        starRatedColor='yellow'
                                                        starDimension="20px"
                                                        starSpacing="10px"
                                                    />
                                                </div>
                                                <div className="card-footer text-muted font-14px"><strike>{book2.book_price}$</strike>&nbsp;<b>{book2.finalprice}$</b></div>
                                            </div>
                                        </div>
                                        )
                                        })
                                }
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        
    </section>
    );
    }
}

export default Home;  