<?php
namespace App\Util;

use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Component\HttpFoundation\Request;

interface RequestDTOInterface
{
    public function __construct(Request $request);
}
