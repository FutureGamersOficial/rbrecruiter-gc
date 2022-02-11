<?php
namespace App\Services;

class DemoService {

    public function isDemoEnabled(): bool {

        return config('demo.is_enabled');

    }
}
