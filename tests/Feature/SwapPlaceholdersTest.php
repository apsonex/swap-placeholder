<?php

use Tests\Fixtures\Models\Lead;
use Tests\Fixtures\Models\Company;

describe('swap_placeholders', function () {
    it('swap_placeholder_works', function () {
        $output = Apsonex\SwapPlaceholder\SwapPlaceholder::make()
            ->fresh()
            ->placeholderIdentity('__')
            ->addResource(Lead::class, new Lead)
            ->addResource(Company::class, new Company)
            ->sources([
                \Tests\Fixtures\Resolvers\LeadPlaceholderResolver::class,
                \Tests\Fixtures\Resolvers\CompanyPlaceholderResolver::class,
            ])
            ->targetString('Some string with __LEAD_NAME__, __LEAD_EMAIL__, __COMPANY_NAME__ & __COMPANY_EMAIL__')
            ->handle()
            ->output();

        expect(
            $output === 'Some string with John Doe, email@example.com, Abc Inc. & info@company.com'
        )->toBeTrue();
    });
});
