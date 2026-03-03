<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About\MeetOurTeam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $type = $request->query('type'); // 'team' or 'shariah'

            $query = MeetOurTeam::orderBy('sequence');

            if ($type && in_array($type, ['team', 'shariah'])) {
                $query->where('type', $type);
            }

            $members = $query->get()->map(function ($member) {
                return [
                    'id'          => $member->id,
                    'name'        => $member->name,
                    'designation' => $member->designation,
                    'institution' => $member->institution,
                    'message'     => $member->message,
                    'photo'       => $member->image ? asset($member->image) : null,
                    'type'        => $member->type,
                    'sequence'    => $member->sequence,
                ];
            });

            return response()->json(['data' => $members], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
