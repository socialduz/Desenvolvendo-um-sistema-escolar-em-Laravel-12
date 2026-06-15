<div class="row mb-3">
    <div class="col-12 col-md-8">
        <div class="form-group mb-0">
            <label for="nome">Nome <span class="text-danger">*</span></label>
            <input
                class="form-control @error('nome') is-invalid @enderror"
                type="text"
                name="nome"
                id="nome"
                value="{{ old('nome', $disciplina->nome ?? '') }}"
                maxlength="150"
                required
            >
            @error('nome')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group mb-0">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                <option value="1" @selected(old('status', $disciplina->status ?? 1) == 1)>Ativo</option>
                <option value="0" @selected(old('status', $disciplina->status ?? 1) == 0)>Inativo</option>
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
            <input
                class="form-control @error('descricao') is-invalid @enderror"
                type="text"
                name="descricao"
                id="descricao"
                value="{{ old('descricao', $disciplina->descricao ?? '') }}"
                maxlength="200"
                required
            >
            @error('descricao')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
