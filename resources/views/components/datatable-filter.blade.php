<div class="accordion" id="filter">
    <div class="card">
        <div class="card-header" id="filter-heading" data-toggle="collapse" data-target="#filter-body" aria-expanded="false" aria-controls="filter-body">
            <h5 class="mb-0">Filter</h5>
        </div>
        <div id="filter-body" class="collapse" aria-labelledby="filter-heading" data-parent="#filter">
            <div class="card-body">
                <form action="{{ $route }}" method="get">
                    @foreach($rows as $row)
                        <div class="row">
                            @foreach($row as $input)
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label" for="filter-{{ $input['id'] }}">{{ $input['label'] }}</label>
                                        @if(isset($input['type']) && $input['type'] == 'select')
                                        <select class="form-control form-control-sm" id="filter-{{ $input['id'] }}" name="filter-{{ $input['id'] }}">
                                            <option value="">Select...</option>
                                            @foreach($input['options'] as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @elseif(isset($input['type']) && $input['type'] == 'datepicker')
                                        <div class="input-group">
                                            <select class="form-control form-control-sm col-3" name="filter-relation-{{ $input['id'] }}">
                                                <option value="=" selected>=</option>
                                                <option value=">">></option>
                                                <option value="<"><</option>
                                                <option value=">=">>=</option>
                                                <option value="<="><=</option>
                                            </select>
                                            <input class="form-control form-control-sm datepicker" placeholder="{{ $input['placeholder'] ?? '' }}" type="text" value="{{ $input['value'] ?? '' }}" name="filter-{{ $input['id'] }}">
                                        </div>
                                        @else
                                        <div class="input-group">
                                            @if(isset($input['relation']))
                                            <select class="form-control form-control-sm col-3" name="filter-relation-{{ $input['id'] }}">
                                                <option value="=" selected>=</option>
                                                <option value=">">></option>
                                                <option value="<"><</option>
                                                <option value=">=">>=</option>
                                                <option value="<="><=</option>
                                            </select>
                                            @endif
                                            <input class="form-control form-control-sm" type="{{ $input['type'] ?? 'text' }}" id="filter-{{ $input['id'] }}" placeholder="{{ $input['placeholder'] ?? '' }}" value="{{ $input['value'] ?? '' }}" name="filter-{{ $input['id'] }}">
                                        </div>
                                        @endif  
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-icon btn-primary btn-sm">
                                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                <span class="btn-inner--text">Search</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>