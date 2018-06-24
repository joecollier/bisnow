<?php

namespace App\Console\Commands;

use App\Models\Tracking;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateTrackingTableData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:generate_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $item_types = ['events','news'];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getTypeFromItemType($type)
    {
        if (in_array($type, $this->item_types)) {
            return "{$type}_views";
        }
    }

    protected function getTrackingValues($data, $fillable_values)
    {
        $values = $data->toArray();
        $values['type'] = $this->getTypeFromItemType($data['item_type']);

        $values_save = [];

        foreach ($fillable_values as $key) {
            $values_save[$key] = $values[$key];
        }

        return $values_save;
    }

    protected function getTrackingDataGroupedByType($date_start, $date_end)
    {
        $tracking_data = Views::whereBetween('created_at', [$date_start, $date_end])
            ->select(
                'item_type',
                'session_id',
                DB::raw('count(*) as value'))
            ->groupBy('item_type')
            ->groupBy('session_id')
            ->get(['item_type', 'session_id']);

        $tracking_data->map(function ($tracking_data) {
            $tracking_data['date'] = Carbon::now()->subDays(1)->toDateString();
            return $tracking_data;
        });

        return $tracking_data;
    }

    protected function storeTrackingDataByType($date_start, $date_end)
    {
        $tracking_data = $this->getTrackingDataGroupedByType($date_start, $date_end);

        $tracking = new Tracking();
        $fillable_values = $tracking->getFillable();

        foreach ($tracking_data as $data) {
            $values_save = $this->getTrackingValues($data, $fillable_values);

            if (!empty($values_save['type'])) {
                $tracking::updateOrCreate($values_save);
            }
        }
    }

    protected function getTrackingForWebsiteViews($date_start, $date_end)
    {
        $tracking_data = Views::whereBetween('created_at', [$date_start, $date_end])
            ->select('session_id', DB::raw('count(*) as value'))
            ->groupBy('session_id')
            ->get(['session_id']);

        $tracking_data->map(function ($tracking_data) {
            $tracking_data['date'] = Carbon::now()->subDays(1)->toDateString();
            return $tracking_data;
        });

        return $tracking_data;
    }

    protected function storeTrackingDataWebsiteViews($date_start, $date_end)
    {
        $tracking_data = $this->getTrackingForWebsiteViews($date_start, $date_end);

        $tracking = new Tracking();
        $fillable_values = $tracking->getFillable();

        foreach ($tracking_data as $data) {
            $values_save = $this->getTrackingValues($data, $fillable_values);
            $values_save['type'] = 'website_views';

            $tracking::updateOrCreate($values_save);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date_start = Carbon::now()->subDays(1)->toDateString();
        $date_end = Carbon::now()->toDateString();

        $this->storeTrackingDataByType($date_start, $date_end);
        $this->storeTrackingDataWebsiteViews($date_start, $date_end);
    }
}
