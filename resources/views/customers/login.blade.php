<form id="loginForm" action="{{ route('saveEmail') }}" method="post">
    @csrf
    @method('POST')
    <input type="text" name="email">
    <button type="submit" id="submitBtn">ĐĂNG NHẬP</button>
</form>
<div id="loading" style="display: none;">Loading...</div>
