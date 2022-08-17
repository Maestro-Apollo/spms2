<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand font-weight-bold" style="font-family: 'Lato', sans-serif; color: #481639" href="index.php"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="share.php">
                            <svg width="20" height="20" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M31.5419 5.74817C28.1782 2.38062 23.705 0.525268 18.9391 0.523315C9.11919 0.523315 1.12682 8.51504 1.12298 18.338C1.12161 21.4781 1.942 24.543 3.50113 27.2447L0.973572 36.4768L10.4181 33.9994C13.0203 35.4187 15.9502 36.1668 18.932 36.1679H18.9392C18.9398 36.1679 18.9388 36.1679 18.9394 36.1679C28.7582 36.1679 36.7511 28.1753 36.7552 18.3522C36.757 13.5917 34.9055 9.11558 31.5419 5.74817ZM18.9391 33.159H18.9331C16.2761 33.158 13.67 32.4441 11.3964 31.0949L10.8557 30.7741L5.25119 32.2442L6.74719 26.7799L6.39506 26.2195C4.91281 23.8619 4.12995 21.1369 4.13111 18.339C4.13429 10.1745 10.7773 3.53231 18.9451 3.53231C22.9003 3.53354 26.6183 5.07589 29.4141 7.87486C32.2098 10.6738 33.7486 14.3943 33.747 18.351C33.7437 26.516 27.101 33.159 18.9391 33.159Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M27.0616 22.0686C26.6165 21.8458 24.4278 20.769 24.0198 20.6203C23.6118 20.4718 23.315 20.3975 23.0182 20.8431C22.7215 21.2887 21.8684 22.2915 21.6087 22.5886C21.349 22.8856 21.0893 22.923 20.6442 22.6999C20.1991 22.4771 18.7647 22.0071 17.0644 20.4905C15.741 19.31 14.8476 17.8524 14.5878 17.4066C14.3282 16.961 14.5602 16.7201 14.7831 16.4981C14.9833 16.2986 15.2283 15.9782 15.4509 15.7182C15.6734 15.4584 15.7476 15.2725 15.896 14.9757C16.0444 14.6785 15.9703 14.4185 15.8589 14.1958C15.7476 13.973 14.8574 11.7818 14.4864 10.8903C14.125 10.0224 13.758 10.14 13.4847 10.1262C13.2255 10.1133 12.9283 10.1106 12.6316 10.1106C12.3349 10.1106 11.8525 10.222 11.4445 10.6676C11.0365 11.1133 9.88641 12.1904 9.88641 14.3813C9.88641 16.5725 11.4816 18.6893 11.7042 18.9863C11.9267 19.2835 14.8432 23.7797 19.3088 25.708C20.3708 26.1667 21.2 26.4406 21.8465 26.6457C22.9129 26.9846 23.8834 26.9367 24.6504 26.8221C25.5057 26.6943 27.2842 25.7452 27.6551 24.7055C28.0261 23.6656 28.0261 22.7741 27.9148 22.5886C27.8035 22.4029 27.5067 22.2915 27.0616 22.0686Z" fill="white"/>
                            </svg> &nbsp;
                            Share to WhatsApp (<span id="wa-selected">0</span>)
                        </a>
                    </li>
                    <?php if (isset($_SESSION['admin2'])) { ?>

                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./property-details.php">Add Property</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./property-list.php">Property List</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./create-staff.php">Create Agent</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./view-permission.php">View Permission</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./search-admin.php">Admin Search</a>
                        </li>
                        <!-- <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./search-landlord.php">LandLord
                            Enterance</a>
                    </li> -->
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./password-reset.php">Password Reset</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="logout.php">Logout</a>
                        </li>

                    <?php } ?>
                    <?php if (isset($_SESSION['name2'])) { ?>

                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./property-details.php">Add Property</a>
                        </li>
                        <!-- <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./property-list.php">Property List</a>
                    </li> -->
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./search-landlord.php">Property Search</a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="./password-reset.php">Password Reset</a>
                        </li>
                        <!-- <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./search-landlord.php">LandLord
                            Enterance</a>
                    </li> -->

                        <li class="nav-item p-1">
                            <a class="nav-link text-white font-weight-bold" href="logout.php">Logout</a>
                        </li>

                    <?php } ?>







                </ul>

            </div>
        </div>
    </nav>
</div>