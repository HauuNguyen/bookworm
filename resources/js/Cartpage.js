import React from 'react';
import { QuantityPicker } from "react-qty-picker";
import '../css/cart.css';
import img from "../assets/bookcover/book1.jpg";
import { Button } from 'react-bootstrap';

function Cart()
{ const darta = [
    { max: 0 },
  ];
    return (
        <div className="container">
            <div class="row">
        <div className="cart">
                <div class="row">
                <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light">
                            <div class="p-2 px-3 text-uppercase">Product</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Price</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Quantity</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Total</div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row" class="border-0">
                            <div class="p-2">
                                <img src={img} alt="books" width="70" class="img-fluid rounded shadow-sm" />
                                <div class="ms-3 d-inline-block align-middle">
                                <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">Product 1</a></h5>
                                <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">Auth Name</a></h5>
                                </div>
                            </div>
                            </th>
                            <td class="border-0 align-middle"><strong>...$</strong></td>
                            <td class="border-0 align-middle">                                
                            <div className='quantity'>
                                    {darta.map((data) => (
                                <div className="App">
                                    <QuantityPicker min={data.max} />
                                </div>
                                ))}
                            </div></td>
                            <td class="border-0 align-middle"><strong>...$</strong></td>
                            <td class="border-0 align-middle"><a href="#" class="text-dark"><i class="bi bi-trash"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>   
                </div>


            </div>
            <div className="cart2">
                <div class="row">
                <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light">
                            <h5>Cart Totals</h5>
                            
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row" class="border-0">
                            <div class="p-2">
                                Totals
                                <br></br>
                                ...$
                                <div className='buttonfix'>
                                <Button variant="primary">Order</Button>{' '}
                                </div>
                                
                            </div>
                            </th>

                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>   
                </div>


            </div>                         
                </div>
        </div>
      
    )
}
export default Cart;