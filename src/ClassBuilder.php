<?php

namespace Flux;

use Illuminate\Support\Arr;
use Stringable;

class ClassBuilder implements Stringable
{
    protected $pending = [];

    protected $prefix = "tw-";

    public function add($classes)
    {
        $classes = Arr::toCssClasses($classes);

        if (!empty($this->prefix)) {
            $classes = $this->addPrefix($classes, $this->prefix);
        }

        $this->pending[] = $classes;

        return $this;
    }

    public function addPrefix($classes, $prefix = '')
    {
        $classes = array_filter(explode(' ', $classes));

        $classes = array_map(function ($class) use ($prefix) {
            $parts = explode(':', $class);
            $parts[count($parts) - 1] = $prefix . $parts[count($parts) - 1];
            return implode(':', $parts);
        }, $classes);

        return implode(' ', $classes);
    }
    
    public function __toString()
    {
        return (string) collect($this->pending)->join(' ');
    }
}
