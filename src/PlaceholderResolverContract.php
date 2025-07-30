<?php

namespace Apsonex\SwapPlaceholder;

use Closure;
use Illuminate\Support\Stringable;

interface PlaceholderResolverContract
{
    public function getResolverId(): string;

    public function resolvePlaceholders(): array;

    public function placeholderIdentity(): string;

    public function targetString(): Stringable;

    public function handle(array $payload, Closure $next);
}
