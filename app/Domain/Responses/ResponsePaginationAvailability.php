<?php

declare(strict_types=1);

namespace App\Domain\Responses;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Responsable;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;

final class ResponsePaginationAvailability extends DataTransferObject implements Responsable
{
    public LengthAwarePaginator $paginator;

    public DataTransferObjectCollection $collection;

    public int $status = 200;

    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->collection->toArray(),
                'meta' => [
                    'currentPage' => $this->paginator->currentPage(),
                    'lastPage' => $this->paginator->lastPage(),
                    'path' => $this->paginator->path(),
                    'perPage' => $this->paginator->perPage(),
                    'total' => $this->paginator->total(),
                ],
            ],
            $this->status
        );
    }
}
