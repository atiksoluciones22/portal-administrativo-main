<?php

namespace App\Livewire\DemographicReport;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Nationality extends Component
{
    public function render()
    {
        $chart = new PieChartModel();

        $chart->setTitle('Distribución de Nacionalidades')
            ->addSlice('Dominicano', 35, '#f6ad55')
            ->addSlice('Extranjero', 25, '#fc8181')
            ->setAnimated(true)
            ->withLegend()
            ->withOnSliceClickEvent('onSliceClick');

        return view('livewire.demographic-report.nationality', compact('chart'));
    }
}
