<?php

namespace Henrik\Contracts;

class DetectedClassesEvent implements EventInterface
{
    /** @var array<string> */
    private array $detectedClasses = [];

    /**
     * @return array<string>
     */
    public function getDetectedClasses(): array
    {
        return $this->detectedClasses;
    }

    /**
     * @param array<string> $detectedClasses
     *
     * @return void
     */
    public function setDetectedClasses(array $detectedClasses): void
    {
        $this->detectedClasses = $detectedClasses;
    }
}