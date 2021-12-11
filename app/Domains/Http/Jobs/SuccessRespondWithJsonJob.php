<?php

namespace App\Domains\Http\Jobs;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Lucid\Units\Job;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SuccessRespondWithJsonJob extends Job
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected mixed   $data = null,
        protected int     $code = ResponseAlias::HTTP_OK,
        protected ?string $message = null,
        protected ?array  $additionalData = [])
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
            'data' => $this->data,
            'status' => "ok",
            'code' => $this->code,
            ...$this->additionalData
        ]);
    }
}
