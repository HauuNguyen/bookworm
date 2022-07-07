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
import { Tabs } from "react-bootstrap";
import Tab from "react-bootstrap";
import Popular from "../../js/popular";
import Recommend from "../../js/recommend";
class Home extends Component {
    state = {
        books:[]
    }
    async componentDidMount(){
        await axios.get('http://127.0.0.1:8000/api/books/discount').then(respone=>{
            this.setState({books:respone.data});
        })
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
                            <a href={`/#/product/${book.id}`} className="card">
                                <img className="card-img-top img-fluid" src={bookCoverPhoto[book.book_cover_photo]} alt="Books" />
                                <div className="card-body">
                                    <div className="text-decoration-none"><p className="book-title font-18px">{book.book_title}</p></div>
                                    <p className="book-author font-14px">{book.author_name}</p>
                                    <StarRatings
                                        rating={Number(book.averagestar)}
                                        starRatedColor='yellow'
                                        starDimension="20px"
                                        starSpacing="10px"
                                    />
                                </div>
                                <div className="card-footer text-muted font-14px"><strike>{book.book_price}$</strike>&nbsp;<b>{book.getdiscount}$</b></div>
                            </a>
                        </SwiperSlide>)})
                }

            </Swiper>
            <div className="hahahaha">
                <h4>Feature Books</h4>
            </div>
            
            
            <Tabs defaultActiveKey="profile" id="uncontrolled-tab-example" className="mb-3">
                <Tab eventKey="home" title="Recommend">
                    <Recommend/>
                </Tab>
                <Tab eventKey="profile" title="Popular">
                    <Popular/>
                </Tab>
            </Tabs>
            </div>
        
    </section>
    );
    }
}

export default Home;  