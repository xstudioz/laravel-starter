<header class="d-none d-md-block">
  <div class="container pt-1 pb-1 pt-md-3 pb-md-3">
    <div class="row">
      <div class="col-sm-6">
        <div class="d-flex align-items-center">
          <a id="logo" class="d-block mr-4" href="{{URL::to('/')}}"> <img src="{{asset('images/logo.svg')}}" alt=""> </a>
          <div class="mini-links-header d-none d-md-block">
            <a class="{{request()->routeIs('home') ? ' activeColor ':null}}  text-center" href="{{route('home')}}">
              <i class="fa fa-h-square" aria-hidden="true"></i> Hotel
            </a>
            <a class=" text-center" href="{{route('booking.cab')}}">
              <i class="fa fa-taxi" aria-hidden="true"></i>Cab
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-6" id="menu">
        <overlay :opened="opened" :visible="visible" @closed="opened = visible = false">
          <div id="login-box" class="p-4">
            <h3 class="fw-bold mb-4">Login / Register</h3>
            <div class="alert alert-danger" v-if="error">@{{error}}</div>
            <div v-if="otpScreen===false">
              <p>Please enter your phone number to continue. </p>
              <form action="google.com" v-on:submit.prevent="sendOtp()">
                <div class="mb-3">
                  <div class="d-flex align-items-center phone">
                    <div>+91</div>
                    <input maxlength="10" @input="isNumber($event);checkMobile()" v-model="mobile" type="text" name="phone">
                  </div>
                  <small v-if="invalidPhone" class="text-danger">Invalid phone number</small>
                </div>
                <a class="xs-btn-orange" @click="sendOtp()">
                  <span v-if="!loading">Verify Number</span><span v-if="loading">Please wait...</span>
                  <i class="fa fa-angle-right ms-2"></i>
                </a>

              </form>
            </div>
            <div v-if="otpScreen===true">
              <form v-on:submit="login()">
                <label class="mb-2">We have sent a temporary passcode to you at <strong class="text-success">@{{mobile}}</strong>. If you want to change your number please <a @click="reset()"
                                                                                                                                                                               class="bg-info px-3 text-light text-decoration-none text-white">click
                    here</a></label>
                <div class="phone mb-3">
                  <input v-model="otp" class="p-3" type="text" name="phone">
                </div>

                <a type="submit" class="xs-btn-orange" @click="login()">
                  <span v-if="!loading">Login</span><span v-if="loading">Please wait...</span>
                  <i class="fa fa-angle-right ms-2"></i>
                </a>

              </form>
            </div>
          </div>
        </overlay>
        <div class="d-flex justify-content-end header-menu m-0">
          <div class="d-flex align-items-center store-logos">c
            <a href=""><img src="{{asset('images/stores/play.svg')}}" alt="google-play-store"></a>
            <a href=""><img src="{{asset('images/stores/ios.svg')}}" alt="ios-play-store"></a>
          </div>
          @guest()
            <a class="xs-btn-orange xs-btn-sm text-decoration-none" @click="opened=visible=true" id="login-btn" href="#">Login/SignUp</a>
          @endguest
          @auth()
            <a href="{{route('account.bookings')}}" class="xs-btn-orange xs-btn-sm">My Account</a>
          @endauth()
        </div>
      </div>
    </div>
  </div>
</header>
@if(session()->has('message'))
  <div class="alert mb-0 text-center alert-{{session()->get('message.type')}}">{{session()->get('message.message')}}</div>
@endif
<script>
  var loginApp = new Vue({
    el: '#menu',
    methods: {
      reset: function () {
        this.otpScreen = false;
        this.mobile = '';
        this.loading = false;
        this.error = false;
        this.otp = '';
      },
      isNumber: function (evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
          evt.preventDefault();
        } else {
          return true;
        }
      },
      checkMobile: function () {
        var invalid = !(this.mobile && this.mobile.length === 10);
        this.invalidPhone = !!(invalid && this.mobile && this.mobile.length > 0);
        return invalid;
      },
      sendOtp: function () {
        console.log('tes');
        if (this.checkMobile()) return true;
        const _this = this;
        this.loading = true;
        axios.post("{{route('login.otp')}}", {mobile: this.mobile})
          .then(function (d) {
            _this.otpScreen = true;
            _this.loading = false;
          }).catch(err => {
          alert('something went wrong');
        });
      },
      login: function () {
        if (this.otp.length !== 4) return;
        this.loading = true;
        var _this = this;
        axios.post("{{route('login.verify-otp')}}", {mobile: this.mobile, otp: this.otp})
          .then(function (d) {
            console.log(d);
            //all good here
            if (d.data.redirect) {
              window.location.href = d.data.redirect
            } else {
              //close it
              _this.opened = false;
              _this.visible = false;
              window.location.reload();
            }
          }).catch(function (error) {
          _this.error = error.response.data.message;
        }).then(function () {
          _this.loading = false;
        })
      }
    },
    data() {
      return {
        invalidPhone: false,
        opened: false, //
        visible: false,

        loading: false,
        error: false,
        mobile: '',
        otpScreen: false,
        otp: ''
      }
    },
  })
</script>
