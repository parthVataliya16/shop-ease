<nav class="navbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <a class="text-decoration-none text-light logo" href="index.php"><img src="./../../public/assets/images/logo.png" alt=""></a>
            <div class="productCategoryDropdown">
                <p class="product nav-link">Products</p>
                <div class="dropdownMenu">
                    <a href="product.php">All products</a>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <form class="search" role="search">
                <input class="me-4" type="search" placeholder="Search product" aria-label="Search" id="searchProduct">
            </form>
            <div class="cart d-flex ms-2 align-items-center"> 
                <a class="nav-link me-3" aria-current="page" href="cart.php">
                    <i class="fa-regular fa-heart m-2"></i>
                    <p>Wishlist</p>
                </a>
                <a class="nav-link" aria-current="page" href="bag.php">
                    <i class="fa-solid fa-bag-shopping m-2" ></i>
                    <p>Bag</p>
                </a>
                <!-- <button class="btn ms-2"><a class="text-decoration-none text-light" href="./../../logOut.php">Log out</a></button> -->
                <div class="profileDropdown">
                    <p class="ms-3 me-4 nav-link "><i class="fa-solid fa-user text-dark"></i></p>
                    <div class="profile-dropdown">
                        <p><a href="profile.php">Profile</a></p>
                        <p><a href="./../auth/signOut.php">Sign out<i class="fa-solid fa-right-from-bracket ms-2"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>