<div class="table-actions btn-group">
    <button class="btn btn-warning edit" data-id="{{ $data->id }}"><i class="fa fa-edit "></i></button>
    <form action="{{ route('produk-masuk.delete', $data->id) }}" id="form-delete">
        @csrf
        @method('DELETE')
        <button type="submit" id="delete" class="ms-3 btn btn-danger delete-confirm" data-id="{{ $data->id }}"><i
                class="fa fa-times"></i></a>
    </form>
</div>
