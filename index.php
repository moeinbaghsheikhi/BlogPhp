<?php
require_once "config/loader.php";


$query = "SELECT posts.*, 0 AS like_exsist, 0 AS save_exsist FROM `posts`";

// stmt
$stmt = $conn->query($query);
// exe
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_OBJ);

if (isset($_SESSION['login'])) {
    $query = "SELECT posts.*, CASE WHEN like_post.post_id IS NULL THEN FALSE ELSE TRUE END AS like_exsist, CASE WHEN save_post.post_id IS NULL THEN FALSE ELSE TRUE END AS save_exsist FROM `posts` LEFT JOIN like_post ON like_post.post_id = posts.id AND like_post.user_id =?  LEFT JOIN save_post ON save_post.post_id = posts.id AND save_post.user_id =?";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(1, $_SESSION['id']);
    $stmt->bindValue(2, $_SESSION['id']);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">
    <?php require_once "config/styleLoad.php"; ?>

    <meta name="description" content=""/>
    <meta name="keywords" content="bootstrap, bootstrap5"/>

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


    <title>Blogy &mdash; Free Bootstrap 5 Website Template by Untree.co</title>
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
                        <a href="index.html" class="logo m-0 float-start">Blogy<span class="text-primary">.</span></a>
                    </div>
                    <div class="col-8 text-center">
                        <form action="#" class="search-form d-inline-block d-lg-none">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="bi-search"></span>
                        </form>

                        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
                            <li class="active"><a href="index.html">Home</a></li>
                            <li class="has-children">
                                <a href="category.php">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="search-result.html">Search Result</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="single.php">Blog Single</a></li>
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
                            <?php if (isset($_SESSION['role'])) { ?>
                                <li>
                                    <?php if ($_SESSION['role'] == "writer") { ?>
                                        <a href="panel/writerpanel.php">writer Panel</a>
                                    <?php } ?>

                                    <?php if ($_SESSION['role'] == "admin") { ?>
                                        <a href="panel/adminpanel.php">Admin Panel</a>
                                    <?php } ?>

                                    <?php if ($_SESSION['role'] == "user") { ?>
                                        <a href="panel/userpanel.php">User Panel</a>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                            <li>
                                <?php if (isset($_SESSION['login'])) { ?>
                                    <a href="action/logout.php">logout</a>
                                <?php } else { ?>
                                    <a href="login.php">login</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-2 text-end">
                        <a href="#"
                           class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
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

<!-- Start retroy layout blog posts -->
<section class="section bg-light">
    <div class="container">
        <div class="row align-items-stretch retro-layout">
            <div class="col-md-4">
                <a href="single.php" class="h-entry mb-30 v-height gradient">

                    <div class="featured-img" style="background-image: url('images/img_2_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>AI can now kill those annoying cookie pop-ups</h2>
                    </div>
                </a>
                <a href="single.php" class="h-entry v-height gradient">

                    <div class="featured-img" style="background-image: url('images/img_5_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Don’t assume your user data in the cloud is safe</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="single.php" class="h-entry img-5 h-100 gradient">

                    <div class="featured-img" style="background-image: url('images/img_1_vertical.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Why is my internet so slow?</h2>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="single.php" class="h-entry mb-30 v-height gradient">

                    <div class="featured-img" style="background-image: url('images/img_3_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Startup vs corporate: What job suits you best?</h2>
                    </div>
                </a>
                <a href="single.php" class="h-entry v-height gradient">

                    <div class="featured-img" style="background-image: url('images/img_4_horizontal.jpg');"></div>

                    <div class="text">
                        <span class="date">Apr. 14th, 2022</span>
                        <h2>Thought you loved Python? Wait until you meet Rust</h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End retroy layout blog posts -->

<!-- Start posts-entry -->
<section class="section posts-entry">
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">Business</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php" class="read-more">View All</a></div>
        </div>
        <div class="row g-3">
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="blog-entry">
                            <a href="single.php" class="img-link">
                                <img src="images/img_1_sq.jpg" alt="Image" class="img-fluid">
                            </a>
                            <span class="date">Apr. 14th, 2022</span>
                            <h2><a href="single.php">Thought you loved Python? Wait until you meet Rust</a></h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore
                                vel voluptas.</p>
                            <p><a href="single.php" class="btn btn-sm btn-outline-primary">Read More</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="blog-entry">
                            <a href="single.php" class="img-link">
                                <img src="images/img_2_sq.jpg" alt="Image" class="img-fluid">
                            </a>
                            <span class="date">Apr. 14th, 2022</span>
                            <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore
                                vel voluptas.</p>
                            <p><a href="single.php" class="btn btn-sm btn-outline-primary">Read More</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="list-unstyled blog-entry-sm">
                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">Don’t assume your user data in the cloud is safe</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>

                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">Meta unveils fees on metaverse sales</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>

                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">UK sees highest inflation in 30 years</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End posts-entry -->

<!-- Start posts-entry -->
<section class="section posts-entry posts-entry-sm bg-light">
    <div class="container">
        <div class="row">
            <?php foreach ($posts as $post): ?>

                <div class="col-md-6 col-lg-3">
                    <div class="blog-entry">
                        <a href="single.php?post_id=<?= $post->id ?>" class="img-link">
                            <img src="uploads/<?= $post->image ?>" alt="Image" class="img-fluid">
                        </a>
                        <span class="date">Apr. 14th, 2022</span>
                        <h2><a href="single.php?post_id=<?= $post->id ?>"><?= $post->title ?></a></h2>
                        <p><?= $post->description ?></p>
                        <p><a href="single.php?post_id=<?= $post->id ?>" class="read-more">Continue Reading</a></p>
                        <?php if (!isset($_SESSION['login'])) { ?>
                            <a href="index.php?notlogin=true"><i class="bi bi-heart" style="color: #ff2f2f;"></i></a>
                            <a href="index.php?notlogin=true"><i class="bi bi-bookmark" style="color: #0c1e28;"></i></a>
                        <?php } else { ?>
                            <?php if ($post->like_exsist) { ?>
                                <a href="action/unlike.php?user_id=<?= $_SESSION["id"] ?>&post_id=<?= $post->id ?>"><i class="bi bi-heart-fill" style="color: #ff2f2f;"></i></a>
                            <?php } else { ?>
                                <a href="action/like.php?user_id=<?= $_SESSION["id"] ?>&post_id=<?= $post->id ?>"><i
                                            class="bi bi-heart" style="color: #ff2f2f;"></i></a>
                            <?php } ?>

                            <?php if ($post->save_exsist) { ?>
                                <a href="action/unsave.php?user_id=<?= $_SESSION["id"] ?>&post_id=<?= $post->id ?>"><i class="bi bi-bookmark-fill" style="color: #0c1e28;"></i></a>
                            <?php } else { ?>
                                <a href="action/save.php?user_id=<?= $_SESSION["id"] ?>&post_id=<?= $post->id ?>"><i
                                            class="bi bi-bookmark" style="color: #0c1e28;"></i></a>
                            <?php } ?>

                            <!--                        <a href=""><i class="bi bi-bookmark-fill" style="color: #0c1e28;"></i></a>-->
                        <?php } ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End posts-entry -->

<!-- Start posts-entry -->
<section class="section posts-entry">
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">Culture</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php" class="read-more">View All</a></div>
        </div>
        <div class="row g-3">
            <div class="col-md-9 order-md-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="blog-entry">
                            <a href="single.php" class="img-link">
                                <img src="images/img_1_sq.jpg" alt="Image" class="img-fluid">
                            </a>
                            <span class="date">Apr. 14th, 2022</span>
                            <h2><a href="single.php">Thought you loved Python? Wait until you meet Rust</a></h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore
                                vel voluptas.</p>
                            <p><a href="single.php" class="btn btn-sm btn-outline-primary">Read More</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="blog-entry">
                            <a href="single.php" class="img-link">
                                <img src="images/img_2_sq.jpg" alt="Image" class="img-fluid">
                            </a>
                            <span class="date">Apr. 14th, 2022</span>
                            <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore
                                vel voluptas.</p>
                            <p><a href="single.php" class="btn btn-sm btn-outline-primary">Read More</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="list-unstyled blog-entry-sm">
                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">Don’t assume your user data in the cloud is safe</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>

                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">Meta unveils fees on metaverse sales</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>

                    <li>
                        <span class="date">Apr. 14th, 2022</span>
                        <h3><a href="single.php">UK sees highest inflation in 30 years</a></h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, nobis ea quis inventore vel
                            voluptas.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">Politics</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php" class="read-more">View All</a></div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_7_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_1.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_6_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_2.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_5_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_3.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_4_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_4.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_3_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_5.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_2_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_4.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_1_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_3.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_4_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_2.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="post-entry-alt">
                    <a href="single.php" class="img-link"><img src="images/img_3_horizontal.jpg" alt="Image"
                                                               class="img-fluid"></a>
                    <div class="excerpt">


                        <h2><a href="single.php">Startup vs corporate: What job suits you best?</a></h2>
                        <div class="post-meta align-items-center text-left clearfix">
                            <figure class="author-figure mb-0 me-3 float-start"><img src="images/person_5.jpg"
                                                                                     alt="Image" class="img-fluid">
                            </figure>
                            <span class="d-inline-block mt-1">By <a href="#">David Anderson</a></span>
                            <span>&nbsp;-&nbsp; July 19, 2019</span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo sunt tempora dolor laudantium
                            sed optio, explicabo ad deleniti impedit facilis fugit recusandae! Illo, aliquid, dicta
                            beatae quia porro id est.</p>
                        <p><a href="#" class="read-more">Continue Reading</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<div class="section bg-light">
    <div class="container">

        <div class="row mb-4">
            <div class="col-sm-6">
                <h2 class="posts-entry-title">Travel</h2>
            </div>
            <div class="col-sm-6 text-sm-end"><a href="category.php" class="read-more">View All</a></div>
        </div>

        <div class="row align-items-stretch retro-layout-alt">

            <div class="col-md-5 order-md-2">
                <a href="single.php" class="hentry img-1 h-100 gradient">
                    <div class="featured-img" style="background-image: url('images/img_2_vertical.jpg');"></div>
                    <div class="text">
                        <span>February 12, 2019</span>
                        <h2>Meta unveils fees on metaverse sales</h2>
                    </div>
                </a>
            </div>

            <div class="col-md-7">

                <a href="single.php" class="hentry img-2 v-height mb30 gradient">
                    <div class="featured-img" style="background-image: url('images/img_1_horizontal.jpg');"></div>
                    <div class="text text-sm">
                        <span>February 12, 2019</span>
                        <h2>AI can now kill those annoying cookie pop-ups</h2>
                    </div>
                </a>

                <div class="two-col d-block d-md-flex justify-content-between">
                    <a href="single.php" class="hentry v-height img-2 gradient">
                        <div class="featured-img" style="background-image: url('images/img_2_sq.jpg');"></div>
                        <div class="text text-sm">
                            <span>February 12, 2019</span>
                            <h2>Don’t assume your user data in the cloud is safe</h2>
                        </div>
                    </a>
                    <a href="single.php" class="hentry v-height img-2 ms-auto float-end gradient">
                        <div class="featured-img" style="background-image: url('images/img_3_sq.jpg');"></div>
                        <div class="text text-sm">
                            <span>February 12, 2019</span>
                            <h2>Startup vs corporate: What job suits you best?</h2>
                        </div>
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>


<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="widget">
                    <h3 class="mb-4">About</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts.</p>
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

                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                    . All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>
                    <!-- License information: https://untree.co/license/ -->
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
