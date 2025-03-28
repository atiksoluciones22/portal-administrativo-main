<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class WorkerLocation extends Component
{
    public function render()
    {
        $chart = new PieChartModel();

        $chart->setTitle('Distribución de worker location')
            ->addSlice('Dominicano', 35, '#f6ad55')
            ->addSlice('Extranjero', 25, '#fc8181')
            ->setAnimated(true)
            ->withLegend()
            ->withOnSliceClickEvent('onSliceClick');

        return view('livewire.dashboard.worker-location', compact('chart'));
    }
}
