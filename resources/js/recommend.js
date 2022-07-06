import React,{ Component } from "react";
import "../components/home/homepage.css";
import axios from 'axios';
import { bookCoverPhoto } from "./bookcoverphoto";
import StarRatings from "react-star-ratings";
class Recommend extends Component{
    state = {
        recommends:[]
    }
    async componentDidMount(){
        await axios.get('http://127.0.0.1:8000/api/recommend/books').then(respone=>{
            this.setState({recommends:respone.data});
        })
    }

    render(){

        return (
            <section className="home-page">
            <div className="container">
                <div className="book-list">
                <div className="textmost">
                    <p>8 Most recommend books</p>
                </div>
                                <div class="card card-body">
                                <div id="mainRow" className="row">
                                    {
                                        this.state.recommends.map(book1 => {
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
                </div>
            
        </section>
        );
            

    }
}

export default Recommend;