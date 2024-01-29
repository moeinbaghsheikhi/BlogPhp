<!--Login(true) validation-->
<?php if (isset($_GET['loginned'])):
    ?>
    <script>
        Swal.fire({
            title: "Good job!",
            text: "Your login to site!",
            icon: "success"
        });
    </script>
<?php endif; ?>

<!--Login(false) validation-->
<?php if (isset($_GET['notuser'])):
    ?>
    <script>
        Swal.fire({
            title: "Oh!",
            text: "user is not available!",
            icon: "error"
        });
    </script>
<?php
endif;
?>

<!--Logout validation-->
<?php if (isset($_GET['logout'])):
    ?>
    <script>
        Swal.fire({
            title: "LogOut!",
            text: "Logout from site!",
            icon: "info"
        });
    </script>
<?php
endif;
?>

<!--Login validation (please Login)-->
<?php if (isset($_GET['notlogin'])):
    ?>
    <script>
        Swal.fire({
            title: "Oh!",
            text: "Please Login First!",
            icon: "error"
        });
    </script>
<?php
endif;
?>

<!-- validation Fill Form-->
<?php if (isset($_GET['formempty'])):
    ?>
    <script>
        Swal.fire({
            title: "Validation Error!",
            text: "Please Fill Form!",
            icon: "info"
        });
    </script>
<?php
endif;
?>

<!--submit form-->
<?php if (isset($_GET['submitform'])):
    ?>
    <script>
        Swal.fire({
            title: "Yes!",
            text: "Submit your form!",
            icon: "success"
        });
    </script>
<?php
endif;
?>

<!--like psot-->
<?php if (isset($_GET['like-post'])):
    ?>
    <script>
        Swal.fire({
            title: "Liked!",
            text: "Like your post!",
            icon: "success"
        });
    </script>
<?php
endif;
?>


<!--save psot-->
<?php if (isset($_GET['save-post'])):
    ?>
    <script>
        Swal.fire({
            title: "Saved!",
            text: "Save your post!",
            icon: "success"
        });
    </script>
<?php
endif;
?>
