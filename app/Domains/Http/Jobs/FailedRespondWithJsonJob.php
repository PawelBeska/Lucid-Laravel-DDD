<?php

namespace App\Domains\Http\Jobs;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Lucid\Units\Job;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FailedRespondWithJsonJob extends Job
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected int     $code = ResponseAlias::HTTP_OK,
        protected ?string $message = null,
    )
    {}

    /**
     * Execute the job.
     *
     * @param ResponseFactory $factory
     * @return JsonResponse
     */
    public function handle(ResponseFactory $factory): JsonResponse
    {
        return $factory->json([
            'message' => $this->message,
            'status' => "error",
            'code' => $this->code,
        ]);
    }
}
