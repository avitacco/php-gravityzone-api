<?php
declare(strict_types=1);

namespace IndianaUniversity\GravityZone\Provider;


interface ProviderInterface
{
    public function get(string $path, array $params = []);
    public function put();
}
