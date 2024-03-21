<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TikTok - By Tuan Xu</title>
    <link rel="stylesheet" href="src/style/style.css" />
    <link rel="stylesheet" href="style/css/responsive.css" />
    <link rel="icon" type="image/png" href="photo/icontiktok.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body key="jaki">
    <content>
        <div class="container-detail-vid">
            <div class="content-vid">
                <video src="src/assets/video/video1.mp4" controls></video>
                <div class="header-content">
                    <div class="warna-bayang"></div>
                    <div class="CloseBtn">&times;</div>
                    <div class="DetailVideoIcon"><i class="fa-solid fa-ellipsis"></i></div>
                    <div class="SearchBtn">
                        <div class="search">
                            <input type="text" class="form-control" id="inpSearch" placeholder="Find accounts and videos..." />
                            <button class="btn-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-container">
                <div class="content-comments">
                    <div class="CommentList">
                        <div class="ProfileWrapper">
                            <div class="CardProfile">
                                <div class="Header">
                                    <div class="Avatar">
                                        <img src="photo/evondev.jpg" width="55px" alt="">
                                    </div>
                                    <a href="profile.php" class="UserName">
                                        <span id="nama">farhanfls</span><br><span id="bio">Farhan Frisa . 2-12</span>
                                    </a>
                                    <button class="ButtonFollow">Ikuti</button>
                                </div>
                                <div class="Detail">
                                    <div class="Caption">
                                        <span>Komunikasi Adalah Kunci</span> <strong>#abcdeia</strong>
                                    </div>
                                    <div class="Songs">
                                       <i class="fa-solid fa-music"></i> originial sound - farhanfls
                                    </div>
                                </div>
                            </div>
                            <div class="MainContent">
                                <div class="LayoutMain">
                                    <div class="count_sosmed">
                                        <div class="CountVideo">
                                            <div class="DetailCount">
                                                <div class="IconWrapper"><i class="fa-solid fa-heart"></i></div>
                                                <span>176.7K</span>
                                            </div>
                                            <div class="DetailCount">
                                                <div class="IconWrapper"><i class="fa-solid fa-heart"></i></div>
                                                <span>176.7K</span>
                                            </div>
                                            <div class="DetailCount">
                                                <div class="IconWrapper"><i class="fa-solid fa-heart"></i></div>
                                                <span>176.7K</span>
                                            </div>
                                        </div>
                                        <div class="SosmedContent">
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="LinkContainer">
                                        <p class="LinkText"> https://www.tiktok.com/@jonathan_abee/video/7343225896242777349?is_from_webapp=1&sender_device=pc&web_id=7286525911754900993</p>
                                        <button class="ButtonCopyLink">Salin Tautan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="TabMenuWrapper">
                            <div class="TabMenuContainer">
                                <div class="TabLink" onclick="openCity(event, 'Komentar')"><div class="TextTab">Komentar (1400)</div></div>
                                <div class="TabLink" onclick="openCity(event, 'VidKreator')"><div class="TextTab">Video Kreator</div></div>
                            </div>
                            <div class="SearchMenuTop">
                                <span>Cari :</span> <div class="SpanWord">Hubungan Rungkad ? <i class="fa-solid fa-magnifying-glass"></i></div>
                            </div>
                        </div>
                            <div class="tabcon" id="Komentar">
                                <div class="container-comment">
                                    <div class="content-comment">
                                        <div class="avatar">
                                            <img src="photo/evondev.jpg" width="55px" alt="">
                                        </div>
                                        <div class="content-main">
                                            <a href="">farhanfls</a>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis tempore repudiandae nisi </p>
                                            <div class="subcoment">
                                                <span>3-7</span>
                                                <span class="Replybtn">Jawab</span>
                                            </div>
                                        </div>
                                        <div class="count-like">

                                        </div>
                                    </div>
                                    <div class="reply-comment">
                                        <div class="TextReply">Lihat 431 balasan</div>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="container-comment">
                                    <div class="content-comment">
                                        <div class="avatar">
                                            <img src="photo/evondev.jpg" width="55px" alt="">
                                        </div>
                                        <div class="content-main">
                                            <a href="">farhanfls</a>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis tempore repudiandae nisi </p>
                                            <div class="subcoment">
                                                <span>3-7</span>
                                                <span class="Replybtn">Jawab</span>
                                            </div>
                                        </div>
                                        <div class="count-like">

                                        </div>
                                    </div>
                                    <div class="reply-comment">
                                        <div class="TextReply">Lihat 431 balasan</div>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="container-comment">
                                    <div class="content-comment">
                                        <div class="avatar">
                                            <img src="photo/evondev.jpg" width="55px" alt="">
                                        </div>
                                        <div class="content-main">
                                            <a href="">farhanfls</a>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis tempore repudiandae nisi </p>
                                            <div class="subcoment">
                                                <span>3-7</span>
                                                <span class="Replybtn">Jawab</span>
                                            </div>
                                        </div>
                                        <div class="count-like">

                                        </div>
                                    </div>
                                    <div class="reply-comment">
                                        <div class="TextReply">Lihat 431 balasan</div>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="container-comment">
                                    <div class="content-comment">
                                        <div class="avatar">
                                            <img src="photo/evondev.jpg" width="55px" alt="">
                                        </div>
                                        <div class="content-main">
                                            <a href="">farhanfls</a>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis tempore repudiandae nisi </p>
                                            <div class="subcoment">
                                                <span>3-7</span>
                                                <span class="Replybtn">Jawab</span>
                                            </div>
                                        </div>
                                        <div class="count-like">

                                        </div>
                                    </div>
                                    <div class="reply-comment">
                                        <div class="TextReply">Lihat 431 balasan</div>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="container-comment">
                                    <div class="content-comment">
                                        <div class="avatar">
                                            <img src="photo/evondev.jpg" width="55px" alt="">
                                        </div>
                                        <div class="content-main">
                                            <a href="">farhanfls</a>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis tempore repudiandae nisi </p>
                                            <div class="subcoment">
                                                <span>3-7</span>
                                                <span class="Replybtn">Jawab</span>
                                            </div>
                                        </div>
                                        <div class="count-like">

                                        </div>
                                    </div>
                                    <div class="reply-comment">
                                        <div class="TextReply">Lihat 431 balasan</div>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tabcon" id="VidKreator">
                                <div class="VideoKreator">
                                    <div class="video-wrapper">
                                    <video src="src/assets/video/video1.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video2.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video3.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video4.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video5.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video6.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                 <div class="video-wrapper">
                                    <video src="src/assets/video/video1.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video2.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                <div class="video-wrapper">
                                    <video src="src/assets/video/video3.mp4" ></video>
                                    <div class="count">
                                        <i class="fa-solid fa-play"></i>
                                        <strong>1.74M</strong>
                                    </div>
                                </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="BottomComment">
                    <div class="content-bottom">
                        <div class="ComentInput">
                            <input type="text" id="DivInput" placeholder="Tambah Komentar">
                            <div class="MentionWrapper">@</div>
                        </div>
                        <div class="PostButton">
                            Posting
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </content>
    <script src="src/js/script.js"></script>
    <script src="src/js/js.js"></script>
    <script>
        function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcon");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("TabLink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
        }
    </script>
  </body>
</html>
