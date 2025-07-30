# Apsonex Swap Placeholder PHP Package

**Package:** `apsonex/swap-placeholder`
A simple and flexible PHP package to dynamically swap out placeholders in strings using resource data and resolver classes.

---

## 🚀 Features

- Define your own placeholder format (e.g. `__PLACEHOLDER__`)
- Attach resource models (like `Lead`, `Company`, etc.)
- Implement your own resolver logic
- Easily swap placeholders in strings for dynamic content generation

---

## 📦 Installation

```bash
composer require apsonex/swap-placeholder
```

---

## 🧠 Usage Example

'''php
\Apsonex\SwapPlaceholder\SwapPlaceholder::make()
    ->fresh()
    ->placeholderIdentity('__')
    ->addResource(Lead::class, Lead::first())
    ->sources([
        PlaceholderResolver\LeadPlaceholderResolver::class,
    ])
    ->targetString('Some string with __LEAD_NAME__, __LEAD_EMAIL__, __COMPANY_NAME__ & __COMPANY_EMAIL__')
    ->handle()
    ->output();
'''

---

## 🧩 Creating a Placeholder Resolver

Each resolver class should extend the `BasePlaceholderResolver` and implement the `PlaceholderResolverContract`.

'''php
<?php

namespace App\Support\PlaceholderResolver;

use App\Models\Lead;
use Apsonex\SwapPlaceholder\BasePlaceholderResolver as Base;
use Apsonex\SwapPlaceholder\PlaceholderResolverContract;

class LeadPlaceholderResolver extends Base implements PlaceholderResolverContract
{
    protected string $resolverId = Lead::class; // or any unique string ID

    // Optionally override methods to define how placeholders are resolved
}
'''

---

## ✅ Testing Example

'''php
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
'''

---

## 📄 License

MIT © [Apsonex Inc.](https://apsonex.com)
