<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient as ClientBetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;


class AnalyticsService
{
    protected $client;
    protected $propertyId;

    public function __construct()
    {
        $this->propertyId = config('services.analytics.property_id');
        $credentialsPath = storage_path('app/analytics/credentials.json');

        if (!file_exists($credentialsPath)) {
            $this->client = null;
            return;
        }

        $this->client = new ClientBetaAnalyticsDataClient([
            'credentials' => $credentialsPath,
        ]);
    }

    public function getEventCount(string $eventName, string $startDate, string $endDate): int
    {
        if (!$this->client) {
            return 0;
        }

        $request = new RunReportRequest([
            'property' => 'properties/' . $this->propertyId,
            'dimensions' => [
                new Dimension(['name' => 'eventName']),
            ],
            'metrics' => [
                new Metric(['name' => 'eventCount']),
            ],
            'date_ranges' => [
                new DateRange([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]),
            ],
            'dimension_filter' => new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'eventName',
                    'string_filter' => new StringFilter([
                        'value' => $eventName,
                        'match_type' => MatchType::EXACT,
                    ]),
                ]),
            ]),
        ]);

        try {
            $response = $this->client->runReport($request);
            $row = $response->getRows()[0] ?? null;
            return $row ? (int) $row->getMetricValues()[0]->getValue() : 0;
        } catch (Exception $e) {
            Log::error('Analytics error: ' . $e->getMessage());
            return 0;
        }
    }
}
