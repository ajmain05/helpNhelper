<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <strong>{{ now() }}</strong>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                      <h1 >Invoice</h1>
                        <h6 class="mb-3">Campaign</h6>
                        <div>S/N: {{ $campaign->sid ?? 'N/A' }}</div>
                        <div>Name: {{ $campaign->title }}</div>
                    </div>
                    <div class="col-sm-6 text-right">
                      <a href="javascript:void();" onclick="window.print()" class="btn btn-danger">Download PDF</a>
                    </div>
                </div>
                {{-- <div class="row mb-3">
                  <div class="col">
                    <h2>Transaction History</h2>
                  </div>
                </div> --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Transaction Date</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Transaction Category</th>
                                <th scope="col">Donor Name</th>
                                <th scope="col">Volunteer Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($campaign->invoices as $invoice)
                              <tr>
                                  <td>{{ $invoice->date ?? 'N/A' }}</td>
                                  <td>{{ $invoice->sid ?? 'N/A' }}</td>
                                  <td>{{ $invoice->transaction->transactionCategory->name ?? 'N/A' }}
                                  </td>
                                  <td>{{ $invoice->transaction->name ?? ($invoice->transaction->donorInfo->name ?? 'N/A') }}
                                  </td>
                                  <td>{{ $invoice->transaction->volunteerInfo->name ?? 'N/A' }}
                                  </td>
                                  <td>{{ $invoice->transaction->amount ?? 'N/A' }}</td>
                                  <td><span
                                          class="p-2 text badge badge-{{ $invoice->transaction->type == 'income' ? 'success' : 'danger' }}">{{ ucfirst($invoice->transaction->type) ?? 'N/A' }}</span>
                                  </td>
                              </tr>
                          @empty
                              <tr><td class="text-center" colspan="7">No data found</td></tr>
                          @endforelse
                      </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    {{-- <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="right">$8.497,00</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>$7.477,36</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div> --}}

                </div>

            </div>
        </div>
    </div>

</body>

</html>
