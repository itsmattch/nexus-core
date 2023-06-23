<?php

namespace Itsmattch\Nexus\Common;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Stream\Stream;

class Blueprint
{
    use ArrayHelpers;

    /** todo if defined then validate input streams */
    protected string|array $streams = [];

    /** todo if defined then change array roots */
    protected string|array $roots = [];

    /** todo passed streams */
    private array $streamInstances = [];

    private array $workingArrays = [];

    /** todo pass streams */
    public function __construct(Stream ...$streams)
    {
        $this->setValidStreams($streams);
        $this->setWorkingArrays();
    }

    private function setValidStreams(array $streamInstances)
    {
        if (empty($this->streams)) {
            $this->streamInstances = $streamInstances;
        } else {
            // we have an array of FQCNs and an array of stream instances
            // there must be exactly one stream instance for every FQCN
            $streamInstancesClasses = array_map(function ($streamInstance) {
                return get_class($streamInstance);
            }, $streamInstances);

            $uniqueStreams = array_unique($this->streams);
            $uniqueStreamInstancesClasses = array_unique($streamInstancesClasses);

            // All declared streams must be unique
            if (count($this->streams) !== count($uniqueStreams)) {
                throw new \Exception();
            }

            // All passed streams must be unique
            if (count($uniqueStreamInstancesClasses) !== count($streamInstancesClasses)) {
                throw new \Exception();
            }

            // Passed and declared streams must match
            if (count(array_diff($uniqueStreams, $uniqueStreamInstancesClasses)) > 0) {
                throw new \Exception();
            }

            foreach ($this->streams as $key => $declaredStream) {
                foreach ($streamInstances as $streamInstance) {
                    if (is_a($streamInstance, $declaredStream)) {
                        $this->streamInstances[$key] = $streamInstance;
                        break;
                    }
                }
            }
        }
    }

    private function setWorkingArrays(): void
    {
    }
}