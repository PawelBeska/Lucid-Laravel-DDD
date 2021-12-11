<?php

namespace App\Features;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Lucid\Events\JobStarted;
use Lucid\Events\OperationStarted;
use Lucid\Testing\MockMe;
use Lucid\Bus\UnitDispatcher;
use Lucid\Units\Job;
use Lucid\Units\Operation;
use Throwable;

abstract class Feature
{
    use MockMe;
    use UnitDispatcher;


    public function reportError(Throwable $e)
    {
        Log::error(
            $e->getMessage()
            . PHP_EOL . 'IN LINE: ' . $e->getLine()
            . PHP_EOL . 'IN FILE: ' . $e->getFile()
        );
    }

    /**
     * @param $unit
     * @param $arguments
     * @param $extra
     * @return mixed
     */
    public function run($unit, $arguments = [], $extra = []): mixed
    {
        if ($arguments instanceof Request) {
            $result = $this->dispatch($this->marshal($unit, $arguments, $extra));
        } else {
            if (!is_object($unit)) {
                $unit = $this->marshal($unit, new Collection(), $arguments);
            }

            if ($unit instanceof Operation) {
                event(new OperationStarted(get_class($unit), $arguments));
            }

            if ($unit instanceof Job) {
                event(new JobStarted(get_class($unit), $arguments));
            }

            $result = $this->dispatch($unit, $arguments);
        }

        return $result;
    }
}
