<?php
namespace Tests\Fixtures\Models;

class Lead
{
    public function toArray(): array
    {
        return [
            'name' => 'John Doe',
            'email' => 'email@example.com',
        ];
    }
}
