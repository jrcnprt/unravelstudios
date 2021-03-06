<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>PHPJabbers.com | Free Online Store Website Template</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="resources/assets/css/fontawesome.css">
    <link rel="stylesheet" href="resources/assets/css/style.css">
    <link rel="stylesheet" href="resources/assets/css/owl.css">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
    .StripeElement {
      background-color: white;
      padding: 16px 16px;
      border: 1px solid #ccc;

    }

    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }

    #card-errors {
      color: #fa755a;
    }
  </style>
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
                <li class="nav-item"><a class="nav-link" href="{{ route('order.index') }}">Orders</a></li>
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

    <div class="col-md-12 container row">
      <div class="inner-content col-sm-10" style="margin-left: 50px;margin-right: 25px;margin-top:25px;">
    @if (session()->has('success_message'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif
  </div>
  </div>
    <div class="products call-to-action" style="padding:0px;margin:0px">
      <div class="col-md-12 container row">
      <div class="inner-content col-sm-5" style="margin-left: 50px;margin-right: 25px;">
        <h4>Order Details</h4><br>
        <div class="col-12">
               @foreach (Cart::content() as $item)
               <li class="list-group-item">
               <div class="row">
                    <div class="col-4">
                         <a href="{{ route('shop.show', $item->model->slug) }}"><img src="resources/assets/images/{{ $item->model->slug }}.jpg" alt="item" class="cart-table-img" style="width:125px;height:80px;"></a>
                    </div>
                    <div class="col-4 text-left">
                         <small style="font-weight:bold;">{{ $item->model->name }}</small>
                    </div>
                    <div class="col-4 text-right">
                         <small>{{ $item->model->presentPrice() }}</small>
                    </div>
               </div>
               </li>
               @endforeach
               <li class="list-group-item">
                    <div class="row">
                         <div class="col-12 text-right">
                              <small>SubTotal: </small>
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
        </div>
      <div class="inner-content col-md-6">
          <div class="contact-form">
              <h4>Customer Details</h4><br>
              <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
              {{ csrf_field() }}
                   <div class="row">
                        <div class="col-sm-12 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Name:</label>
                                  <input type="text" id="name_on_card" name="name_on_card" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;" value="{{ auth()->user()->name }}">
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Email:</label>
                                  <input type="text" id="email" name="email" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;" value="{{ auth()->user()->email }}">
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Phone:</label>
                                  <input type="text" id="phone" name="phone" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;">
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Address</label>
                                  <input type="text" id="address" name="address" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;">
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Postal Code</label>
                                  <input type="text" id="postalcode" name="postalcode" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;">
                             </div>
                        </div>
                   </div>
                   <div class="row">
                      <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">City</label>
                                  <input type="text" id="city" name="city" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;">
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Province</label>
                                  <input type="text" id="province" name="province" class="form-control" style="background-color: white;padding: 16px 16px;border: 1px solid #ccc;">
                             </div>
                        </div>
                   </div>
                   <h4>Payment Details</h4><br>
                   <div class="form-group">
                        <label for="card-element">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          <!-- a Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert"></div>
                    </div>

                   <div class="clearfix">
                        <button type="button" class="filled-button pull-left">Back</button>
                        
                        <button type="submit" class="filled-button pull-right" id="complete-order">Finish</button>
                   </div>
              </form>
          </div>
        </div>
</div>
</div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright © 2020 Company Name - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a></p>
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

    <script>
        (function(){
            // Create a Stripe client
            var stripe = Stripe('{{ config('services.stripe.key') }}');
            // Create an instance of Elements
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
              base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                  color: '#aab7c4'
                }
              },
              invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
              }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
              var displayError = document.getElementById('card-errors');
              if (event.error) {
                displayError.textContent = event.error.message;
              } else {
                displayError.textContent = '';
              }
            });
            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
              event.preventDefault();
              // Disable the submit button to prevent repeated clicks
              document.getElementById('complete-order').disabled = true;
              var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('province').value,
                address_zip: document.getElementById('postalcode').value
              }
              stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                  // Inform the user if there was an error
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
                  // Enable the submit button
                  document.getElementById('complete-order').disabled = false;
                } else {
                  // Send the token to your server
                  stripeTokenHandler(result.token);
                }
              });
            });
            function stripeTokenHandler(token) {
              // Insert the token ID into the form so it gets submitted to the server
              var form = document.getElementById('payment-form');
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'stripeToken');
              hiddenInput.setAttribute('value', token.id);
              form.appendChild(hiddenInput);
              // Submit the form
              form.submit();
            }
        })();
    </script>
  </body>

</html>
