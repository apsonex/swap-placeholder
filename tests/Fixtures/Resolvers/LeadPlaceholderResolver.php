<?php

namespace Tests\Fixtures\Resolvers;

use Tests\Fixtures\Models\Lead;
use Apsonex\SwapPlaceholder\BasePlaceholderResolver;
use Apsonex\SwapPlaceholder\PlaceholderResolverContract;

class LeadPlaceholderResolver extends BasePlaceholderResolver implements PlaceholderResolverContract
{
    protected string $resolverId = Lead::class;
}
