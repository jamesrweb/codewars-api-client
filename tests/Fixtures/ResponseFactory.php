<?php

declare(strict_types=1);

namespace Tests\Fixtures;

interface ResponseFactoryInterface
{
    /**
     * @return array<mixed>
     */
    public function empty(): array;

    /**
     * @return array<string, mixed>
     */
    public function partial_challenge(): array;

    /**
     * @return array<string, mixed>
     */
    public function valid_challenge(): array;

    /**
     * @return array<array<string, mixed>>
     */
    public function partial_authored_challenge(): array;

    /**
     * @return array<array<string, mixed>>
     */
    public function valid_authored_challenge(): array;

    /**
     * @return array<string, mixed>
     */
    public function partial_user(): array;

    /**
     * @return array<string, mixed>
     */
    public function valid_user(): array;

    /**
     * @return array<array<string, mixed>>
     */
    public function partial_completed_challenge(): array;

    /**
     * @return array<array<string, mixed>>
     */
    public function valid_completed_challenge(): array;
}

class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function empty(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function partial_challenge(): array
    {
        return [
            'id' => base64_encode('id'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function valid_challenge(): array
    {
        return [
            'id' => base64_encode('id'),
            'name' => 'challenge',
            'slug' => 'some-thing',
            'category' => 'test',
            'publishedAt' => date(DATE_ISO8601),
            'approvedAt' => date(DATE_ISO8601),
            'languages' => ['one', 'two'],
            'url' => 'https://example.com',
            'rank' => [
                'id' => 1,
                'name' => 'rank',
                'color' => 'color',
            ],
            'createdBy' => [
                'username' => $_ENV['CODEWARS_VALID_USERNAME'],
                'url' => 'https://example.com',
            ],
            'approvedBy' => [
                'username' => $_ENV['CODEWARS_VALID_USERNAME'],
                'url' => 'https://example.com',
            ],
            'description' => 'description',
            'totalAttempts' => 1,
            'totalCompleted' => 1,
            'totalStars' => 2,
            'tags' => ['one', 'two'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function partial_authored_challenge(): array
    {
        return [$this->partial_challenge()];
    }

    /**
     * {@inheritdoc}
     */
    public function valid_authored_challenge(): array
    {
        return [
            [
                'id' => base64_encode('id'),
                'name' => 'name',
                'description' => 'description',
                'rank' => 1,
                'rankName' => 'rank',
                'tags' => ['one', 'two'],
                'languages' => ['one', 'two'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function partial_completed_challenge(): array
    {
        return [$this->partial_challenge()];
    }

    /**
     * {@inheritdoc}
     */
    public function valid_completed_challenge(): array
    {
        return [
            [
                'id' => base64_encode('id'),
                'name' => 'name',
                'slug' => 'some-thing',
                'completedAt' => date(DATE_ISO8601),
                'completedLanguages' => ['one', 'two'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function partial_user(): array
    {
        return [
            'username' => $_ENV['CODEWARS_VALID_USERNAME'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function valid_user(): array
    {
        return [
            'username' => $_ENV['CODEWARS_VALID_USERNAME'],
            'name' => 'name',
            'honor' => 1,
            'clan' => 'clan',
            'leaderboardPosition' => 1,
            'skills' => ['one', 'two'],
            'ranks' => [
                'overall' => [
                    'rank' => 1,
                    'name' => 'name',
                    'color' => 'color',
                    'score' => 1,
                ],
                'languages' => [
                    'javascript' => [
                        'rank' => 1,
                        'name' => 'name',
                        'color' => 'color',
                        'score' => 1,
                    ],
                ],
            ],
            'codeChallenges' => [
                'totalAuthored' => 1,
                'totalCompleted' => 1,
            ],
        ];
    }
}
