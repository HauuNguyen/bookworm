import Container from 'react-bootstrap/Container';
import Navbar from 'react-bootstrap/Navbar';
import logo from '../assets/bookworm_icon.svg'  ;
import '../css/footer.css'
function Footer() {
  return (
    <Navbar>
      <Container>
        <Navbar.Brand >
            <img
                alt=""
                src={logo}
                width="80"
                height="80"
                className="d-inline-block align-top"
            />

            
        </Navbar.Brand>
        <h6>BOOKWORM<br/>Nguyen Cong Hau <br/> 0378162030</h6>

        
      </Container>
    </Navbar>
  );
}

export default Footer;