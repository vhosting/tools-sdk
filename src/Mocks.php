<?php

namespace VHosting\ToolsSdk;

use Saloon\Http\Faking\MockResponse;

class Mocks
{
    public static function noContent(): MockResponse
    {
        return MockResponse::make(status: 204);
    }
    
    public static function emptyArray(): MockResponse
    {
        return MockResponse::make([
            'data' => [],
            'links' => [
                'next' => null,
            ]
        ]);
    }
    
    public static function workflow(int $status = 200): MockResponse
    {
        return MockResponse::make([
            'id' => 0,
            'type' => 'my-workflow',
            'description' => 'This is a mocked workflow.',
            'status' => 'completed',
            'payload' => [],
            'created_at' => '2026-03-09T13:46:51.000000Z',
            'updated_at' => '2026-03-09T13:49:19.000000Z',
            'tasks_count' => 1,
            'completed_tasks_count' => 1,
            'tasks' => [
                [
                    'id' => 0,
                    'workflow_id' => 0,
                    'description' => 'This is a mocked task.',
                    'order' => 1,
                    'status' => 'completed',
                    'error' => null,
                    'started_at' => '2026-03-09T13:47:37.000000Z',
                    'stopped_at' => '2026-03-09T13:47:37.000000Z',
                    'created_at' => '2026-03-09T13:46:51.000000Z',
                    'updated_at' => '2026-03-09T13:47:37.000000Z',
                ],
            ],
        ], $status);
    }
}