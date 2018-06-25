<?php

namespace App\Controllers;

use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use League\Csv\Writer;

class TrackingController
{
    protected $view_path = 'tracking';
    protected $item_path = 'tracking/';

    /**
     * [$type_item_type_mapping description]
     * @var [type]
     */
    protected $type_item_type_mapping = [
        'news_views' => 'news',
        'events_views' => 'events',
        'website_views' => 'website',
    ];

    /**
     * [$csv_headers description]
     * @var [type]
     */
    protected $csv_headers = [
        'date_start','date_end','type','events','home','news','total'
    ];

    /**
     * [getTotalPageViews description]
     *
     * @param  [type] $date_start [description]
     * @param  [type] $date_end   [description]
     *
     * @return [type]             [description]
     */
    protected function getTotalPageViews($date_start, $date_end)
    {
        $tracking_data_total = Tracking::whereBetween('date', [$date_start, $date_end])
            ->where('type', 'website_views')
            ->get(['value']);
        return array_sum(array_column($tracking_data_total->toArray(), 'value')) ?? 0;
    }

    /**
     * [getTotalUniqueViews description]
     *
     * @param  [type] $date_start [description]
     * @param  [type] $date_end   [description]
     *
     * @return [type]             [description]
     */
    protected function getTotalUniqueViews($date_start, $date_end)
    {
        $tracking_data_unique = Tracking::whereBetween('date', [$date_start, $date_end])
                    ->select('session_id')
                    ->groupBy('session_id')
                    ->get();
        return count($tracking_data_unique->toArray());
    }

    /**
     * [buildCsvFromTrackingData description]
     *
     * @param  [type] $data       [description]
     * @param  [type] $date_start [description]
     * @param  [type] $date_end   [description]
     *
     * @return [type]             [description]
     */
    protected function buildCsvFromTrackingData($data, $date_start, $date_end)
    {
        $csv_data = [];

        foreach ($data as $tracking_type => $data_process) {
            $csv_data[] = [
                'date_start' => $date_start,
                'date_end' => $date_end,
                'type' => $tracking_type,
                'events' => $data_process['events'],
                'home' => $data_process['home'] ?? 'n/a',
                'news' => $data_process['news'],
                'total' => $data_process['website'],
            ];
        }

        $csv = Writer::createFromString('');
        $csv->insertOne($this->csv_headers);

        foreach ($csv_data as $row) {
            $csv->insertOne($row);
        }

        return $csv->getContent();
    }

    /**
     * [getTotalViewsPerType description]
     *
     * @param  [type] $date_start [description]
     * @param  [type] $date_end   [description]
     *
     * @return [type]             [description]
     */
    protected function getTotalViewsPerType($date_start, $date_end)
    {
        $tracking_data_per_page = Tracking::whereBetween(
            'date',
            [$date_start, $date_end]
        )
        ->select('type', 'value')
        ->groupBy('type', 'value')
        ->get();

        foreach ($tracking_data_per_page->toArray() as $tracking_data) {
            $type = $tracking_data['type'];
            $item_type = $this->type_item_type_mapping[$type];

            if (isset(${$item_type . "_view_count_total"})) {
                ${$item_type . "_view_count_total"} += $tracking_data['value'];
            } else {
                ${$item_type . "_view_count_total"} = $tracking_data['value'];
            }
        }

        $events_view_count_total = isset($events_view_count_total)
            ? $events_view_count_total
            : 0;
        $news_view_count_total = isset($news_view_count_total)
            ? $news_view_count_total
            : 0;
        $website_view_count_total = isset($website_view_count_total)
            ? $website_view_count_total
            : 0;

        // visits to home can be obtained from the difference between
        // website views and other page views
        $home_view_count_total = $website_view_count_total -
            ($events_view_count_total + $news_view_count_total);

        return [
            'events' => $events_view_count_total,
            'home' => $home_view_count_total,
            'news' => $news_view_count_total,
            'website' => $website_view_count_total,
        ];
    }

    /**
     * Gets data for unique views by type
     *
     * @param string $date_start
     * @param string $date_end
     *
     * @return array
     */
    protected function getUniqueViewsPerType($date_start, $date_end)
    {
        $tracking_data_unique_per_page = Tracking::whereBetween(
            'date',
            [$date_start, $date_end]
        )
        ->select('type', 'session_id')
        ->groupBy('type', 'session_id')
        ->get();

        foreach ($tracking_data_unique_per_page->toArray() as $tracking_data) {
            $type = $tracking_data['type'];
            $item_type = $this->type_item_type_mapping[$type];

            if (isset(${$item_type . "_view_count_unique"})) {
                ${$item_type . "_view_count_unique"}++;
            } else {
                ${$item_type . "_view_count_unique"} = 1;
            }
        }

        $home_view_count_unique = $website_view_count_unique -
            ($events_view_count_unique + $news_view_count_unique);

        return [
            'events' => $events_view_count_unique,
            'home' => $home_view_count_unique,
            'website' => $website_view_count_unique,
            'news' => $news_view_count_unique,
        ];
    }

    /**
     * Returns array with total and unique page view data
     *
     * @param string $date_start
     * @param string $date_end
     *
     * @return array
     */
    protected function getTrackingDataForCsv($date_start, $date_end)
    {
        return [
            'total' => $this->getTotalViewsPerType($date_start, $date_end),
            'unique' => $this->getUniqueViewsPerType($date_start, $date_end)
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date_start = $request->input('date_start') ?? Carbon::now()->subDays(7)->toDateString();
        $date_end = $request->input('date_end') ?? Carbon::now()->toDateString();

        $data = [
            'date_start' => $date_start,
            'date_end' => $date_end,
            'page_views' => $this->getTotalPageViews($date_start, $date_end),
            'unique_views' => $this->getTotalUniqueViews($date_start, $date_end)
        ];

        return view($this->view_path . '/index', [
            'tracking_json' => json_encode($data),
            'path' => $this->item_path]);
    }

    /**
     * Used for downloading CSV with tracking data
     *
     */
    public function downloadCsv(Request $request)
    {
        $date_start = $request->input('date_start') ?? Carbon::now()->subDays(7)->toDateString();
        $date_end = $request->input('date_end') ?? Carbon::now()->toDateString();

        $csv_string = $this->buildCsvFromTrackingData(
            $this->getTrackingDataForCsv($date_start, $date_end), $date_start, $date_end
        );
        $csv_filename = str_replace('-', '', "tracking_{$date_start}_{$date_end}.csv");

        header("Content-Disposition: attachment; filename={$csv_filename}");
        header('Content-Type: text/plain');
        header('Content-Length: ' . strlen($csv_string));
        header('Connection: close');

        echo $csv_string;
    }
}
