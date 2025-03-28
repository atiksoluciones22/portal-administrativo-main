<?php

namespace App\Livewire\DemographicReport;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use App\Models\Worker;

class Sex extends Component
{
    public function render()
    {
        $sexoCounts = $this->getSexoCounts();

        $chart = $this->createPieChart($sexoCounts);

        return view('livewire.demographic-report.sex', compact('chart'));
    }

    /**
     * Obtiene el conteo de trabajadores por sexo.
     *
     * @return array
     */
    private function getSexoCounts()
    {
        return Worker::selectRaw('COUNT(*) AS CONTADOR, SEXO')
            ->where(function ($query) {
                $query->where('INACT', '=', '')
                      ->orWhereNull('INACT');
            })
            ->groupBy('SEXO')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['SEXO'] => $item['CONTADOR']];
            })
            ->toArray();
    }

    /**
     * Crea un gráfico de pastel con los conteos de sexo.
     *
     * @param array $sexoCounts
     * @return PieChartModel
     */
    private function createPieChart(array $sexoCounts)
    {
        $menCount = intval($sexoCounts[1] ?? 0);
        $womenCount = intval($sexoCounts[2] ?? 0);

        $chart = new PieChartModel();
        $chart->setTitle('Distribución de Sexo')
              ->addSlice($menCount . ' Hombres', $menCount, '#2B579A')
              ->addSlice($womenCount. ' Mujeres', $womenCount, '#fc8181')
              ->setAnimated(true)
              ->withLegend()
              ->withOnSliceClickEvent('onSliceClick');

        return $chart;
    }
}
