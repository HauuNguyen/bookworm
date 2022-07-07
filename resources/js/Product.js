import '../css/product.css' ;
import { QuantityPicker } from "react-qty-picker";
import React from 'react';
import { useState } from 'react';
import { useEffect } from 'react';
import axios from 'axios';
import { bookCoverPhoto } from "./bookcoverphoto";

function Product() {
    const id = window.location.href.split("http://127.0.0.1:8000/#/product/");
    const numid = id[1];
        const darta = [
            { max: 0 },
          ];
    const[bookdetail,setDetail] = useState([]) ;
    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8000/api/book/${numid}`)
            .then((result)=>{
                setDetail(result.data);
            })
            .catch((error)=>console.log(error));
    }, []);
    
    return (

        <div className="container">
        {   bookdetail.map((books)=>
            <div class="row">
            <div class="column1">
            <div className="col-lg-8 border p-3 main-section bg-white">
                    <div className="row hedding m-0 pl-3 pt-0 pb-3">
                        Category Name: {books.category_name}
                    </div>
                <div className="row m-0">
                    <div className="col-lg-4 left-side-product-box pb-3" key={books}>
                        <img   src={bookCoverPhoto[books.book_cover_photo]} alt={books.book_cover_photo}className="border p-3"/> 
                    </div>
                <div className="col-lg-8">
                    <div className="right-side-pro-detail border p-3 m-0">
                        <div className="row">
                            <div className="col-lg-12 pt-2">
                                <h5>{books.book_title}</h5>
                                <p>Book Description</p>
                                <span>{books.book_summary}</span>
                                <hr className="m-0 pt-2 mt-2"></hr>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="column2">
            <div className="col-lg-8 border p-3 main-section1 bg-white">
                    <div className="row hedding m-0 pl-3 pt-0 pb-3">
                        <strike>{books.book_price}</strike><b>{books.finalprice}</b>
                    </div>
                <div className="row m-0">
                <div className="quantitycart">
                    <div className="right-side-pro-detail border p-3 m-0">
                        <div className="row">
                            <div className="col-lg-12 pt-2">
                                <h5>Quanity</h5>
                                <div>
                                    {darta.map((data) => (
                                <div className="App">
                                    <QuantityPicker min={data.max} />
                                </div>
                                ))}
                            </div>
                            </div>


                        </div>

                    </div>
                    <br></br>
                    <div>
                    <button type="button" className="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </div>
            </div>
            </div>

        </div>
        )

        }

            </div>

        

      );
}


export default Product;