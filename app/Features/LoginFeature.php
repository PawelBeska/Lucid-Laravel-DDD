<?php

namespace App\Features;

use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Http\Jobs\FailedRespondWithJsonJob;
use App\Domains\Http\Jobs\SuccessRespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginFeature extends Feature
{
    public function handle(LoginRequest $request)
    {

        $data = $request->validated();
        try {

            if (!Auth::attempt($data))
                return $this->run(
                    new FailedRespondWithJsonJob(
                        ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                        __('auth.failed')
                    )
                );

            if (!Auth::user()->email_verified_at)
                return $this->run(
                    new FailedRespondWithJsonJob(
                        ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                        __('auth.needs_email_confirmation')
                    )
                );

            return $this->run(new SuccessRespondWithJsonJob(
                ['user' => Auth::user()],
                ResponseAlias::HTTP_OK,
                __('auth.success'),
                [
                    'auth_token' => Auth::user()->createToken('auth')->plainTextToken
                ]
            ));

        } catch (\Exception $e) {
            return $this->run(
                new FailedRespondWithJsonJob(
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    __('message.something went wrong')
                )
            );
        }
    }
}
