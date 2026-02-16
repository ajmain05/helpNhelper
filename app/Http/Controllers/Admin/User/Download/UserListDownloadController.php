<?php

namespace App\Http\Controllers\Admin\User\Download;

use App\Enums\User\Status;
use App\Exports\XlsxExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel;

class UserListDownloadController extends Controller
{
    public function __invoke(Request $request)
    {
        $status = $request->query('status', Status::Approved->value);
        $type = $request->query('type');
        try {
            $users = User::with([
                'upazila.district.division.country',
            ])->when($type, function ($q) use ($type) {
                $q->where('type', $type);
            })->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })->latest()->get();

            ['data' => $data, 'heading' => $heading] =
                ['data' => $this->data($users), 'heading' => $this->heading()];

            $fileName = sprintf(
                '%s-Downloaded-at-%s.xlsx',
                $type ? ucfirst($type).'-User-List' : 'All-User-List',
                Carbon::now()->format('d-m-Y-h:i:s')
            );

            return (new XlsxExport(data: collect([$data]), headings: $heading))
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

    private function heading()
    {
        return [
            'Tracking Id',
            'Name',
            'Email',
            'Mobile',
            'Country',
            'Division',
            'District',
            'Upazila',
            'Present Address',
            'Permanent Address',
            'User Type',
            'Creation Time & Date',
        ];
    }

    private function data($users)
    {
        return $users->map(function ($user) {
            return [
                'tracking_id' => $user->sid ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'email' => $user->email ?? 'N/A',
                'mobile' => $user->mobile ?? 'N/A',
                'country' => $user->upazila->district->division->country->name ?? 'N/A',
                'Division' => $user->upazila->district->division->name ?? 'N/A',
                'District' => $user->upazila->district->name ?? 'N/A',
                'Upazila' => $user->upazila->name ?? 'N/A',
                'present_address' => $user->present_address ?? 'N/A',
                'permanent_address' => $user->permanent_address ?? 'N/A',
                'user_type' => $user->type ?? 'N/A',
                'created_at' => $user->created_at ? Carbon::parse($user->created_at)->format('d M, Y h:iA') : 'N/A',
            ];
        });
    }
}
