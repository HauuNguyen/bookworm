import React from 'react';
import ReactDOM from 'react-dom';
import Header from './Header' ;
import Home from '../components/home/homepage';
import {HashRouter, Route, Routes} from 'react-router-dom';
import Footer from './Footer';
import About from './About';
import Product from './Product';
import Shop from './Shop';
import Login from './login';
import Popular from './popular';
import Recommend from './recommend';
import Cart from './Cartpage' ;
ReactDOM.render( 
    
    <HashRouter>
        <Header />
        <Routes>
            <Route path = "/homepage"   element={<Home />}>     </Route>
            <Route path = "/aboutus"    element={<About />}>    </Route>
            <Route path = "/product/:id"element={<Product/>}>   </Route>
            <Route path = "/shop"       element={<Shop/>}>      </Route>
            <Route path = "/login"      element={<Login/>}>      </Route>
            <Route path = "/popular"    element={<Popular/>}>      </Route>
            <Route path = "/recommend"  element={<Recommend/>}>      </Route>
            <Route path = "/cart"       element={<Cart/>}>      </Route>
        </Routes>
        <Footer />
    </HashRouter>,
    document.getElementById('root')

);


