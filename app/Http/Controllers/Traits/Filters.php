<?php

namespace App\Http\Controllers\Traits;

use Inertia\Inertia;

trait Filters
{
    public function filters($request, $query)
    {
        /** Ordenar por status */
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        /** Ordenação por data */
        $sortField = $request->get('orderBy', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        return $query->orderBy($sortField, $sortDirection)->paginate(5);
    }
}
