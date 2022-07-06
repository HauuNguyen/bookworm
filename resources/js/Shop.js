import "../components/home/homepage.css";
import { bookCoverPhoto } from "./bookcoverphoto";
import React from "react";
import Pagination from 'react-bootstrap/Pagination'
import axios from 'axios';
import Accordion from 'react-bootstrap/Accordion';
class Shop extends React.Component {
    

    constructor(props){
        super(props);
    
        this.state = {
            booklist:[],
            categories:[],
            authors:[],
        
        };
    }
    async componentDidMount(){
        const getallbook = await axios.get('http://127.0.0.1:8000/api/books/onsale').then(result =>{
            const booklist = result.data.data;
            this.setState({booklist:booklist});
        })
        const category = await axios.get(' http://127.0.0.1:8000/api/categories').then(respone=>{
            this.setState({categories:respone.data});
        });
        const author = await axios.get('http://127.0.0.1:8000/api/authors').then(respone=>{
            this.setState({authors:respone.data});
        });
        // const getcategoryname = await axios.get('http://127.0.0.1:8000/api/categories').then(result =>{
        //     const categoryname = result.data.data;
        //     this.setState({categoryname:categoryname});
        // })
        // await Promise.all([getallbook,getcategoryname]);
        await Promise.all([getallbook,category,author]);
        
    }
    render() {
        return (
            <section> 
                <div className="container">
                    <div className="row">
                            <div className="col-md-12 title-shop-page">
                                <p> <b>Books</b> (filter by category #1)</p>
                                <hr/> 
                            </div>
                    </div>
                    
                    <div className="row shop-page-list">
                        <div className="col-md-2">
                            <div className="row">
                                <div className="col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h3 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Category
                                        </button>
                                        </h3>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                                <table className="table">
                                                <tbody>
                                                {
                                                    this.state.categories.map(cate => {
                                                        return (
                                                            <tr><td><a href="#">{cate.category_name}</a></td></tr>
                                                        )
                                                    })
                                                }
                                                </tbody>
                                                </table>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Author
                                        </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table className="table">
                                                <tbody>
                                                {
                                                    this.state.authors.map(auth => {
                                                        return (
                                                            <tr><td><a href="#">{auth.author_name}</a></td></tr>
                                                        )
                                                    })
                                                }
                                                </tbody>
                                                </table>                                        
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Star
                                        </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        <table className="table">
                                                <tbody>
                                                    <tr><td><a href="#">1 Star</a></td></tr>
                                                    <tr><td><a href="#">2 Star</a></td></tr>
                                                    <tr><td><a href="#">3 Star</a></td></tr>
                                                    <tr><td><a href="#">4 Star</a></td></tr>
                                                    <tr><td><a href="#">5 Star</a></td></tr>
                                                </tbody>
                                                </table>                                        
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    {/* <table className="table">
                                    <Accordion>
                                    <Accordion.Item >
                                    <Accordion.Header>Accordion Item #1</Accordion.Header>
                                    <Accordion.Body>          
                                        Hello
                                    </Accordion.Body>
                                    </Accordion.Item>
                                    </Accordion>
                                    </table>
                                </div>
                                <div className="col-md-12">
                                    <table className="table">
                                        <thead><th>Author</th></thead>
                                        <tbody>
                                            <tr><td><a href="#">Author #1</a></td></tr>
                                            <tr><td><a href="#">Author #2</a></td></tr>
                                            <tr><td><a href="#">Author #3</a></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div className="col-md-12">
                                    <table className="table">
                                        <thead><th>rating Review</th></thead>
                                        <tbody>
                                            <tr><td>1 Star</td></tr>
                                            <tr><td>2 Star</td></tr>
                                            <tr><td>3 Star</td></tr>
                                            <tr><td>4 Star</td></tr>
                                            <tr><td>5 Star</td></tr>
                                        </tbody>
                                    </table> */}
                                </div>
                            </div>
                        </div>
                        <div className="col-md-10">
                            <div className="row">
                                <div className="col-md-3">
                                    showing 1-12 of 126 books
                                </div>
                                <div className="col-md-9">
                                   <div className="row">
                                    <div className="col-md-6">
                                    <div class="btn-group btn-sort1">
                                        <button class="btn btn-secondary dropdown-toggle " type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                           Sort By 
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                            <li><a class="dropdown-item" href="#">Sort By Sale</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Review</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Price Low to High</a></li>
                                            <li><a class="dropdown-item" href="#">Sort By Price High to Low</a></li>
                                        </ul>
                                    </div>
                                   
                                    </div>
                                    <div className="col-md-6">
                                    

                                    

                                    <div class="btn-group btn-sort2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                        Show
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                        <li><a class="dropdown-item" href="/shop-page?how=10">10</a></li>
                                        <li><a class="dropdown-item" href="/shop-page?how=20">20</a></li>
                                        <li><a class="dropdown-item" href="/shop-page?how=30">30</a></li>
                                    </ul>
                                    </div>
                                    </div>
                                   </div>
                                </div>
                                <div className="book-list">
                                <div className="col-md-12"> 
                                <div class="card card-body">
                            <div id="mainRow" className="row">
                                {
                                    this.state.booklist.map(book1 => {
                                        return (
                                        <div className="col-lg-3 col-md-4 col-sm-6 mb-4" key={book1}>
                                            <div className="card">
                                            <img className="card-img-top img-fluid" src={bookCoverPhoto[book1.book_cover_photo]} alt={book1.book_cover_photo} />
                                                <div className="card-body">
                                                <a href="/#/product/id" className="text-decoration-none"><p className="book-title font-18px ">{book1.book_title}</p></a>
                                                    <p className="book-author font-14px">{book1.author_name}</p>
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

                            </div>
                        </div>
                    </div>
                    <div>
                    <Pagination>
                        <Pagination.First />
                        <Pagination.Prev />
                        <Pagination.Item>{1}</Pagination.Item>
                        <Pagination.Ellipsis />

                        <Pagination.Item>{10}</Pagination.Item>
                        <Pagination.Item>{11}</Pagination.Item>
                        <Pagination.Item active>{12}</Pagination.Item>
                        <Pagination.Item>{13}</Pagination.Item>
                        <Pagination.Item disabled>{14}</Pagination.Item>

                        <Pagination.Ellipsis />
                        <Pagination.Item>{20}</Pagination.Item>
                        <Pagination.Next />
                        <Pagination.Last />
                    </Pagination>
                    </div>

                </div>
                
            </section>

        );
    }
}

export default Shop;  