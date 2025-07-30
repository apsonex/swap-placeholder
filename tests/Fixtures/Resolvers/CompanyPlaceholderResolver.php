<?php

namespace Tests\Fixtures\Resolvers;

use Tests\Fixtures\Models\Company;
use Apsonex\SwapPlaceholder\BasePlaceholderResolver;
use Apsonex\SwapPlaceholder\PlaceholderResolverContract;

class CompanyPlaceholderResolver extends BasePlaceholderResolver implements PlaceholderResolverContract
{
    protected string $resolverId = Company::class;
}
