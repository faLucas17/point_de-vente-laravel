<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_salle" class="col-lg-2 col-lg-offset-1 control-label">Nom</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_salle" id="nama_salle" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_batiment" class="col-lg-2 col-lg-offset-1 control-label">Batiment</label>
                        <div class="col-lg-6">
                            <select name="id_batiment" id="id_batiment" class="form-control" required>
                                <option value="">Sélectionner un batiment</option>
                                @foreach ($batiment as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Numero" class="col-lg-2 col-lg-offset-1 control-label">Numero</label>
                        <div class="col-lg-6">
                            <input type="number" name="numero" id="numero" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="capacite" class="col-lg-2 col-lg-offset-1 control-label">Capacite</label>
                        <div class="col-lg-6">
                            <input type="number" name="capacite" id="capacite" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_departement" class="col-lg-2 col-lg-offset-1 control-label">Département</label>
                        <div class="col-lg-6">
                            <select name="id_departement" id="id_departement" class="form-control" required>
                                <option value="">Sélectionner un département</option>
                                @foreach ($departement as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-success"><i class="fa fa-save"></i> Sauvegarder</button>
                    <button type="button" class="btn btn-sm btn-flat btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Retour</button>
                </div>
            </div>
        </form>
    </div>
</div>