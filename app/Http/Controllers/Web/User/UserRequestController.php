<?php

namespace App\Http\Controllers\Web\User;

use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Http\Traits\Sms;
use App\Mail\VerificationEmail;
use App\Models\User;
use App\Traits\HasFiles;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRequestController extends Controller
{
    use HasFiles, Sms;

    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', Rule::in([Type::Donor->value, Type::Volunteer->value, Type::Seeker->value, Type::Organization->value, Type::CorporateDonor->value])],
            'name' => ['required', 'string'],
            'email' => ['required_without:mobile', 'email', 'nullable', 'unique:users,email'],
            'mobile' => ['required_without:email', 'string', 'nullable', 'unique:users,mobile'],
            'auth_file' => ['required_if:type,seeker,volunteer,organization', 'file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'upazila' => ['required_if:type,seeker,volunteer,organization'],
            'permanent_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'present_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'office_address' => ['required_if:type,organization', 'string', 'nullable'],
            // Organization registration type fields
            'org_reg_type' => ['required_if:type,organization', 'nullable', 'string', Rule::in(['registered', 'unregistered'])],
            'reg_body' => ['required_if:org_reg_type,registered', 'nullable', 'string'],
            'reg_no' => ['required_if:org_reg_type,registered', 'nullable', 'string'],
            'cert_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf'],
            'years_of_op' => ['required_if:org_reg_type,unregistered', 'nullable', 'string'],
            'beneficiaries_count' => ['required_if:org_reg_type,unregistered', 'nullable', 'string'],
            'working_sectors' => ['required_if:org_reg_type,unregistered', 'nullable', 'string'],
            'fb_link' => ['nullable'],
            'photo' => ['required_if:type,seeker,volunteer,organization', 'file', 'mimes:jpeg,png,jpg', 'nullable'],
            'password' => ['required', 'min:8', 'max:32'],
            'password_confirmation' => ['required', 'same:password'],
            'terms' => ['required', 'boolean'],
        ], [
            'upazila.required_if' => 'Upazila is required.',

            'auth_file.required_if' => 'An NID/Birth Certificate/Passport is required in step 2.',
            'auth_file.file' => 'The NID/Birth Certificate/Passport file must be a valid file in step 2.',
            'auth_file.mimetypes' => 'The NID/Birth Certificate/Passport must be a PDF or image (jpeg/png) in step 2.',

            'photo.required_if' => 'A profile picture is required in step 4.',
            'photo.file' => 'Profile picture must be a valid file in step 4.',
            'photo.mimes' => 'Profile picture must be a JPEG or PNG file in step 4.',

            'terms.required' => 'You must accept the terms and conditions.',
        ]);
        try {
            DB::beginTransaction();
            $userRequest = new User();
            $userRequest->type = $request->type;
            $userRequest->name = $request->name;
            $userRequest->email = $request->email ?? null;
            $userRequest->mobile = $request->mobile ?? null;
            $userRequest->fb_link = $request->fb_link ?? null;
            $userRequest->upazila_id = $request->upazila ?? null;
            $userRequest->permanent_address = $request->permanent_address ?? null;
            $userRequest->present_address = $request->present_address ?? null;
            $userRequest->password = Hash::make($request->password) ?? null;

            if ($request->file('photo')) {
                $photoPath = $this->storeFile('user', $request->file('photo'), 'photo');
                $userRequest->photo = $photoPath ?? null;
            }
            if ($request->file('auth_file')) {
                $authPath = $this->storeFile('user', $request->file('auth_file'), 'auth');
                $userRequest->auth_file = $authPath ?? null;
            }
            if ($userRequest->type == Type::Organization->value) {
                $userRequest->office_address = $request->office_address ?? null;
                $userRequest->org_reg_type   = $request->org_reg_type ?? null;

                if ($request->org_reg_type === 'registered') {
                    $userRequest->reg_body = $request->reg_body ?? null;
                    $userRequest->reg_no   = $request->reg_no ?? null;
                    // Store certificate image
                    if ($request->file('cert_image')) {
                        $certPath = $this->storeFile('user', $request->file('cert_image'), 'cert');
                        $userRequest->cert_image = $certPath ?? null;
                    }
                } else {
                    $userRequest->years_of_op          = $request->years_of_op ?? null;
                    $userRequest->beneficiaries_count  = $request->beneficiaries_count ?? null;
                    $userRequest->working_sectors      = $request->working_sectors ?? null;
                }
            }

            $userRequest->save();

            // $hash = sha1($userRequest->getEmailForVerification());
            // $signedUrl = URL::signedRoute(
            //     'custom.verification.verify',
            //     ['id' => $userRequest->id, 'hash' => $hash],
            // );

            // Mail::to($userRequest->email)->send(new VerificationEmail($signedUrl));
            // event(new Registered($userRequest));

            DB::commit();

            return new JsonResponse(
                [
                    'message' => 'A verification email has been sent to your email address. Please verify it to complete the registration.',
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function forgetPassword(Request $request)
    {
        $validated = $request->validate([
            'contact-type' => ['required', Rule::in(['mobile', 'email'])],
            'email' => ['nullable', 'required_if:contact-type,email', 'email', 'exists:users,email'],
            'mobile' => ['nullable', 'required_if:contact-type,mobile', 'string', 'exists:users,mobile'],
        ]);

        try {
            if ($validated['contact-type'] == 'mobile') {

                $user = User::where('mobile', $validated['mobile'])->first();
                $token = Password::broker()->createToken($user);
                $url = url(route('password.reset', $token, false));

                $message = <<<EOD
                You are receiving this email because we received a password reset request for your account. This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.

                Link: {$url}
                
                Warm regards,
                The HelpNHelpers Support Team
                EOD;
                $response = json_decode($this->smsSend($validated['mobile'], $message));

                if ($response->response_code != 202) {
                    return response()->json(
                        [
                            'message' => __('Unable to send sms.'),
                        ],
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }

                return response()->json(
                    [
                        'message' => __('We have sent your password reset link to your mobile.'),
                    ],
                    Response::HTTP_ACCEPTED
                );
            } else {

                $status = Password::sendResetLink(
                    $request->only('email')
                );

                return $status === Password::RESET_LINK_SENT ? response()->json(
                    [
                        'message' => __($status),
                    ],
                    Response::HTTP_OK
                ) :
                 response()->json(
                     [
                         'message' => __($status),
                     ],
                     Response::HTTP_INTERNAL_SERVER_ERROR
                 );
            }
        } catch (\Exception $th) {
            return response()->json(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET ? new JsonResponse(
                [
                    'status' => __($status),
                ],
                Response::HTTP_OK
            ) :
                new JsonResponse(
                    [
                        'status' => __($status),
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        } catch (\Exception $th) {
            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function showResetPassword(string $token)
    {
        return view('v1.web.pages.home', [
            'token' => $token,
        ]);
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        try {
            $user = User::findOrFail($id);
            if ((! URL::hasValidSignature($request)) || (! hash_equals($hash, sha1($user->getEmailForVerification())))) {
                return redirect('/')->with('error', 'Invalid verification link');
            }
            if ($user->hasVerifiedEmail()) {
                return redirect('/')->with('verifiedMessage', 'Email already verified');
            }

            $user->markEmailAsVerified();

            return redirect('/')->with('verifiedMessage', 'Email has been verified. You may login.');

        } catch (\Exception $th) {

            return redirect('/')->with('error', 'Error! '.$th->getMessage());
        }
    }
}
