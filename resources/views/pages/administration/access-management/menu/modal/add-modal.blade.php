<div class="modal fade" id="exampleModalScrollable3" tabindex="-1" aria-labelledby="modalTitle3" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalTitle3">Add Menu</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMenuForm">
                @csrf
                <div class="modal-body">
                    <!-- Menu Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                    </div>

                    

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control" id="url" name="url">
                        </div>
                        <div class="col-md-6">
                            <label for="route" class="form-label">Route</label>
                            <input type="text" class="form-control" id="route" name="route">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon">
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <input type="number" class="form-control" id="priority" name="priority" min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="0">-- No Parent (Top Level) --</option>
                            @foreach($tree as $node)
                                @include('pages.administration.access-management.menu.partials.option_node', ['node' => $node, 'prefix' => ''])
                            @endforeach
                        </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <div class="form-text">Pilih parent menu (jika ada). Kalau top level, biar kosong.</div>
                    </div>   
                </div>

                <!-- Footer Buttons -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
