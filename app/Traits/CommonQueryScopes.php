<?php

namespace App\Traits;

trait CommonQueryScopes
{
    public function scopeFilterByStatus($query, $status = null)
    {
        if ($status) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeSearchByTitle($query, $title = null)
    {
        if ($title) {
            return $query->where('title', 'like', "%{$title}%");
        }

        return $query;
    }
}
