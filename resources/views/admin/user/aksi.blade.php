<div class="table-actions btn-group">
    <button class="btn btn-warning edit" data-id="{{ $datas->id }}"><i class="fa fa-edit "></i></button>
    <form action="{{ route('user.delete', $datas->id) }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <button type="submit" id="deleted" class="ms-3 btn btn-danger delete-confirm" data-id="{{ $datas->id }}"><i
                class="fa fa-times"></i></a>
    </form>
</div>
