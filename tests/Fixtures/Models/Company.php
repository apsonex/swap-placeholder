<?php
namespace Tests\Fixtures\Models;

class Company
{
    public function toArray(): array
    {
        return [
            'name' => 'Abc Inc.',
            'email' => 'info@company.com',
        ];
    }
}
