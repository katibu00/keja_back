@php
    $user = auth()->user();
@endphp
<!-- Offcanvas -->
 <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body p-0">
      <!-- Side Nav Wrapper -->
      <div class="sidenav-wrapper">
        <!-- Sidenav Profile -->
        <div class="sidenav-profile bg-gradient">
          <div class="sidenav-style1"></div>
          <!-- User Thumbnail -->
          <div class="user-profile"><img src="/person.png" alt=""></div>
          <!-- User Info -->
          <div class="user-info">
            <h6 class="user-name mb-0">{{ $user->name }}</h6><span>{{ $user->user_type }}</span>
          </div>
        </div>
        <!-- Sidenav Nav -->
        <ul class="sidenav-nav ps-0">
          <li><a href="{{ route('regular.home') }}"><i class="bi bi-house-door"></i>Home</a></li>
          <li><a href="{{ route('contact_us') }}"><i class="bi bi-house-door"></i>Contact Us</a></li>
          <li><a href="{{ route('recent.transactions') }}"><i class="bi bi-house-door"></i>Recent Transactions</a></li>

          <li><a href="{{ route('account.index') }}"><i class="bi bi-gear"></i>Account</a></li>
          <li>
            <div class="night-mode-nav"><i class="bi bi-moon"></i>Night Mode
              <div class="form-check form-switch">
                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
              </div>
            </div>
          </li>
          <li><a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i>Logout</a></li>
        </ul>
        <!-- Social Info -->
        <div class="social-info-wrap"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-twitter"></i></a><a href="#"><i class="bi bi-linkedin"></i></a></div>
        <!-- Copyright Info -->
        <div class="copyright-info">
          <p>2021 &copy; Made by<a href="#">SubNow Solutions LLP</a></p>
        </div>
      </div>
    </div>
  </div>