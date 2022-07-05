import '../css/product.css' ;
import img from '../assets/bookcover/book1.jpg';
function Product() {
    return (

        <div className="container">
            <div class="row">
                <div class="col">
                    <div className="col-lg-8 border p-3 main-section bg-white">
                        <div className="row hedding m-0 pl-3 pt-0 pb-3">
                            Category Name
                        </div>
                    <div className="row m-0">
                        <div className="col-lg-4 left-side-product-box pb-3">
                            <img src={img} className="border p-3"></img>
                            <p>By (author): Huấn Hoa Hồng</p>
                        </div>
                    <div className="col-lg-8">
                        <div className="right-side-pro-detail border p-3 m-0">
                            <div className="row">
                                <div className="col-lg-12 pt-2">
                                    <h5>Book Title</h5>
                                    <span>Nữ sắc suy cho cùng cũng chỉ là da với thịt, máu mủ tanh hôi.Cái bẫy luân hồi đau khổ vô lượng kiếp, sa chân vào lục dục biết bao giờ mới thoát khỏi? Đừng vì thế mà sinh lòng lưu luyến</span>
                            <hr className="m-0 pt-2 mt-2"></hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
                <div class="col">
                <div className="col-lg-8 border p-3 main-section bg-white">
                        <div className="row hedding m-0 pl-3 pt-0 pb-3">
                            Category Name
                        </div>
                    <div className="row m-0">
                        <div className="col-lg-4 left-side-product-box pb-3">
                            <img src={img} className="border p-3"></img>
                            <p>By (author): Huấn Hoa Hồng</p>
                        </div>
                    <div className="col-lg-8">
                        <div className="right-side-pro-detail border p-3 m-0">
                            <div className="row">
                                <div className="col-lg-12 pt-2">
                                    <h5>Book Title</h5>
                                    <span>Nữ sắc suy cho cùng cũng chỉ là da với thịt, máu mủ tanh hôi.Cái bẫy luân hồi đau khổ vô lượng kiếp, sa chân vào lục dục biết bao giờ mới thoát khỏi? Đừng vì thế mà sinh lòng lưu luyến</span>
                            <hr className="m-0 pt-2 mt-2"></hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        
    </div>
      );
}

export default Product;