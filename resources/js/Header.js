import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import Button from 'react-bootstrap/esm/Button';
import NavDropdown from 'react-bootstrap/NavDropdown';
import logo from '../assets/bookworm_icon.svg'  ;
import { useState } from 'react';
import { Modal } from 'react-bootstrap';
import Login from './login';
import { CloseButton } from 'react-bootstrap';
import '../css/login.css'
function Header() {
      const [show, setShow] = useState(false);

      const handleClose = () => setShow(false);
      const handleShow = () => setShow(true);
  
    return (
        <>
          <Navbar bg="white" variant="white">
            <Container>
                <Navbar.Brand href="/#/homepage">
                    <img
                        alt=""
                        src={logo}
                        width="32"
                        height="32"
                        className="d-inline-block align-top"
                        />
                            BOOKWORM
                </Navbar.Brand>
                <Nav>
                    <Nav.Link href="/#/homepage">Home</Nav.Link>  
                    <Nav.Link href="/#/shop">Shop</Nav.Link>
                    <Nav.Link href="/#/aboutus">About</Nav.Link>
                    <Nav.Link href="/#/cart">Cart</Nav.Link>
                    {/* <Button href="/#/login">Sign in</Button>{' '} */}
                    <Button variant="primary" onClick={handleShow}>
                      Sign In
                    </Button>

                    <Modal show={show} onHide={handleClose}>
                      <Modal.Header >
                        <Modal.Title><h3>Sign In</h3></Modal.Title>
                      </Modal.Header>
                      <Modal.Body><Login/></Modal.Body>
                      <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose}>
                          Close
                        </Button>
                        <Button variant="primary" onClick={handleClose}>
                          Save Changes
                        </Button>
                      </Modal.Footer>
                    </Modal> {' '}
                    

                </Nav>  
                
            </Container>
          </Navbar>
        </>
      );
}

export default Header;