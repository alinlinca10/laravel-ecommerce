<div>
    <a href="/checkout/cart" class="position-relative d-flex align-items-center text-decoration-none">
        <span class="position-relative">
          @if (Cart::content()->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle rounded-circle cart-badge">
              <span class="visually-hidden">Cart counter</span>
            </span>
          @endif
          <svg class="icon icon-bag d-block" width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.11911 5.20822C2.17388 4.42217 2.82752 3.8125 3.61548 3.8125H12.3845C13.1725 3.8125 13.8261 4.42217 13.8809 5.20822L14.8521 19.1457C14.9126 20.0131 14.2253 20.75 13.3558 20.75H2.64422C1.77474 20.75 1.08741 20.0131 1.14785 19.1457L2.11911 5.20822Z" stroke="black"></path>
            <rect x="4.5" y="4.16666" width="1" height="16.2292" fill="black"></rect>
            <rect x="10.5" y="4.16666" width="1" height="16.2292" fill="black"></rect>
            <rect x="3" y="1.25" width="10" height="2.41667" rx="0.5" stroke="black"></rect>
            <rect x="5.5" y="7.58334" width="5" height="0.854167" fill="black"></rect>
            <rect x="5.5" y="11" width="5" height="0.854167" fill="black"></rect>
            <rect x="5.5" y="14.4167" width="5" height="0.854167" fill="black"></rect>
          </svg>
          {{-- <svg class="icon icon-bag--inverse d-block" width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.11911 5.20822C2.17388 4.42217 2.82752 3.8125 3.61548 3.8125H12.3845C13.1725 3.8125 13.8261 4.42217 13.8809 5.20822L14.8521 19.1457C14.9126 20.0131 14.2253 20.75 13.3558 20.75H2.64422C1.77474 20.75 1.08741 20.0131 1.14785 19.1457L2.11911 5.20822Z" stroke="white"></path>
            <rect x="4.5" y="4.16666" width="1" height="16.2292" fill="white"></rect>
            <rect x="10.5" y="4.16666" width="1" height="16.2292" fill="white"></rect>
            <rect x="3" y="1.25" width="10" height="2.41667" rx="0.5" stroke="white"></rect>
            <rect x="5.5" y="7.58334" width="5" height="0.854167" fill="white"></rect>
            <rect x="5.5" y="11" width="5" height="0.854167" fill="white"></rect>
            <rect x="5.5" y="14.4167" width="5" height="0.854167" fill="white"></rect>
          </svg> --}}
        </span>
        <span class="cart-subtitle fs-7">Bag</span>
        <span class="cart-counter">({{ Cart::content()->count() }})</span>
    </a>
</div>
