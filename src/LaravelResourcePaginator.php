<?php

namespace VHosting\ToolsSdk;

use Override;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\PagedPaginator;

class LaravelResourcePaginator extends PagedPaginator
{
    /**
     * @inheritDoc
     */
    #[Override]
    protected function isLastPage(Response $response): bool
    {
        return $response->json('links.next') === null;
    }
    
    /**
     * @inheritDoc
     */
    #[Override]
    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->dto() ?? $response->json('data');
    }
}