<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Typography extends Component
{
    public function render()
    {
        $chart = new PieChartModel();

        $chart->setTitle('Distribución de typography')
            ->addSlice('Dominicano', 35, '#f6ad55')
            ->addSlice('Extranjero', 25, '#fc8181')
            ->setAnimated(true)
            ->withLegend()
            ->withOnSliceClickEvent('onSliceClick');

        return view('livewire.dashboard.typography', compact('chart'));
    }
}
