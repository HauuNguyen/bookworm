import React from 'react';
import ReactDOM from 'react-dom';
import Header from './Header' ;
import Home from '../components/home/homepage';
import {HashRouter, Route, Routes} from 'react-router-dom';
import Footer from './Footer';

ReactDOM.render( 
    
    <HashRouter>
        <Header />
        <Routes>
            <Route path = "/homepage" element={<Home />}></Route>
        </Routes>
        <Footer />
    </HashRouter>,
    document.getElementById('root')

);
// function App(){
//     return (
//         <div className='App'>
//             <Header />
//             <h1>BookWorm</h1>
//         </div>
//         <h1>Hello</h1>
//     );
// }
export default App ;
