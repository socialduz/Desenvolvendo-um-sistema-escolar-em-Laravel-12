<div class="row mb-3">
    <div class="col-12 col-md-8">
        <div class="form-group mb-0">
            <label for="titulo">Título <span class="text-danger">*</span></label>
            <input
                class="form-control @error('titulo') is-invalid @enderror"
                type="text"
                name="titulo"
                id="titulo"
                value="{{ old('titulo', $cargo->titulo ?? '') }}"
                maxlength="100"
                required
            >
            @error('titulo')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group mb-0">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                <option value="1" @selected(old('status', $cargo->status ?? 1) == 1)>Ativo</option>
                <option value="0" @selected(old('status', $cargo->status ?? 1) == 0)>Inativo</option>
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="form-group mb-0">
            <label for="descricao">Descrição <span class="text-danger">*</span></label>
            <textarea
                class="form-control @error('descricao') is-invalid @enderror"
                name="descricao"
                id="descricao"
                rows="4"
                required
            >{{ old('descricao', $cargo->descricao ?? '') }}</textarea>
            @error('descricao')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
