<div class="col-lg-4 col-12 p-2">
    <div class="input-group border mb-3">
        <span class="input-group-text"><i class="bi bi-{{ $icon }} mx-2"></i></span>
        <select class="form-control" wire:model="{{ $model }}">
            <option value="">Select {{ $model }}</option>
            @foreach ($array as $key => $value)
                <option value="{{  $value['id'] }}">{{ $value['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>
