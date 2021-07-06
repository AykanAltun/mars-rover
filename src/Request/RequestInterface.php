<?php

namespace App\Request;

interface RequestInterface
{
    /**
     * @param array|null $data
     */
    public function fill(?array $data = null): void;
}