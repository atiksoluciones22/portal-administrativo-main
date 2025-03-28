<div>
    <div class="chart-header">
        <div class="col-md-12">
            <label for="example">Filtro  de ejemplo</label>
            <select name="example" id="example" class="form-control">
                <option value="">Example</option>
            </select>
        </div>
    </div>

    <div class="chart">
        <livewire:livewire-pie-chart key="{{ $chart->reactiveKey() }}" :pie-chart-model="$chart" />
    </div>
 </div>
