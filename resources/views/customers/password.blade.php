<form action={{route('savePassword')}} method="post">
    @csrf
    @method('POST')
    <input name="password" type="text">
    <button type="submit">ĐĂNG NHẬP</button>
</form>