<footer class="rbt-footer footer-style-1 bg-color-white overflow-hidden">
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <div class="logo logo-dark">
                            <a href="">
                                <img src="{{ asset('images/logo/logo-light.webp') }}" alt="Cao đẳng Việt Mỹ logo" style="max-height: 100px">
                            </a>
                        </div>
                        <div class="logo d-none logo-light">
                            <a href="">
                                <img src="{{ asset('images/logo/logo-dark.webp') }}" alt="Cao đẳng Việt Mỹ logo" style="max-height: 100px">
                            </a>
                        </div>
                        <p class="description mt--20">
                            Hệ thống quản lý học tập trực tuyến (LMS) chính thức của <strong>Cao đẳng Việt Mỹ</strong>.
                            Nơi sinh viên tiếp cận bài giảng, tài liệu và lộ trình đào tạo chuẩn quốc tế.
                        </p>
                        <ul class="social-icon social-default justify-content-start">
                            <li>
                                <a href="https://www.facebook.com/caodangvietmy" target="_blank"><i class="feather-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/c/CaođẳngViệtMỹAPC" target="_blank"><i class="feather-youtube"></i></a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@caodangvietmy" target="_blank"><i class="feather-video"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">Dành cho Sinh viên</h5>
                        <ul class="ft-link">
                            <li><a href="{{ route('page.home') }}">Trang chủ LMS</a></li>
                            <li><a href="#">Kho khóa học</a></li>
                            <li><a href="#">Thư viện số</a></li>
                            <li><a href="#">Tra cứu điểm</a></li>
                            <li><a href="#">Hỗ trợ kỹ thuật</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">Cổng thông tin</h5>
                        <ul class="ft-link">
                            <li>
                                <a href="https://www.caodangvietmy.edu.vn/" target="_blank" class="text-danger fw-bold">
                                    🌐 Website Trường
                                </a>
                            </li>
                            <li><a href="https://ums.caodangvietmy.edu.vn/" target="_blank">Cổng đào tạo (UMS)</a></li>
                            <li><a href="https://www.caodangvietmy.edu.vn/tuyen-sinh/" target="_blank">Thông tin tuyển
                                    sinh</a></li>
                            <li><a href="https://www.caodangvietmy.edu.vn/tin-tuc-su-kien/" target="_blank">Tin tức & Sự
                                    kiện</a></li>
                            <li><a href="#">Cơ hội việc làm</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">Liên hệ đào tạo</h5>
                        <ul class="ft-link">
                            <li><span>Hotline:</span> <a href="tel:0911139776">0911 139 776</a></li>
                            <li><span>Email:</span> <a href="mailto:phongdaotao@caodangvietmy.edu.vn">phongdaotao@caodangvietmy.edu.vn</a>
                            </li>

                            <li class="mt-3"><span><strong>Cơ sở Trung Sơn:</strong></span> <br>
                                5-7-9-11 Đường số 4, KDC Trung Sơn, Bình Chánh, TP.HCM
                            </li>
                            <li class="mt-2"><span><strong>Cơ sở Gò Vấp:</strong></span> <br>
                                1A Nguyễn Văn Lượng, P.6, Q.Gò Vấp, TP.HCM
                            </li>
                            <li class="mt-2"><span><strong>Cơ sở Cần Thơ:</strong></span> <br>
                                133Bis Trần Hưng Đạo, P.An Phú, Q.Ninh Kiều, TP.Cần Thơ
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-area copyright-style-1 ptb--20">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                    <p class="rbt-link-hover text-center text-lg-start">Copyright © {{ date('Y') }} Cao đẳng Việt Mỹ.
                        All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
