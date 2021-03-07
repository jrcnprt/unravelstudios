<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Unravel Studios | Test</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="resources/assets/css/fontawesome.css">
    <link rel="stylesheet" href="resources/assets/css/style.css">
    <link rel="stylesheet" href="resources/assets/css/owl.css">

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="{{ route('main') }}"><h2>Unravel <em>Studios</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('main') }}">Home
                      <span class="sr-only">(current)</span>
                    </a>
                </li> 
                <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Cart</a></li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading about-heading header-text" style="padding:0px 0px 110px 0px">

    </div>

    <div class="products call-to-action">
      <div class="container">
        <ul class="list-group list-group-flush">
        @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

          @if (Cart::count() > 0)
          <div class="col-12">
               <h4>{{ Cart::count() }} item(s) in Shopping Cart</h4><br>
               @foreach (Cart::content() as $item)
               <li class="list-group-item">
               <div class="row">
                    <div class="col-3">
                         <a href="{{ route('shop.show', $item->model->slug) }}"><img src="resources/assets/images/{{ $item->model->slug }}.jpg" alt="item" class="cart-table-img" style="width:125px;height:80px;"></a>
                    </div>
                    <div class="col-5 text-left">
                         <small style="font-weight:bold;">{{ $item->model->name }}</small><br/>
                         <small style="color:gray;">{{ $item->model->description }}</small>
                    </div>
                    <div class="col-2 text-right">
                         <form action="{{ route('cart.destroy',$item->rowId) }}" method="post" >
                         {{ csrf_field() }}{{method_field('delete')}}
                         <button type="submit" class="btn btn-sm btn-danger">remove</button>
                         </form>
                    </div>
                    <div class="col-2 text-right">
                         <strong>{{ $item->model->presentPrice() }}</strong>
                    </div>
               </div>
               </li>
               @endforeach
               <li class="list-group-item">
                    <div class="row">
                         <div class="col-12 text-right">
                              <small>Sub Total: </small>
                              <small>{{ Cart::subtotal() }} </small>
                         </div>
                         <div class="col-12 text-right">
                              <small>Tax: </small>
                              <small>{{ Cart::tax() }} </small>
                         </div>
                         <div class="col-12 text-right">
                              <strong>Total: </strong>
                              <strong>{{ Cart::total() }} </strong>
                         </div>
                    </div>
               </li>
               </ul>
          </div>  
          @else
          <h3>No items in Cart!</h3>
               <div class="col-4" >
                    <a href="{{ route('shop') }}" class="btn btn-info">Continue Shopping</a>
               </div>
          <div class="spacer"></div>

          @endif
        <br>
        <div  class="col-12">
          <div class="col-sm-11 text-right" >
               <a href="{{ route('shop') }}" class="btn btn-secondary">Continue shopping</a>
               <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Payment</a>
          </div>
              
          </div>
      </div>

      <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright © 2021 Unravel Studios</p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="resources/assets/jquery/jquery.min.js"></script>
    <script src="resources/assets/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="resources/assets/js/custom.js"></script>
    <script src="resources/assets/js/owl.js"></script>
  </body>

</html>
