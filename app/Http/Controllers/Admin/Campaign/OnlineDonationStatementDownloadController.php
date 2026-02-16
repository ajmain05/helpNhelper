<?php

namespace App\Http\Controllers\Admin\Campaign;

use App\Exports\XlsxExport;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;

class OnlineDonationStatementDownloadController extends Controller
{
    public function __invoke(Request $request, int $campaignId)
    {
        try {
            $donations = Donation::with([
                'user',
                'campaign',
            ])->whereCampaignId($campaignId)->latest()->get();

            ['data' => $data, 'heading' => $heading] =
                ['data' => $this->data($donations), 'heading' => $this->heading($donations[0]?->campaign ?? [])];

            $fileName = sprintf(
                '%s-%s-Downloaded-at-%s.xlsx',
                $donations[0]->campaign->sid ?? 'N-A',
                'Online-Donation-Statement',
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
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['wrapText' => false],
            ],
            2 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    private function heading($campaign)
    {
        $campaignName = ['Campaign Title: ', $campaign->title ?? 'N/A'];
        $heading = [
            'Transaction Id',
            'Donation type',
            'Donor Name',
            'Donor Mobile',
            'Donor Email',
            'Amount',
            'Donation Date & Time',
        ];

        return array_merge([$campaignName], [$heading]);
    }

    private function data($donations)
    {
        return $donations->map(function ($donation) {
            return [
                'transaction_id' => $donation->tran_id ?? 'N/A',
                'type' => $donation->user_id ? 'Account' : 'Anonymous',
                'name' => $donation->user->name ?? 'N/A',
                'mobile' => $donation->phone ?? $donation->user->mobile ?? 'N/A',
                'email' => $donation->user->email ?? 'N/A',
                'amount' => $donation->amount ?? 'N/A',
                'created_at' => $donation->created_at ? Carbon::parse($donation->created_at)->format('d M, Y h:iA') : 'N/A',
            ];
        });
    }
}
