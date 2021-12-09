<?php

namespace App\Features;

use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Link\Jobs\StoreLinkJob;
use Illuminate\Http\Request;
use Lucid\Units\Feature;
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
            return $this->run(new RespondWithJsonJob($link));
        } catch (\Exception $e) {
            return $this->run(new RespondWithJsonJob(null, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, __('messages.something went wrong')));
        }

    }
}
