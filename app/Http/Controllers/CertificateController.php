<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateController extends Controller
{
    public function verify(string $certNo)
    {
        $cert = Certificate::with(['application.applicant', 'verification'])
            ->where('cert_no', $certNo)
            ->first();

        if (!$cert) {
            return view('verify.not-found', compact('certNo'));
        }

        if ($cert->verification) {
            $cert->verification->forceFill([
                'last_verified_at' => now(),
                'verify_count' => $cert->verification->verify_count + 1,
            ])->save();
        }

        return view('verify.certificate', compact('cert'));
    }
}
