import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import Button from 'react-bootstrap/esm/Button';
import NavDropdown from 'react-bootstrap/NavDropdown';
import logo from '../assets/bookworm_icon.svg'  ;
function Header() {
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
                    <Nav.Link href="#">Cart</Nav.Link>
                    <Button href="/#/login">Sign in</Button>{' '} 
                </Nav>  
                
            </Container>
          </Navbar>
        </>
      );
}

export default Header;