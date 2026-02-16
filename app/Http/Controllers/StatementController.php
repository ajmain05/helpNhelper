<?php

namespace App\Http\Controllers;

use App\Exports\XlsxExport;
use App\Models\Campaign\Campaign;
use App\Models\Invoice\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\DataTables;

class StatementController extends Controller
{
    public function index()
    {
        $campaignsDropdown = Campaign::select(['id', 'sid', 'title'])->get();

        return view('v1.admin.pages.statement.index', compact('campaignsDropdown'));
    }

    public function getTstatementDatatableAjax(Request $request)
    {
        $query = Invoice::with([
            'transaction',
            'transaction.transactionCategory',
            'transaction.donorInfo',
            'transaction.volunteerInfo',
            'transaction.campaignInfo',
            'statusInfo',
        ])
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereHas('statusInfo', function ($query) use ($request) {
                        $query->where('name', 'like', '%'.$request->search['value'].'%');
                    })
                        ->orWhere('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhereHas('transaction', function ($query) use ($request) {
                            $query->whereHas('campaignInfo', function ($query) use ($request) {
                                $query->where('title', 'like', '%'.$request->search['value'].'%');
                            })
                                ->orWhere('date', 'like', '%'.$request->search['value'].'%')
                                ->orWhereHas('donorInfo', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhereHas('volunteerInfo', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhere('amount', 'like', '%'.$request->search['value'].'%')
                                ->orWhere('type', 'like', '%'.$request->search['value'].'%')
                                ->orWhereHas('transactionCategory', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                        });
                });
            })->when($request->type, function ($query) use ($request) {
                $query->whereHas('transaction', function ($query) use ($request) {
                    $query->where('type', $request->type);
                });
            })->when($request->campaign_id, function ($query) use ($request) {
                $query->whereHas('transaction', function ($query) use ($request) {
                    $query->where('campaign_id', $request->campaign_id);
                });
            })->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            });

        $totalIncome = (clone $query)->whereHas('transaction', function ($q) {
            $q->where('type', 'income');
        })->get()->sum(function ($invoice) {
            return $invoice->transaction ? $invoice->transaction->amount : 0;
        });

        $totalExpense = (clone $query)->whereHas('transaction', function ($q) {
            $q->where('type', 'expense');
        })->get()->sum(function ($invoice) {
            return $invoice->transaction ? $invoice->transaction->amount : 0;
        });

        $invoices = $query->latest();

        return DataTables::of($invoices)
            ->editColumn('date', function ($invoice) {
                return $invoice?->date ?? 'N/A';
            })
            ->editColumn('campaign', function ($invoice) {
                return $invoice?->transaction?->campaignInfo?->title ?? 'N/A';
            })
            ->editColumn('sid', function ($invoice) {
                return $invoice?->sid ?? 'N/A';
            })
            ->editColumn('transaction_category', function ($invoice) {
                return $invoice?->transaction?->transactionCategory?->name ?? 'N/A';
            })
            ->editColumn('donor_name', function ($invoice) {
                return $invoice?->transaction?->name ?? ($invoice?->transaction?->donorInfo?->name ?? 'N/A');
            })->editColumn('donor_mobile', function ($invoice) {
                return $invoice?->transaction?->mobile ?? ($invoice?->transaction?->donorInfo?->mobile ?? 'N/A');
            })
            ->editColumn('volunteer_name', function ($invoice) {
                return $invoice?->transaction?->volunteerInfo?->name ?? 'N/A';
            })
            ->editColumn('volunteer_mobile', function ($invoice) {
                return $invoice?->transaction?->volunteerInfo?->mobile ?? 'N/A';
            })
            ->editColumn('amount', function ($invoice) {
                return $invoice?->transaction?->amount ?? 'N/A';
            })
            ->editColumn('type', function ($invoice) {
                return ucfirst($invoice?->transaction?->type) ?? 'N/A';
            })
            ->editColumn('created_at', function ($invoice) {
                return $invoice?->created_at ?? 'N/A';
            })
            ->addColumn('action', function ($invoice) {
                $markup = '';
                $markup .= '<a href="'.route('admin.invoice.show', [$invoice->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.invoice.edit', [$invoice->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteInvoice('.$invoice->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'name', 'campaign', 'created_at'])
            ->setFilteredRecords($invoices->count())
            ->with([
                'total_income' => number_format($totalIncome),
                'total_expense' => number_format($totalExpense),
            ])
            ->make(true);
    }

    public function download(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $campaignId = $request->query('campaign_id');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        try {
            $query = Invoice::with([
                'transaction',
                'transaction.transactionCategory',
                'transaction.donorInfo',
                'transaction.volunteerInfo',
                'transaction.campaignInfo',
                'statusInfo',
            ])->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('statusInfo', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    })
                        ->orWhere('sid', 'like', '%'.$search.'%')
                        ->orWhereHas('transaction', function ($query) use ($search) {
                            $query->whereHas('campaignInfo', function ($query) use ($search) {
                                $query->where('title', 'like', '%'.$search.'%');
                            })
                                ->orWhere('date', 'like', '%'.$search.'%')
                                ->orWhereHas('donorInfo', function ($query) use ($search) {
                                    $query->where('name', 'like', '%'.$search.'%');
                                })
                                ->orWhereHas('volunteerInfo', function ($query) use ($search) {
                                    $query->where('name', 'like', '%'.$search.'%');
                                })
                                ->orWhere('amount', 'like', '%'.$search.'%')
                                ->orWhere('type', 'like', '%'.$search.'%')
                                ->orWhereHas('transactionCategory', function ($query) use ($search) {
                                    $query->where('name', 'like', '%'.$search.'%');
                                })
                                ->orWhere('created_at', 'like', '%'.$search.'%');
                        });
                });
            })->when($campaignId, function ($query) use ($campaignId) {
                $query->whereHas('transaction', function ($query) use ($campaignId) {
                    $query->where('campaign_id', $campaignId);
                });
            })->when($type, function ($query) use ($type) {
                $query->whereHas('transaction', function ($query) use ($type) {
                    $query->where('type', $type);
                });
            })->when($fromDate, function ($query) use ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            })->when($toDate, function ($query) use ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            });
            $invoices = $query->latest()->get();

            $totalIncome = (clone $query)->whereHas('transaction', function ($q) {
                $q->where('type', 'income');
            })->get()->sum(function ($invoice) {
                return $invoice->transaction ? $invoice->transaction->amount : 0;
            });

            $totalExpense = (clone $query)->whereHas('transaction', function ($q) {
                $q->where('type', 'expense');
            })->get()->sum(function ($invoice) {
                return $invoice->transaction ? $invoice->transaction->amount : 0;
            });

            ['data' => $data, 'heading' => $heading] =
                ['data' => $this->data($invoices), 'heading' => $this->heading(
                    $type ?? null,
                    $from ?? null,
                    $to ?? null,
                    $totalIncome,
                    $totalExpense
                )];

            $fileName = sprintf(
                '%s-from-%s-to-%s-Downloaded-at-%s.xlsx',
                $type ? ucfirst($type).'-Statement' : 'Statement',
                $fromDate ?? 'date',
                $toDate ?? 'date',
                Carbon::now()->format('d-m-Y-h:i:s')
            );

            return (new XlsxExport(data: collect([$data]), headings: $heading, style: $this->style()))
                ->download(
                    fileName: $fileName,
                    writerType: Excel::XLSX,
                    headers: [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'Content-Disposition' => 'attachment; filename='.$fileName,
                    ]
                );
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

    private function style()
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true, 'size' => 13]],
            3 => ['font' => ['bold' => true, 'size' => 13]],
            4 => ['font' => ['bold' => true, 'size' => 14]],
        ];

    }

    private function heading($type, $from, $to, $totalIncome, $totalExpense)
    {
        $type = $type ? [ucfirst($type).'-Statements'] : ['Income and Expense Statements'];
        $formAndTo = [
            $from ? "From : {$from}" : 'From : No date',
            $to ? "To : {$to}" : 'To : No date',
        ];
        $totalIncomeAndExpense = [
            'Total Income : '.number_format($totalIncome),
            'Total Expense : '.number_format($totalExpense),
        ];
        $mainHeading = [
            'Invoice Number',
            'Campaign',
            'Transaction Category',
            'Donor Name',
            'Donor Mobile',
            'Volunteer Name',
            'Volunteer Mobile',
            'Amount',
            'Type',
            'Transaction Date And Time',
        ];

        return array_merge([
            $type,
            $formAndTo,
            $totalIncomeAndExpense,
        ], [$mainHeading]);
    }

    private function data($invoices)
    {
        return $invoices->map(function ($invoice) {
            return [
                'invoice_number' => $invoice?->sid ?? 'N/A',
                'campaign' => $invoice?->transaction?->campaignInfo?->title ?? 'N/A',
                'transaction_category' => $invoice?->transaction?->transactionCategory?->name ?? 'N/A',
                'donor_name' => $invoice?->transaction?->name ?? $invoice?->transaction?->donorInfo?->name ?? 'N/A',
                'donor_mobile' => $invoice?->transaction?->mobile ?? $invoice?->transaction?->donorInfo?->mobile ?? 'N/A',
                'volunteer_name' => $invoice?->transaction?->volunteerInfo?->name ?? 'N/A',
                'volunteer_mobile' => $invoice?->transaction?->volunteerInfo?->mobile ?? 'N/A',
                'amount' => $invoice?->transaction?->amount ?? 'N/A',
                'type' => ucfirst($invoice?->transaction?->type ?? 'N/A'),
                'transaction_date' => $invoice?->created_at ?? 'N/A',
            ];
        });
    }
}
