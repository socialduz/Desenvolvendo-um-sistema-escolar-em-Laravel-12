<div class="row mb-3">
    <div class="col-12 col-md-8">
        <div class="form-group mb-0">
            <label for="tipo">Tipo <span class="text-danger">*</span></label>
            <input
                class="form-control @error('tipo') is-invalid @enderror"
                type="text"
                name="tipo"
                id="tipo"
                value="{{ old('tipo', $tipoConteudo->tipo ?? '') }}"
                maxlength="100"
                required
            >
            @error('tipo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group mb-0">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                <option value="1" @selected(old('status', $tipoConteudo->status ?? 1) == 1)>Ativo</option>
                <option value="0" @selected(old('status', $tipoConteudo->status ?? 1) == 0)>Inativo</option>
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
