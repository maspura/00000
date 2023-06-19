<?php

namespace Fluent\DataTables\Contracts;

interface Formatter
{
    /**
     * @param  string  $value
     * @param  mixed  $row
     * @return string
     */
    public function format($value, $row);
}
