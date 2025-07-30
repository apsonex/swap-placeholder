<?php

namespace Apsonex\SwapPlaceholder;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;

abstract class BasePlaceholderResolver implements PlaceholderResolverContract
{
    protected string $resolverId;

    protected array $payload;

    public function getResolverId(): string
    {
        return $this->resolverId;
    }

    public function targetString(): Stringable
    {
        return $this->payload['targetString'];
    }

    public function placeholderIdentity(): string
    {
        return $this->payload['placeholderIdentity'] ?? '__';
    }

    public function handle(array $payload, Closure $next)
    {
        $this->payload = $payload;

        $placeholders = $this->resolvePlaceholders();

        $this->payload['targetString'] = $this->targetString()->swap($placeholders);

        return $next($this->payload);
    }

    public function resolvePlaceholders(): array
    {
        $model = Arr::get($this->payload, 'resources.' . $this->getResolverId());

        if (is_array($model)) return $model;

        if (!$model) {
            return [];
        }

        $prefix = str($this->getResolverId())->afterLast('\\')->snake()->upper()->toString();

        return collect($model->toArray())->mapWithKeys(function ($v, $k) use ($prefix) {
            $k = $this->placeholderIdentity() . implode('_', [$prefix, str($k)->snake()->upper()->toString()]) . $this->placeholderIdentity();

            if (is_array($v)) return [$k => $k];

            return [$k => $v];
        })->toArray();
    }
}
