<?php

namespace Apsonex\SwapPlaceholder;

use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pipeline\Pipeline as LaravelPipeline;
use Apsonex\SwapPlaceholder\Pipeline as CustomPipeline;

class SwapPlaceholder
{
    protected Stringable $targetString;

    protected string $output = '';

    protected string $placeholderIdentity = '__';

    protected array $sources = [];

    protected array $resources = [];

    protected $pipeline;

    public static function make(): static
    {
        return new static;
    }

    public function addResource(string $resourceId, $resourceInstance): static
    {
        $this->resources[$resourceId] = $resourceInstance;
        return $this;
    }

    public function resources(array $resources): static
    {
        $this->resources = $resources;
        return $this;
    }

    public function placeholderIdentity(string $placeholderIdentity): static
    {
        $this->placeholderIdentity = $placeholderIdentity;
        return $this;
    }

    public function fresh(): static
    {
        $this->output = '';
        $this->sources = [];
        $this->resources = [];
        return $this;
    }

    public function sources(array|string $sources): static
    {
        $this->sources = [
            ...$this->sources,
            ...Arr::wrap($sources),
        ];

        return $this;
    }

    public function targetString($targetString): static
    {
        $this->targetString = str($targetString);
        return $this;
    }

    public function handle(): static
    {
        $output = $this->pipe(
            send: [
                'targetString' => $this->targetString,
                'resources' => $this->resources,
                'placeholderIdentity' => $this->placeholderIdentity,
            ],
            pipes: $this->sources,
            via: 'handle'
        )->thenReturn();

        $this->output = $output['targetString']->toString();

        return $this;
    }

    public function output(): ?string
    {
        return $this->output;
    }

    protected function pipe($send, $pipes, $via = 'handle')
    {
        if (class_exists(\Illuminate\Foundation\Application::class)) {
            return resolve(LaravelPipeline::class)->send($send)->via($via)->through($pipes);
        }

        return ($this->pipeline ??= (new CustomPipeline))->send($send)->via($via)->through($pipes);
    }
}
