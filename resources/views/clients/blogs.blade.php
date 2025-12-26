@include('clients.blocks.header')
@include('clients.blocks.banner')

        <!-- Blog List Area start -->
        <section class="blog-list-page py-100 rel z-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-item style-three" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                            <div class="image">
                                <img src="assets/images/blog/blog-list1.jpg" alt="Blog List">
                            </div>
                            <div class="content">
                                <a href="blog.html" class="category">Du lịch </a>
                                <h5><a href="blog-details.html">Cẩm nang kỳ nghỉ hoàn hảo</a></h5>
                                <ul class="blog-meta">
                                    <li><i class="far fa-calendar-alt"></i> <a href="#">01/12/2024</a></li>
                                    <li><i class="far fa-comments"></i> <a href="#">Bình luận  (5)</a></li>
                                </ul>
                                <p>Mang đến những trải nghiệm thành phố khó quên cho những ai đam mê khám phá.</p>
                                <a href="blog-details.html" class="theme-btn style-two style-three">
                                    <span data-hover="Book Now">Xem thêm</span>
                                    <i class="fal fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="blog-item style-three" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                            <div class="image">
                                <img src="assets/images/blog/blog-list2.jpg" alt="Blog List">
                            </div>
                            <div class="content">
                                <a href="blog.html" class="category">Travel</a>
                                <h5><a href="blog-details.html">Cẩm nang kỳ nghỉ mơ ước</a></h5>
                                <ul class="blog-meta">
                                    <li><i class="far fa-calendar-alt"></i> <a href="#">02/14/2024</a></li>
                                    <li><i class="far fa-comments"></i> <a href="#">Bình luận  (5)</a></li>
                                </ul>
                                 
                            </div>
                        </div>
                         
                        <ul class="pagination pt-15 flex-wrap" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                            <li class="page-item disabled">
                                <span class="page-link"><i class="far fa-chevron-left"></i></span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">
                                    1
                                    <span class="sr-only">(current)</span>
                                </span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="far fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                        <div class="blog-sidebar">

                            <div class="widget widget-search" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <form action="#" class="default-search-form">
                                    <input type="text" placeholder="Search" required="">
                                    <button type="submit" class="searchbutton far fa-search"></button>
                                </form>
                            </div>

                            <div class="widget widget-category" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Loại du lịch </h5>
                                <ul class="list-style-three">
                                    <li><a href="blog.html">Phiêu lưu</a></li>
                                    <li><a href="blog.html">Leo núi & trekking</a></li>
                                    <li><a href="blog.html">Du lịch xe đạp</a></li>
                                    <li><a href="blog.html">Du lịch gia đình/a></li>
                                    <li><a href="blog.html">Leo núi</a></li>
                                     
                                </ul>
                            </div>

                            <div class="widget widget-news" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Tin gần đây </h5>
                                <ul>
                                    <li>
                                        <div class="image">
                                            <img src="assets/images/widgets/news1.jpg" alt="News">
                                        </div>
                                        <div class="content">
                                            <h6><a href="blog-details.html">Điểm đến độc đáo & những câu chuyện chưa kể</a></h6>
                                            <span class="date"><i class="far fa-calendar-alt"></i> 31/11/2025</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image">
                                            <img src="assets/images/widgets/news2.jpg" alt="News">
                                        </div>
                                        <div class="content">
                                            <h6><a href="blog-details.html">Trải nghiệm sống động từ khắp nơi trên khắp mọi miền </a></h6>
                                            <span class="date"><i class="far fa-calendar-alt"></i>30/12/2024</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image">
                                            <img src="assets/images/widgets/news3.jpg" alt="News">
                                        </div>
                                        <div class="content">
                                            <h6><a href="blog-details.html">Hành trình truyền cảm hứng cho chuyến phiêu lưu tiếp theo</a></h6>
                                            <span class="date"><i class="far fa-calendar-alt"></i> 01/12/2025</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="widget widget-gallery" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <h5 class="widget-title">Kho hình ảnh </h5>
                                <div class="gallery">
                                    <a href="assets/images/widgets/gallery1.jpg">
                                        <img src="assets/images/widgets/gallery1.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery2.jpg">
                                        <img src="assets/images/widgets/gallery2.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery3.jpg">
                                        <img src="assets/images/widgets/gallery3.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery4.jpg">
                                        <img src="assets/images/widgets/gallery4.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery5.jpg">
                                        <img src="assets/images/widgets/gallery5.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery6.jpg">
                                        <img src="assets/images/widgets/gallery6.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery7.jpg">
                                        <img src="assets/images/widgets/gallery7.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery8.jpg">
                                        <img src="assets/images/widgets/gallery8.jpg" alt="Gallery">
                                    </a>
                                    <a href="assets/images/widgets/gallery9.jpg">
                                        <img src="assets/images/widgets/gallery9.jpg" alt="Gallery">
                                    </a>
                                </div>
                            </div>

                            <div class="widget widget-cta" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                <div class="content text-white">
                                    <span class="h6">Explore The World</span>
                                    <h3>Best Tourist Place</h3>
                                    <a href="tour-list.html" class="theme-btn style-two bgc-secondary">
                                        <span data-hover="Explore Now">Explore Now</span>
                                        <i class="fal fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="image">
                                    <img src="assets/images/widgets/cta-widget.png" alt="CTA">
                                </div>
                                <div class="cta-shape"><img src="assets/images/widgets/cta-shape.png" alt="Shape"></div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Blog List Area end -->
@include('clients.blocks.footer')
