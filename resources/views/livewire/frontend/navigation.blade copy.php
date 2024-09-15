<div>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
              var scrollTop = $(window).scrollTop();
        
              // Verificăm dacă utilizatorul face scroll în jos
              if (scrollTop > 0) {
                $('#header').addClass('navbar-white-header py-3').removeClass('navbar-transparent-header py-2');
                $('.site-logo').removeClass('d-none').addClass('d-block');
                $('.icon-bag').removeClass('d-none').addClass('d-block');
                $('.site-logo--inverse').removeClass('d-block').addClass('d-none');
                $('.icon-bag--inverse').removeClass('d-block').addClass('d-none');
              } else {
                $('#header').addClass('navbar-transparent-header py-2').removeClass('navbar-white-header py-3');
                $('.site-logo').removeClass('d-block').addClass('d-none');
                $('.icon-bag').removeClass('d-block').addClass('d-none');
                $('.site-logo--inverse').removeClass('d-none').addClass('d-block');
                $('.icon-bag--inverse').removeClass('d-none').addClass('d-block');
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

        $(document).ready(function () {
            Livewire.on('closeLoginModal', function () {
                $('#loginModal').modal('hide');
            });
        });
    </script>
    <header class="fixed-top">
        <div class="container-fluid g-0 bg-black">
          <div class="row g-0">
              <div class="col-md-4 offset-md-4 text-center text-white py-2">
                  {{-- <p class="m-0 fs-9">
                      <strong>LIMITED LIFETIME WARRANTY FOR MEMBERS</strong>
                  </p> --}}
                  <p class="m-0 fs-9">
                      <strong>FREE SHIPPING ON ORDERS ABOVE &euro;299</strong>
                  </p>
              </div>
          </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-transparent-header px-md-5" id="header">
          <div class="container-fluid">
            <a class="navbar-brand" href="/">
              <svg class="site-logo d-none" xmlns="http://www.w3.org/2000/svg" width="110" height="22" viewBox="0 0 110 22" fill="none">
                <g clip-path="url(#clip0_365_23075)">
                <path d="M8.829 0H0V21.575H8.829C15.0895 21.575 18.695 17.0766 18.695 10.7875C18.695 4.49837 15.0895 0 8.829 0ZM8.18567 17.9887H4.27287V3.58628H8.18567C11.7288 3.58628 14.2973 5.86412 14.2973 10.7875C14.2973 15.7109 11.7336 17.9887 8.18567 17.9887Z" fill="black"></path>
                <path d="M48.3314 18.8435H20.3513V21.5798H48.3314V18.8435Z" fill="black"></path>
                <path d="M99.6346 18.8435H71.6401V21.5798H99.6346V18.8435Z" fill="black"></path>
                <path d="M61.5916 5.59193C59.4504 5.59193 57.9237 6.37986 56.8867 7.6883V0H52.9163V21.575H56.613V19.6028C57.65 21.1213 59.2391 22.0048 61.5628 22.0048C65.5332 22.0048 68.5002 18.8435 68.5002 13.8007C68.5002 8.75798 65.5668 5.5967 61.5964 5.5967L61.5916 5.59193ZM60.6458 18.5665C58.447 18.5665 56.733 16.8331 56.733 13.796C56.733 10.7588 58.3846 8.99675 60.6746 8.99675C62.9647 8.99675 64.4626 10.8782 64.4626 13.796C64.4626 16.7137 62.9023 18.5665 60.641 18.5665H60.6458Z" fill="black"></path>
                <path d="M108.444 0L106.874 3.98741L105.218 0H103.663V5.39614H104.772V1.57586L106.37 5.39614H107.364L108.905 1.51856V5.39614H110V0H108.444Z" fill="black"></path>
                <path d="M97.8918 1.01715H99.697V5.39614H100.892V1.01715H102.683V0H97.8918V1.01715Z" fill="black"></path>
                </g>
                <defs>
                <clipPath id="clip0_365_23075">
                <rect width="110" height="22" fill="black"></rect>
                </clipPath>
                </defs>
              </svg>
              <svg class="site-logo--inverse d-block" xmlns="http://www.w3.org/2000/svg" width="110" height="22" viewBox="0 0 110 22" fill="none">
                <g clip-path="url(#clip0_365_23075)">
                <path d="M8.829 0H0V21.575H8.829C15.0895 21.575 18.695 17.0766 18.695 10.7875C18.695 4.49837 15.0895 0 8.829 0ZM8.18567 17.9887H4.27287V3.58628H8.18567C11.7288 3.58628 14.2973 5.86412 14.2973 10.7875C14.2973 15.7109 11.7336 17.9887 8.18567 17.9887Z" fill="white"></path>
                <path d="M48.3314 18.8435H20.3513V21.5798H48.3314V18.8435Z" fill="white"></path>
                <path d="M99.6346 18.8435H71.6401V21.5798H99.6346V18.8435Z" fill="white"></path>
                <path d="M61.5916 5.59193C59.4504 5.59193 57.9237 6.37986 56.8867 7.6883V0H52.9163V21.575H56.613V19.6028C57.65 21.1213 59.2391 22.0048 61.5628 22.0048C65.5332 22.0048 68.5002 18.8435 68.5002 13.8007C68.5002 8.75798 65.5668 5.5967 61.5964 5.5967L61.5916 5.59193ZM60.6458 18.5665C58.447 18.5665 56.733 16.8331 56.733 13.796C56.733 10.7588 58.3846 8.99675 60.6746 8.99675C62.9647 8.99675 64.4626 10.8782 64.4626 13.796C64.4626 16.7137 62.9023 18.5665 60.641 18.5665H60.6458Z" fill="white"></path>
                <path d="M108.444 0L106.874 3.98741L105.218 0H103.663V5.39614H104.772V1.57586L106.37 5.39614H107.364L108.905 1.51856V5.39614H110V0H108.444Z" fill="white"></path>
                <path d="M97.8918 1.01715H99.697V5.39614H100.892V1.01715H102.683V0H97.8918V1.01715Z" fill="white"></path>
                </g>
                <defs>
                <clipPath id="clip0_365_23075">
                <rect width="110" height="22" fill="white"></rect>
                </clipPath>
                </defs>
              </svg>
              {{-- <img src="/dir/logo.svg" alt="Logo {!! env('APP_NAME') !!}" width="40%" height="100%"> --}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse align-items-center justify-content-end" id="navbarSupportedContent">
                <form class="d-flex" role="search">
                    <div class="form">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control form-input border-0 border-bottom rounded-0" placeholder="Cautare">
                    </div>
                </form>
                <div class="px-3">
                    <div class="dropdown">
                        @if($auth = Auth::user())
                            <button class="btn border-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="site-icon-account">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 17 19" fill="none">
                                    <path d="M8.48779 10.3517L8.5 10.352L8.51221 10.3517C9.83935 10.3193 10.968 9.86402 11.8628 8.97508C12.7578 8.08595 13.2172 6.96318 13.2498 5.642L13.2502 5.62963L13.2498 5.61726C13.2172 4.29608 12.7578 3.17331 11.8628 2.28418C10.968 1.39524 9.83935 0.939965 8.51221 0.907556L8.5 0.907258L8.48779 0.907556C7.16065 0.939965 6.03198 1.39524 5.13719 2.28418C4.24221 3.17331 3.78284 4.29608 3.75015 5.61726L3.74985 5.62963L3.75015 5.642C3.78284 6.96318 4.24221 8.08595 5.13719 8.97508C6.03198 9.86402 7.16065 10.3193 8.48779 10.3517ZM16.0833 16.1852H16.0835L16.0832 16.173C16.0656 15.4531 15.8128 14.8287 15.3159 14.3351C14.8193 13.8417 14.1923 13.5916 13.4704 13.5742L13.4704 13.5741H13.4583H3.54167V13.5739L3.52965 13.5742C2.80768 13.5916 2.18073 13.8417 1.68407 14.3351C1.18721 14.8287 0.934352 15.4531 0.916815 16.173L0.916667 16.173V16.1852V18.2963C0.916667 18.383 0.893675 18.4193 0.865231 18.4475C0.836538 18.4761 0.798433 18.5 0.708333 18.5C0.618234 18.5 0.580129 18.4761 0.551433 18.4475C0.522992 18.4193 0.5 18.383 0.5 18.2963V16.1929C0.527638 15.318 0.827715 14.6166 1.39293 14.0551C1.95837 13.4934 2.66589 13.1942 3.54924 13.1667H13.4508C14.3341 13.1942 15.0416 13.4934 15.6071 14.0551C16.1723 14.6166 16.4724 15.318 16.5 16.1928V18.2963C16.5 18.383 16.477 18.4193 16.4486 18.4475C16.4199 18.4761 16.3818 18.5 16.2917 18.5C16.2016 18.5 16.1635 18.4761 16.1348 18.4475C16.1063 18.4193 16.0833 18.383 16.0833 18.2963V16.1852ZM12.1539 9.25507C11.1918 10.2109 9.98521 10.7155 8.5 10.7591C7.01479 10.7155 5.8082 10.2109 4.84606 9.25507C3.88417 8.29947 3.37741 7.10232 3.33354 5.62963C3.37741 4.15694 3.88417 2.95979 4.84606 2.00419C5.8082 1.04834 7.01479 0.543804 8.5 0.500201C9.98521 0.543804 11.1918 1.04834 12.1539 2.00419C13.1158 2.95979 13.6226 4.15694 13.6665 5.62963C13.6226 7.10232 13.1158 8.29947 12.1539 9.25507Z"></path>
                                </svg>
                                </span>
                                <span class="account-subtitle fs-7">Account</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end rounded-0 py-0" style="width: 350px;">
                                <li><a href="#" class="dropdown-item"><strong>Welcome back,</strong> <br /> {!! $auth->name !!}</a></li>
                                <li class="dropdown-divider m-0"></li>
                                <li><a href="#" class="dropdown-item">Orders</a></li>
                                <li><a href="#" class="dropdown-item">Account settings</a></li>
                                <li class="dropdown-divider m-0"></li>
                                <li><a href="#" class="dropdown-item text-danger" wire:click="logout">Log out</a></li>
                                <li class="dropdown-divider m-0"></li>
                                <li class="mb-3 mx-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="dark-mode" {{ isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'checked' : '' }}>
                                    <i class="bi bi-{{ isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'sun' : 'moon-stars-fill' }} change-icon"></i>
                                </div>
                                </li>
                            </ul>
                        @else
                            <button class="btn border-0 d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <span class="site-icon-account">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 17 19" fill="none">
                                        <path d="M8.48779 10.3517L8.5 10.352L8.51221 10.3517C9.83935 10.3193 10.968 9.86402 11.8628 8.97508C12.7578 8.08595 13.2172 6.96318 13.2498 5.642L13.2502 5.62963L13.2498 5.61726C13.2172 4.29608 12.7578 3.17331 11.8628 2.28418C10.968 1.39524 9.83935 0.939965 8.51221 0.907556L8.5 0.907258L8.48779 0.907556C7.16065 0.939965 6.03198 1.39524 5.13719 2.28418C4.24221 3.17331 3.78284 4.29608 3.75015 5.61726L3.74985 5.62963L3.75015 5.642C3.78284 6.96318 4.24221 8.08595 5.13719 8.97508C6.03198 9.86402 7.16065 10.3193 8.48779 10.3517ZM16.0833 16.1852H16.0835L16.0832 16.173C16.0656 15.4531 15.8128 14.8287 15.3159 14.3351C14.8193 13.8417 14.1923 13.5916 13.4704 13.5742L13.4704 13.5741H13.4583H3.54167V13.5739L3.52965 13.5742C2.80768 13.5916 2.18073 13.8417 1.68407 14.3351C1.18721 14.8287 0.934352 15.4531 0.916815 16.173L0.916667 16.173V16.1852V18.2963C0.916667 18.383 0.893675 18.4193 0.865231 18.4475C0.836538 18.4761 0.798433 18.5 0.708333 18.5C0.618234 18.5 0.580129 18.4761 0.551433 18.4475C0.522992 18.4193 0.5 18.383 0.5 18.2963V16.1929C0.527638 15.318 0.827715 14.6166 1.39293 14.0551C1.95837 13.4934 2.66589 13.1942 3.54924 13.1667H13.4508C14.3341 13.1942 15.0416 13.4934 15.6071 14.0551C16.1723 14.6166 16.4724 15.318 16.5 16.1928V18.2963C16.5 18.383 16.477 18.4193 16.4486 18.4475C16.4199 18.4761 16.3818 18.5 16.2917 18.5C16.2016 18.5 16.1635 18.4761 16.1348 18.4475C16.1063 18.4193 16.0833 18.383 16.0833 18.2963V16.1852ZM12.1539 9.25507C11.1918 10.2109 9.98521 10.7155 8.5 10.7591C7.01479 10.7155 5.8082 10.2109 4.84606 9.25507C3.88417 8.29947 3.37741 7.10232 3.33354 5.62963C3.37741 4.15694 3.88417 2.95979 4.84606 2.00419C5.8082 1.04834 7.01479 0.543804 8.5 0.500201C9.98521 0.543804 11.1918 1.04834 12.1539 2.00419C13.1158 2.95979 13.6226 4.15694 13.6665 5.62963C13.6226 7.10232 13.1158 8.29947 12.1539 9.25507Z"></path>
                                    </svg>
                                </span>
                                <span class="account-subtitle fs-7">Account</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div>
                    <livewire:frontend.count-cart />
                    {{-- <a href="#offcanvasExample" class="text-black" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasExample">
                        <i class="bi bi-bag fs-5"></i> {{ Cart::content()->count() }}
                    </a> --}}
                </div>
            </div>
          </div>
        </nav>
        
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cos de cumparaturi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
              @foreach (Cart::content()->groupBy('id') as $cart_products)
                  @foreach ($cart_products as $key => $cart)
                      <div class="row">
                          <div class="col-4">                        
                              <img src="{!! $cart->options->picture !!}" class="img-fluid" alt="">
                          </div>
                          <div class="col-8">
                              <p class="mb-0"><strong>{!! $cart->name !!}</strong></p>
                              <p class="mb-0">{!! $cart->price !!}</p>
                          </div>
                      </div>
                      <hr />
                  @endforeach
              @endforeach
          </div>
          <div class="row" style="padding: 1rem;">
              <div class="col-md-12 discounts">
                  <span class="amount total">
                      {{ Cart::subtotal() }}
                  </span>
              </div>
              <div class="col-md-12">
                  <div class="d-grid gap-2">
                      <a href="#" class="btn btn-success">Checkout</a>
                  </div>
              </div>
          </div>
        </div>
    </header>
      
        
    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <form wire:submit.prevent="login">
                                    @csrf
                    
                                    <div class="text-center">
                                        <a href="/"><img class="mb-4" src="{{ asset('dir/images/bootstrap-logo.svg') }}" alt="" width="72" height="57"></a>
                                    </div>
                                
                                    <div class="mt-3">
                                        <label for="email">Email</label>
                                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
     
                                    <div class="mt-3">
                                        <label for="password">Password</label>
                                        <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <button class="btn btn-primary w-100 mt-3" type="submit" wire:click.prevent="login">Sign in</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#registerModal">Don't have an account?</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#resetModal">Forgot password?</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="registerModalLabel">Register</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    @csrf
                    
                                    <div class="text-center">
                                        <a href="/"><img class="mb-4" src="{{ asset('dir/images/bootstrap-logo.svg') }}" alt="" width="72" height="57"></a>
                                    </div>

                                    <div class="mt-3">
                                        <label for="name">Name</label>
                                        <input type="name" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <div class="mt-3">
                                        <label for="email">Email</label>
                                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
     
                                    <div class="mt-3">
                                        <label for="password">Password</label>
                                        <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label for="password">Repeat password</label>
                                        <input type="password" wire:model="repeat_password" class="form-control @error('repeat_password') is-invalid @enderror" id="repeat_password">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <button class="btn btn-primary w-100 mt-3" type="submit" wire:click.prevent="registerStore">Register</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
