<?php

namespace App\Domains\Link\Jobs;

use App\Data\Models\Link;
use Lucid\Units\Job;

class StoreLinkJob extends Job
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url, string $title, string $description)
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $attributes = [
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
        ];

        return tap(new Link($attributes))->save();
    }
}
