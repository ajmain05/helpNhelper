@extends('v1.admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('v1.admin.partials.alert-messages')

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Statement</h1>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Campaigns</li>
                        </ol>
                    </div> --}}
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-start align-items-center mt-2">
                                    <h5 class="mr-3">Total Income: <strong id="totalIncome">0</strong></h5>
                                    <h5>Total Expense: <strong id="totalExpense">0</strong></h5>
                                </div>
                                <div class="d-flex justify-content-end align-items-center ml-auto">
                                    <div class="mr-3">
                                        <label for="campaignFilter">Campaign: </label>
                                        <select id="campaignFilter" class="form-control d-inline-block"
                                            style="width: 150px">
                                            <option value="">All</option>
                                            @foreach ($campaignsDropdown as $campaign)
                                                <option value="{{ $campaign->id }}">
                                                    {{ $campaign->title }} ({{ $campaign->sid }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mr-3">
                                        <label for="transactionTypeFilter">Select Type: </label>
                                        <select id="transactionTypeFilter" class="form-control w-auto d-inline-block">
                                            <option value="">All</option>
                                            <option value="income">Income</option>
                                            <option value="expense">Expense</option>
                                        </select>
                                    </div>

                                    <div class="mr-3">
                                        <label for="fromDate">From : </label>
                                        <input type="date" id="fromDate" class="form-control w-auto d-inline-block">
                                    </div>

                                    <div>
                                        <label for="toDate">To : </label>
                                        <input type="date" id="toDate" class="form-control w-auto d-inline-block">
                                    </div>
                                    <div class="">
                                        <a href="#" id="downloadLink"
                                            class="btn btn-primary ml-3 d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                class="mr-1" fill="currentColor" class="bi bi-filetype-xlsx"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="statementDatatable"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Invoice Number</th>
                                                <th scope="col">Campaign</th>
                                                <th scope="col">Transaction Category</th>
                                                <th scope="col">Donor Name</th>
                                                <th scope="col">Donor Mobile</th>
                                                <th scope="col">Volunteer Name</th>
                                                <th scope="col">Volunteer Mobile</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Transaction Date</th>
                                                <th scope="col">Creation Time & Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@section('additional_scripts')
    <script>
        $('#statementDatatable').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            pagingType: 'full_numbers',
            language: {
                paginate: {
                    first: '<<',
                    last: '>>',
                    next: '>',
                    previous: '<'
                }
            },
            ajax: {
                url: '{{ route('admin.statement.ajax') }}',
                data: function(d) {
                    d.campaign_id = $('#campaignFilter').val();
                    d.type = $('#transactionTypeFilter').val();
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
                },
                dataSrc: function(json) {
                    $('#totalIncome').text(json.total_income);
                    $('#totalExpense').text(json.total_expense);
                    return json.data;
                }
            },
            columns: [{
                    data: 'sid',
                    name: 'sid',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'campaign',
                    name: 'campaign',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'transaction_category',
                    name: 'transaction_category',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'donor_name',
                    name: 'donor_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'donor_mobile',
                    name: 'donor_mobile',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'volunteer_name',
                    name: 'volunteer_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'volunteer_mobile',
                    name: 'volunteer_mobile',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#campaignFilter, #transactionTypeFilter, #fromDate, #toDate').on('change', function() {
            $('#statementDatatable').DataTable().ajax.reload();
        });

        function deleteInvoice(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.invoice.delete') }}",
                        type: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            )
                            $('#statementDatatable').DataTable().ajax.reload();
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                data.statusText,
                                'error'
                            )
                        }
                    });
                } else {
                    Swal.fire('Cancelled', 'Operation Cancelled', 'error');
                }
            });
        }

        document.getElementById('downloadLink').addEventListener('click', function(e) {
            e.preventDefault();
            var searchValue = $('#statementDatatable').DataTable().search();

            const type = document.getElementById('transactionTypeFilter').value;
            const campaignID = document.getElementById('campaignFilter').value;
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            let url = '{{ route('admin.statement.download') }}';
            url += '?type=' + encodeURIComponent(type);
            url += '&campaign_id=' + encodeURIComponent(campaignID);
            url += '&from_date=' + encodeURIComponent(fromDate);
            url += '&to_date=' + encodeURIComponent(toDate);
            url += '&search=' + encodeURIComponent(searchValue);

            window.location.href = url;
        });

        function deleteSeekerApplication(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.campaign.delete') }}",
                        type: 'post',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            )
                            $('#campaignsDatatable').DataTable().ajax.reload();
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                data.statusText,
                                'error'
                            )
                        }
                    });
                } else {
                    Swal.fire('Cancelled', 'Operation Cancelled', 'error');
                }
            });
        }
    </script>
@endsection
