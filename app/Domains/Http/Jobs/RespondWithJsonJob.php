<?php

namespace App\Domains\Http\Jobs;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Lucid\Units\Job;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RespondWithJsonJob extends Job
{
    protected int $code;
    protected mixed $data;

    protected ?string $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(mixed $data = null, int $code = ResponseAlias::HTTP_OK, $message = null)
    {
        $this->data = $data;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return JsonResponse
     */
    public function handle(ResponseFactory $factory)
    {

        return $factory->json([
            'message' => $this->message,
            'data' => $this->data,
            'code' => $this->code,
        ]);
    }
}
