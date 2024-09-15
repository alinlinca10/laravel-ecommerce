<script>
    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;
      if (prevScrollpos > currentScrollPos) {
        document.getElementById("header").style.top = "0";
      } else {
        document.getElementById("header").style.top = "-77px";
      }
      prevScrollpos = currentScrollPos;
    }
  
    $(document).ready(function() {
      $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
  
        // Verificăm dacă utilizatorul face scroll în jos
        if (scrollTop > 0) {
          $('#header').addClass('navbar-white-header').removeClass('navbar-transparent-header');
        } else {
          $('#header').addClass('navbar-transparent-header').removeClass('navbar-white-header');
        }
      });
    });
  
    // Script deschidere submeniuri
    $(document).ready(function() {
      $('.dropdown-toggle').dropdown();
  
      // Gestionăm evenimentul de clic pentru submeniuri
      $('.dev-submenu').on('click', function(event) {
        // Opriți evenimentul de închidere implicită a dropdown-ului
        event.stopPropagation();
      });
    });
    
  
  </script>
  
  <nav class="navbar navbar-transparent-header fixed-top py-3" id="header">
    <div class="container-fluid">
      <div class="d-flex align-items-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          {{-- <span class="navbar-toggler-icon"></span> --}}
          <i class="bi bi-list text-white fs-2"></i>
        </button>
        <a href="/" class="text-primar"><h4 class="logo-brand mb-0">{!! Settings::get('name') !!}</h4></a>
      </div>
      <div class="d-flex">
        {{-- @if ($main_menu_items = $widget->menu_items()->orderBy('order')->take(3)->get())
          @foreach ($main_menu_items as $main_menu_item)
            <a class="text-white main-menu-item d-none d-sm-block p-2" href="{!! $main_menu_item->url !!}">
              {!! $main_menu_item->name !!}
            </a>
          @endforeach
        @endif --}}
        {{-- <button type="button" class="language-btn btn btn-link text-white text-decoration-none d-none d-lg-inline" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLanguageNav" aria-controls="offcanvasLanguageNav">
          English
          <span class="icon icon-chevron-down icon-f-white icon-s-24"></span>
        </button> --}}
        {{-- <div class="dropdown">
          <button type="button" class="language-btn btn btn-link text-white d-none d-lg-inline text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Romanian
            <span class="icon icon-chevron-down icon-f-white icon-s-24"></span>
          </button>
        
          <ul class="dropdown-menu dropdown-menu-end rounded-0">
            <li><a class="dropdown-item" href="#">English</a></li>
          </ul>
        </div> --}}
        @if (Auth::check())
          <div class="dropdown">
            <button class="btn text-white border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person fs-5"></i>
            </button>
            <ul class="dropdown-menu rounded-0 py-0" id="account-dropdown">
              <div class="row">
                <div class="col-md-12">
                    @if ($user = Auth::user())
                      <div class="py-3">
                        <li class="px-3 py-2">
                          <p><strong>{!! $user->name !!},</strong></p>
                          <p style="font-size: 14px;">Ne bucurăm să te vedem</p>
                        </li>
                      </div>
                      <li><hr class="dropdown-divider m-0"></li>
                      <div class="py-2">
                        @if ($user->access_level > 8)
                          <a href="/admin/dashboard" target="_blank">
                            <li class="dropdown-item">
                              <i class="bi bi-layout-text-sidebar-reverse"></i> Admin
                            </li>
                          </a>
                          @if (isset($page))
                            <a href="/admin/page/{{ $page->id }}/edit" target="_blank">
                              <li class="dropdown-item">
                              <i class="bi bi-pencil"></i> Editeaza pagina
                              </li>
                            </a>
                          @endif
                          @if (isset($page) && $page->product()->first())
                            <a href="/admin/products/{{ $page->product()->first()->id }}/edit" target="_blank">
                              <li class="dropdown-item">
                              <i class="bi bi-pencil"></i> Editeaza produs
                              </li>
                            </a>
                          @endif
                        @endif
                        <a id="user-contul-meu" href="/profilul-meu">
                          <li class="dropdown-item">
                            <i class="bi bi-person-circle"></i> Profilul meu
                          </li>
                        </a>
                        <a id="user-contul-meu" href="/comenzile-mele">
                          <li class="dropdown-item">
                            <i class="bi bi-box-seam"></i> Comenzile mele
                          </li>
                        </a>
                        <li><hr class="dropdown-divider"></li>
                        <a href="/logout">
                          <li class="dropdown-item text-danger">
                            <strong><i class="bi bi-box-arrow-right"></i> Delogare</strong>
                          </li>
                        </a>
                      </div>
                    @endif
                </div>
              </div>
            </ul>
          </div>
        @else
          {{-- <div class="dropdown">
            <button type="button" class="btn text-white dropdown-togglee" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              <i class="bi bi-person fs-5"></i>
            </button>
            <form method="POST" class="dropdown-menu dropdown-menu-end p-3" action="{{ route('login') }}">
              {{ csrf_field() }}
              <div class="mb-3">
                <label for="email" class="form-label">Adresa de email<span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Introdu adresa de email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Parola<span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Parola">
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                  <label class="form-check-label" for="dropdownCheck2">
                    Remember me
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primar">Autentificare</button>
            </form>
          </div> --}}
          <a class="btn text-white" href="/login" title="Contul meu"><i class="bi bi-person fs-5"></i></a>
        @endif
        <a class="btn text-white border-0 position-relative" href="#" title="Coș" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvas-cart">
          <i class="bi bi-bag fs-5"></i> <span class="position-absolute translate-middle badge rounded-pill bg-black" style="top: 10%; left: 75%;">{{ Cart::count() }}</span>
        </a>
      
        <a class="btn btn-light rounded-pill px-4 py-2" href="/contact">Contact</a>
      </div>
      <div class="offcanvas offcanvas-start p-4" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <a href="/" class="text-black"><h4 class="offcanvas-title" id="offcanvasNavbarLabel"><strong>{!! Settings::get('name') !!}</strong></h4></a>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size: 12px;"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          @if($menu_items = $widget->menu_items()->orderBy('order')->get())
            @if($menu_items = $widget->menu_items()->where("parent_id" , NULL)->orderBy('order')->get())
              <ul class="navbar-nav flex-grow-11 pe-3">
                @foreach ($menu_items as $key => $menu_item)
                  @if (($sub_items = $menu_item->menu_items()->active()->orderBy("order")->get()) && $sub_items->count() > 0)
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-togglee d-flex align-items-center justify-content-between" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {!! $menu_item->name !!}
                        <i class="bi bi-chevron-right"></i>
                      </a>
                      <ul class="dropdown-menu border-0 ms-2">
                        @foreach ($menu_item->childrenMenuItems as $childMenuItem)
                          @include('frontend/blocks.child_menu_item', ['child_menu_item' => $childMenuItem])
                        @endforeach
                      </ul>
                    </li>
                  @else
                    <li class="nav-item">
                      <a class="nav-link" href="{!! $menu_item->url !!}">
                        {!! $menu_item->name !!} <i class="bi bi-chevron-right opacity-0"></i>
                      </a>
                    </li>
                  @endif
                @endforeach
              </ul>
            @endif
          @endif
          <ul class="navbar-nav justify-content-end mt-4">
            <li class="nav-item">
              <a class="btn btn-dark rounded-pill w-75" href="/contact"><strong>Contact</strong></a>
            </li>
          </ul>
          <div class="mt-auto">
            @if(Settings::get('facebook_status'))
              <a class="text-dark" href="{!! Settings::get('facebook') !!}" title="{!! Settings::get('name') !!} - Facebook">
                  &nbsp;<i class="bi bi-facebook fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('instagram_status'))
              <a class="text-dark" href="{!! Settings::get('instagram') !!}" title="{!! Settings::get('name') !!} - Instagram">
                  &nbsp;<i class="bi bi-instagram fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('pinterest_status'))
              <a class="text-dark" href="{!! Settings::get('pinterest') !!}" title="{!! Settings::get('name') !!} - Pinterest">
                  &nbsp;<i class="bi bi-pinterest fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('twitter_status'))
              <a class="text-dark" href="{!! Settings::get('twitter') !!}" title="{!! Settings::get('name') !!} - Twitter">
                  &nbsp;<i class="bi bi-twitter fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('youtube_status'))
              <a class="text-dark" href="{!! Settings::get('youtube') !!}" title="{!! Settings::get('name') !!} - Youtube">
                  &nbsp;<i class="bi bi-youtube fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('phone'))
              <a class="text-dark" href="tel:{!! Settings::get('phone') !!}" title="{!! Settings::get('phone') !!}">
                  &nbsp;<i class="bi bi-telephone fs-5">&nbsp;</i>
              </a>
            @endif
            @if(Settings::get('mail'))
              <a class="text-dark" href="mailto:{!! Settings::get('mail') !!}" title="{!! Settings::get('mail') !!}">
                  &nbsp;<i class="bi bi-at fs-5">&nbsp;</i>
              </a>
            @endif
          </div>
        </div>
      </div>
  
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header p-4">
          <h4 class="offcanvas-title" id="offcanvasRightLabel"><strong>Coș de cumpărături</strong></h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size: 12px;"></button>
        </div>
        <div class="offcanvas-body" id="caart">
          @include('store/frontend/partials/cart-offcanvas')
        </div>
        @if (Cart::total() > 0)
          <div class="container">
            <div class="row">
              @if ($order_offer = Offers::order())
                <div class="col-md-12 discounts">
                    <span class="amount total">
                        @if ($all = Cart::subtotal())
                        @endif
                        {!! General::calc($all) !!} lei
                    </span>
                    @if (Cart::total() > 0)
                        @if ($user = Auth::user())
                            @if (Cart::client($user->id))
                                <span class="amount user_discount">
                                    - {{ General::calc(Cart::client($user->id, Cart::total())->discount) }} lei (ofertă
                                    client)
                                </span>
                            @endif
                        @endif
                        {{-- @if (Cart::products_discount())
                            <span class="amount products_discount">
                                - {{ General::calc(Cart::products_discount()) }} lei (ofertă)
                            </span>
                        @endif --}}
                        @if ($voucher_offer = Cart::voucher())
                            @if (($discount_voucher = $voucher_offer->discount) > 0)
                                <span class="amount products_discount">
                                    - {{ General::calc($voucher_offer->discount) }} (voucher)
                                </span>
                            @endif
                        @endif
                        @if ($order_offer)
                            @if (Cart::total() > $order_offer->code)
                                <span class="amount order_discount">
                                    - {{ General::calc(Cart::order()->discount) }} (promoție)
                                </span>
                            @endif
                        @endif
                    @endif
                </div>
              @endif
              <div class="col-md-12 my-3 d-flex text-black justify-content-between">
                <span class="fw-bold total">
                  Subtotal:
                </span>
                <span class="fw-bold amount">
                  {{ Cart::total() }} lei
                </span>
              </div>
              <div class="col-md-12 mb-3">
                <a href="/cos-de-cumparaturi" class="btn btn-primar w-100 rounded-0">
                  Vezi coș
                </a>
              </div>
              {{-- <div class="col-md-12 my-2">
                <a href="/plaseaza-comanda" class="btn btn-success rounded-0 w-100">Finalizare comanda</a>
              </div> --}}
            </div>
          </div>
        @endif
      </div>
  
      {{-- <div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasLanguageNav" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header p-4">
          <h4 class="offcanvas-title" id="offcanvasRightLabel"><strong>{!! Settings::get('name') !!}</strong></h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size: 12px;"></button>
        </div>
        <div class="offcanvas-body">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                English
              </div>
            </div>
          </div>
        </div>
      </div> --}}
    </div>
  </nav>
  
  