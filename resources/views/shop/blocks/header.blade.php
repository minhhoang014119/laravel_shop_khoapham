<div class="headerstrip">
    <div class="container">
      <div class="row">
        <div class="span12">
          <a href="{{ url('/') }}" class="logo pull-left"><img src="{{ secure_url('/shop/img/logo.png') }}" alt="SimpleOne" title="SimpleOne"></a>
          <!-- Top Nav Start -->
          <div class="pull-left">
            <div class="navbar" id="topnav">
              <div class="navbar-inner">
                <ul class="nav" >
                  <li>
                    <a class="home active" href="{{ secure_url('/') }}">Home</a>
                  </li>
                  <li>
                    <a class="myaccount" href="{!! route('getMyAccout') !!}">My Account</a>
                  </li>
                  <li>
                    <a class="shoppingcart" href="#">Shopping Cart</a>
                  </li>
                  <li>
                    <a class="checkout" href="{{ route('totalCart') }}">CheckOut</a>
                  </li>

                </ul>
              </div>
            </div>
          </div>
          <!-- Top Nav End -->
          <div class="pull-right log-reg">
            <ul class="nav">
              <li><button type="button" class="btn" name="button"><span class="glyphicon glyphicon-log-in"></span> <a href="{{ secure_url('admin/login') }}" id="btn-login">Login</a></button></li>
              <li><button type="button" class="btn" name="button"><span class="glyphicon glyphicon-registration-mark"></span> <a href="{{ secure_url('register') }}">Register</a></button></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $('#btn-login').addEventListener('click',function () {
      alert(1);
      return false;
  })
</script>