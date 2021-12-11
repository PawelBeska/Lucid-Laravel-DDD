<?php

namespace App\Features;

use App\Domains\Http\Jobs\FailedRespondWithJsonJob;
use App\Domains\Http\Jobs\SuccessRespondWithJsonJob;
use App\Domains\Link\Jobs\StoreLinkJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StoreLinkFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $link = $this->run(StoreLinkJob::class, [
                'url' => $request->input('url'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);
            return $this->run(new SuccessRespondWithJsonJob($link));
        } catch (\Exception $e) {
            return $this->run(
                new FailedRespondWithJsonJob(
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    __('messages.something went wrong')
                ));
        }

    }
}
