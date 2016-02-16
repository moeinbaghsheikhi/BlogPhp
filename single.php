<?php
require_once "config/loader.php";

if(!isset($_GET['post_id'])) header("Location: index.php");

$post_id = $_GET['post_id'];
$reply_id = 0;
if(isset($_GET['reply_id'])) $reply_id = $_GET['reply_id'];

$query = "SELECT posts.*, users.username AS writer_name FROM `posts`  LEFT JOIN users ON posts.writer_id = users.id WHERE posts.id=?";

// stmt
$stmt = $conn->prepare($query);

$stmt->bindValue(1, $post_id);

// exe
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_OBJ);

$query = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE post_id=?";

// stmt
$stmt = $conn->prepare($query);

$stmt->bindValue(1, $post_id);

// exe
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
    $iserror = false;

    if(!isset($_SESSION['login'])) {
        header("Location: single.php?post_id=" . $post_id . "&notlogin=true");
        $iserror = true;
    }

    $message = $_POST['message'];

    if($message == "") {
        header("Location: single.php?post_id=" . $post_id . "&formempty=true");
        $iserror = true;
    }

    if(!$iserror){
        $sql = "INSERT INTO comments SET message=?, user_id=?, post_id=?, reply_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $message);
        $stmt->bindValue(2, $_SESSION['id']);
        $stmt->bindValue(3, $post_id);
        $stmt->bindValue(4, $reply_id);

        $result = $stmt->execute();

        var_dump($result);
        if($result) header("Location: single.php?post_id=" . $post_id . "&submitform=true");
        else header("Location: single.php?post_id=" . $post_id);
    }
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="css/tiny-slider.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/glightbox.min.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="css/flatpickr.min.css">
    <?php require_once "config/styleLoad.php";?>

  <title><?= $post->title ?></title>
</head>
<body>

  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <nav class="site-nav">
    <div class="container">
      <div class="menu-bg-wrap">
        <div class="site-navigation">
          <div class="row g-0 align-items-center">
            <div class="col-2">
              <a href="index.php" class="logo m-0 float-start">Blogy<span class="text-primary">.</span></a>
            </div>
            <div class="col-8 text-center">
              <form action="#" class="search-form d-inline-block d-lg-none">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="bi-search"></span>
              </form>

              <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
                <li><a href="index.php">Home</a></li>
                <li class="has-children active">
                  <a href="category.php">Pages</a>
                  <ul class="dropdown">
                    <li><a href="search-result.html">Search Result</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li class="active"><a href="single.html">Blog Single</a></li>
                    <li><a href="category.php">Category</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="#">Menu One</a></li>
                    <li><a href="#">Menu Two</a></li>
                    <li class="has-children">
                      <a href="#">Dropdown</a>
                      <ul class="dropdown">
                        <li><a href="#">Sub Menu One</a></li>
                        <li><a href="#">Sub Menu Two</a></li>
                        <li><a href="#">Sub Menu Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="category.php">Culture</a></li>
                <li><a href="category.php">Business</a></li>
                <li><a href="category.php">Politics</a></li>
              </ul>
            </div>
            <div class="col-2 text-end">
              <a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
                <span></span>
              </a>
              <form action="#" class="search-form d-none d-lg-inline-block">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="bi-search"></span>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('uploads/<?= $post->image ?>');">
    <div class="container">
      <div class="row same-height justify-content-center">
        <div class="col-md-6">
          <div class="post-entry text-center">
            <h1 class="mb-4"><?= $post->title ?></h1>
            <div class="post-meta align-items-center text-center">
              <figure class="author-figure mb-0 me-3 d-inline-block"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure>
              <span class="d-inline-block mt-1">By Carl Atkinson</span>
              <span>&nbsp;-&nbsp; February 10, 2019</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-8 main-content">

            <?= $post->description ?>

          <div class="pt-5">
            <p>Categories:  <a href="#">Food</a>, <a href="#">Travel</a>  Tags: <a href="#">#manila</a>, <a href="#">#asia</a></p>
          </div>


          <div class="pt-5 comment-wrap">
            <h3 class="mb-5 heading">6 Comments</h3>
            <ul class="comment-list">
                <?php foreach ($comments as $comment): ?>
                <?php if($comment->reply_id == 0): ?>
              <li class="comment">
                <div class="vcard">
                  <img src="images/person_1.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                  <h3><?= $comment->username ?></h3>
                  <div class="meta">January 9, 2018 at 2:21pm</div>
                  <p><?= $comment->message ?></p>
                  <p><a href="single.php?post_id=<?= $post_id ?>&reply_id=<?= $comment->id ?>" class="reply rounded">Reply</a></p>
                </div>

                  <ul class="children">
                      <?php foreach ($comments as $reply_comments): ?>
                      <?php if($reply_comments->reply_id == $comment->id): ?>
                      <li class="comment">
                          <div class="vcard">
                              <img src="images/person_5.jpg" alt="Image placeholder">
                          </div>
                          <div class="comment-body">
                              <h3><?= $reply_comments->username ?></h3>
                              <div class="meta">January 9, 2018 at 2:21pm</div>
                              <p><?= $reply_comments->message ?></p>
                              <p><a href="single.php?post_id=<?= $post_id ?>&reply_id=<?= $reply_comments->id ?>" class="reply rounded">Reply</a></p>
                          </div>

                          <ul class="children">
                              <?php foreach ($comments as $three_comments): ?>
                                  <?php if($reply_comments->id == $three_comments->reply_id): ?>
                                      <li class="comment">
                                          <div class="vcard">
                                              <img src="images/person_5.jpg" alt="Image placeholder">
                                          </div>
                                          <div class="comment-body">
                                              <h3><?= $three_comments->username ?></h3>
                                              <div class="meta">January 9, 2018 at 2:21pm</div>
                                              <p><?= $three_comments->message ?></p>
                                             </div>
                                      </li>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </ul>
                      </li>
                          <?php endif; ?>
                      <?php endforeach; ?>
                  </ul>

              </li>
                <?php endif; ?>
                <?php endforeach; ?>

<!--              <li class="comment">-->
<!--                <div class="vcard">-->
<!--                  <img src="images/person_2.jpg" alt="Image placeholder">-->
<!--                </div>-->
<!--                <div class="comment-body">-->
<!--                  <h3>Jean Doe</h3>-->
<!--                  <div class="meta">January 9, 2018 at 2:21pm</div>-->
<!--                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>-->
<!--                  <p><a href="#" class="reply rounded">Reply</a></p>-->
<!--                </div>-->
<!---->
<!--                <ul class="children">-->
<!--                  <li class="comment">-->
<!--                    <div class="vcard">-->
<!--                      <img src="images/person_3.jpg" alt="Image placeholder">-->
<!--                    </div>-->
<!--                    <div class="comment-body">-->
<!--                      <h3>Jean Doe</h3>-->
<!--                      <div class="meta">January 9, 2018 at 2:21pm</div>-->
<!--                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>-->
<!--                      <p><a href="#" class="reply rounded">Reply</a></p>-->
<!--                    </div>-->
<!---->
<!---->
<!--                    <ul class="children">-->
<!--                      <li class="comment">-->
<!--                        <div class="vcard">-->
<!--                          <img src="images/person_4.jpg" alt="Image placeholder">-->
<!--                        </div>-->
<!--                        <div class="comment-body">-->
<!--                          <h3>Jean Doe</h3>-->
<!--                          <div class="meta">January 9, 2018 at 2:21pm</div>-->
<!--                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>-->
<!--                          <p><a href="#" class="reply rounded">Reply</a></p>-->
<!--                        </div>-->
<!---->
<!--                        <ul class="children">-->
<!--                          <li class="comment">-->
<!--                            <div class="vcard">-->
<!--                              <img src="images/person_5.jpg" alt="Image placeholder">-->
<!--                            </div>-->
<!--                            <div class="comment-body">-->
<!--                              <h3>Jean Doe</h3>-->
<!--                              <div class="meta">January 9, 2018 at 2:21pm</div>-->
<!--                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>-->
<!--                              <p><a href="#" class="reply rounded">Reply</a></p>-->
<!--                            </div>-->
<!--                          </li>-->
<!--                        </ul>-->
<!--                      </li>-->
<!--                    </ul>-->
<!--                  </li>-->
<!--                </ul>-->
<!--              </li>-->
<!---->
<!--              <li class="comment">-->
<!--                <div class="vcard">-->
<!--                  <img src="images/person_1.jpg" alt="Image placeholder">-->
<!--                </div>-->
<!--                <div class="comment-body">-->
<!--                  <h3>Jean Doe</h3>-->
<!--                  <div class="meta">January 9, 2018 at 2:21pm</div>-->
<!--                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>-->
<!--                  <p><a href="#" class="reply rounded">Reply</a></p>-->
<!--                </div>-->
<!--              </li>-->
<!--                -->
            </ul>
            <!-- END comment-list -->

            <div class="comment-form-wrap pt-5">
              <h3 class="mb-5">Leave a comment</h3>
              <form method="post" class="p-5 bg-light">
                <div class="form-group">
                  <label for="message">Message</label>
                  <textarea id="message" name="message" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="Post Comment" class="btn btn-primary">
                </div>

              </form>
            </div>
          </div>

        </div>

        <!-- END main-content -->

        <div class="col-md-12 col-lg-4 sidebar">
          <div class="sidebar-box search-form-wrap">
            <form action="#" class="sidebar-search-form">
              <span class="bi-search"></span>
              <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
            </form>
          </div>
          <!-- END sidebar-box -->
          <div class="sidebar-box">
            <div class="bio text-center">
              <img src="images/person_2.jpg" alt="Image Placeholder" class="img-fluid mb-3">
              <div class="bio-body">
                <h2><?= $post->writer_name ?></h2>
                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.</p>
                <p><a href="#" class="btn btn-primary btn-sm rounded px-2 py-2">Read my bio</a></p>
                <p class="social">
                  <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                  <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                </p>
              </div>
            </div>
          </div>
          <!-- END sidebar-box -->  
          <div class="sidebar-box">
            <h3 class="heading">Popular Posts</h3>
            <div class="post-entry-sidebar">
              <ul>
                <li>
                  <a href="">
                    <img src="images/img_1_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="images/img_2_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="images/img_3_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END sidebar-box -->

          <div class="sidebar-box">
            <h3 class="heading">Categories</h3>
            <ul class="categories">
              <li><a href="#">Food <span>(12)</span></a></li>
              <li><a href="#">Travel <span>(22)</span></a></li>
              <li><a href="#">Lifestyle <span>(37)</span></a></li>
              <li><a href="#">Business <span>(42)</span></a></li>
              <li><a href="#">Adventure <span>(14)</span></a></li>
            </ul>
          </div>
          <!-- END sidebar-box -->

          <div class="sidebar-box">
            <h3 class="heading">Tags</h3>
            <ul class="tags">
              <li><a href="#">Travel</a></li>
              <li><a href="#">Adventure</a></li>
              <li><a href="#">Food</a></li>
              <li><a href="#">Lifestyle</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Freelancing</a></li>
              <li><a href="#">Travel</a></li>
              <li><a href="#">Adventure</a></li>
              <li><a href="#">Food</a></li>
              <li><a href="#">Lifestyle</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Freelancing</a></li>
            </ul>
          </div>
        </div>
        <!-- END sidebar -->

      </div>
    </div>
  </section>


  <!-- Start posts-entry -->
  <section class="section posts-entry posts-entry-sm bg-light">
    <div class="container">
      <div class="row mb-4">
        <div class="col-12 text-uppercase text-black">More Blog Posts</div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="blog-entry">
            <a href="single.html" class="img-link">
              <img src="images/img_1_horizontal.jpg" alt="Image" class="img-fluid">
            </a>
            <span class="date">Apr. 14th, 2022</span>
            <h2><a href="single.html">Thought you loved Python? Wait until you meet Rust</a></h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p><a href="#" class="read-more">Continue Reading</a></p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="blog-entry">
            <a href="single.html" class="img-link">
              <img src="images/img_2_horizontal.jpg" alt="Image" class="img-fluid">
            </a>
            <span class="date">Apr. 14th, 2022</span>
            <h2><a href="single.html">Startup vs corporate: What job suits you best?</a></h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p><a href="#" class="read-more">Continue Reading</a></p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="blog-entry">
            <a href="single.html" class="img-link">
              <img src="images/img_3_horizontal.jpg" alt="Image" class="img-fluid">
            </a>
            <span class="date">Apr. 14th, 2022</span>
            <h2><a href="single.html">UK sees highest inflation in 30 years</a></h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p><a href="#" class="read-more">Continue Reading</a></p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="blog-entry">
            <a href="single.html" class="img-link">
              <img src="images/img_4_horizontal.jpg" alt="Image" class="img-fluid">
            </a>
            <span class="date">Apr. 14th, 2022</span>
            <h2><a href="single.html">Don’t assume your user data in the cloud is safe</a></h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p><a href="#" class="read-more">Continue Reading</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End posts-entry -->

  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="widget">
            <h3 class="mb-4">About</h3>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div> <!-- /.widget -->
          <div class="widget">
            <h3>Social</h3>
            <ul class="list-unstyled social">
              <li><a href="#"><span class="icon-instagram"></span></a></li>
              <li><a href="#"><span class="icon-twitter"></span></a></li>
              <li><a href="#"><span class="icon-facebook"></span></a></li>
              <li><a href="#"><span class="icon-linkedin"></span></a></li>
              <li><a href="#"><span class="icon-pinterest"></span></a></li>
              <li><a href="#"><span class="icon-dribbble"></span></a></li>
            </ul>
          </div> <!-- /.widget -->
        </div> <!-- /.col-lg-4 -->
        <div class="col-lg-4 ps-lg-5">
          <div class="widget">
            <h3 class="mb-4">Company</h3>
            <ul class="list-unstyled float-start links">
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Vision</a></li>
              <li><a href="#">Mission</a></li>
              <li><a href="#">Terms</a></li>
              <li><a href="#">Privacy</a></li>
            </ul>
            <ul class="list-unstyled float-start links">
              <li><a href="#">Partners</a></li>
              <li><a href="#">Business</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Creative</a></li>
            </ul>
          </div> <!-- /.widget -->
        </div> <!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <div class="widget">
            <h3 class="mb-4">Recent Post Entry</h3>
            <div class="post-entry-footer">
              <ul>
                <li>
                  <a href="">
                    <img src="images/img_1_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="images/img_2_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="images/img_3_sq.jpg" alt="Image placeholder" class="me-4 rounded">
                    <div class="text">
                      <h4>There’s a Cool New Way for Men to Wear Socks and Sandals</h4>
                      <div class="post-meta">
                        <span class="mr-2">March 15, 2018 </span>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>


          </div> <!-- /.widget -->
        </div> <!-- /.col-lg-4 -->
      </div> <!-- /.row -->

      <div class="row mt-5">
        <div class="col-12 text-center">
          <!-- 
              **==========
              NOTE: 
              Please don't remove this copyright link unless you buy the license here https://untree.co/license/  
              **==========
            -->

            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> <!-- License information: https://untree.co/license/ -->
            </p>
          </div>
        </div>
      </div> <!-- /.container -->
    </footer> <!-- /.site-footer -->

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>

    <script src="js/flatpickr.min.js"></script>


    <script src="js/aos.js"></script>
    <script src="js/glightbox.min.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>

  <?php require_once "config/errorLoaded.php"; ?>
    
  </body>
  </html>
