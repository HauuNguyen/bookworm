import React from 'react';
import ReactDOM from 'react-dom';
import Header from './Header' ;
import Home from '../components/home/homepage';
import {HashRouter, Route, Routes} from 'react-router-dom';
import Footer from './Footer';
import About from './About';
import Product from './Product';
import Shop from './Shop';
ReactDOM.render( 
    
    <HashRouter>
        <Header />
        <Routes>
            <Route path = "/homepage"   element={<Home />}>     </Route>
            <Route path = "/aboutus"    element={<About />}>    </Route>
            <Route path = "/product"    element={<Product/>}>   </Route>
            <Route path = "/shop"       element={<Shop/>}>      </Route>
        </Routes>
        <Footer />
    </HashRouter>,
    document.getElementById('root')

);


