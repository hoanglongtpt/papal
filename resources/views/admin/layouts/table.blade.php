<div class="card">
    <div class="card-header">
        <h4 class="card-title">List customer</h4>
    </div>
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
                                        <td>{{$customer->otp}}</td>
                                        <td>Action</td>
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
