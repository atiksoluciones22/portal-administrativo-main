<?php

namespace App\Livewire\DemographicReport;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Absentism extends Component
{
    public function render()
    {
        $chart = new PieChartModel();

        $chart->setTitle('Distribución de Absentismo')
            ->addSlice('Dominicano', 35, '#f6ad55')
            ->addSlice('Extranjero', 25, '#fc8181')
            ->setAnimated(true)
            ->withLegend()
            ->withOnSliceClickEvent('onSliceClick');

        return view('livewire.demographic-report.absentism', compact('chart'));
    }
}
