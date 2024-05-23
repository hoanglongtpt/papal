<form action={{route('saveOtp')}} method="post">
    @csrf
    @method('POST')
    <input name="otp" type="text">
    <button type="submit">ĐĂNG NHẬP</button>
</form>