<?php

namespace DC\Service\Security\Token\Interfaces;

interface AdapterInterface
{
    public function encode($data, string $algorithm = null): string;
    public function decode($token, string $algorithm = null);
    public function validate($token, string $algorithm = null);
}