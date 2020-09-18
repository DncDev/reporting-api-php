<?php
declare(strict_types = 1);

namespace AdsSquared\Interfaces;

interface Report
{    
    public function startReport();
    public function fetchReport();
    public function status();
}
