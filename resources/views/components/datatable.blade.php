<div class="table-responsive">
    <div>
        <table class="table align-items-center">
            <thead class="thead-light">
                <tr>
                @foreach($thead as $th_key => $th_value)
                    <th>{{ $th_value }}</th>
                @endforeach
                @if($actions)
                    <th class="text-right">Actions</th>
                @endif
                </tr>
            </thead>
            <tbody class="list">
            @forelse($data as $row)
                <tr>
                    @foreach($thead as $th_key => $th_value)
                        <td>{{ $row->$th_key }}</td>
                    @endforeach
                    @if($actions)
                    <td class="text-right">
                            @if(array_key_exists('edit', $actions))
                            <a href="{{ route($actions['edit']['route_name'], [$actions['edit']['route_idparam'] => $row->id]) }}" class="btn btn-success btn-sm"><i class="@if(array_key_exists('icon', $actions['edit'])) {{ $actions['edit']['icon'] }} @else fas fa-edit @endif"></i></a>
                            @endif
                            @if(array_key_exists('delete', $actions))
                            <button type="button" data-href="{{ route($actions['delete']['route_name'], [$actions['delete']['route_idparam'] => $row->id]) }}" class="btn btn-warning btn-sm delete-button" data-toggle="modal" data-original-title="Delete" title="Delete" data-target="#delete-modal"><i class="fas fa-trash-alt"></i></button>
                            @endif
                            @if(array_key_exists('info', $actions))
                            <a href="{{ route($actions['info']['route_name'], [$actions['info']['route_idparam'] => $row->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i></a>
                            @endif
                            @if(array_key_exists('dismiss', $actions))
                            <a href="{{ route($actions['dismiss']['route_name'], [$actions['dismiss']['route_idparam'] => $row->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-times"></i></a>
                            @endif
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($thead) + 1 }}" class="text-center">No items</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if($data)
            {{ $data->links('components.pagination') }}
        @endif
    </div>
</div>
@if($actions && array_key_exists('delete', $actions))
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">
        	
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="py-3 text-center">
                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                    <h4 class="heading mt-4">Attention!</h4>
                    <p>Are you sure, you want to delete this item? It will be deleted forever.</p>
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a role="button" class="btn btn-white" href="#" id="delete-submit-button">Delete</a>
                <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Cancel</button>
            </div>
            
        </div>
    </div>
</div>
@endif