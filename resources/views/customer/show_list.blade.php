<div class="kt-portlet__body">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputName">Nome</label>
            <input type="text" name="name" class="form-control" value="{{$customers->name ?? '' }}">
        </div>
        <div class="form-group col-md-4">
            <label for="inputCpfCnpj">CNPJ</label>
            <input type="text" name="cpf_cnpj" class="form-control" value="{{$customers->cpf_cnpj ?? '' }}">
        </div>
        <div class="form-group col-md-4">
            <label for="inputName">Tipo</label>
            <input type="text" name="type" class="form-control" value="{{ $customers->type ?? '' }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="inputCEP">CEP</label>
            <input type="text" name="cep" class="form-control" value="{{ $customers->cep ?? '' }}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress">Endereço</label>
            <input type="text" name="address" class="form-control" value="{{ $customers->address ?? '' }}">
        </div>
        <div class="form-group col-md-2">
            <label for="inputComplement">Complemento</label>
            <input type="text" name="complement" class="form-control" value="{{ $customers->complement ?? '' }}">
        </div>
        <div class="form-group col-md-2">
            <label for="inputCpfCnpj">Número</label>
            <input type="text" name="number" class="form-control" value="{{ $customers->number ?? '' }}">
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="inputName">Cidade</label>
            <input type="text" name="city" class="form-control" value="{{ $customers->city ?? '' }}">
        </div>
        <div class="form-group col-md-2">
            <label for="inputCpfCnpj">UF</label>
            <input type="text" name="state" class="form-control" value="{{ $customers->state ?? '' }}">
        </div>
    </div>
</div>