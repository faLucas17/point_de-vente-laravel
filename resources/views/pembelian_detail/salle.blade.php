<div class="modal fade" id="modal-salle" tabindex="-1" role="dialog" aria-labelledby="modal-salle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selectionnez une salle</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-salle table-hover">
                    <thead>
                        <th width="5%">#</th>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Prix d'achat</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($salle as $key => $item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                <td><span class="label label-success">{{ $item->numero }}</span></td>
                                <td>{{ $item->nama_salle }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                        onclick="pilihSalle('{{ $item->id_salle }}', '{{ $item->numero }}')">
                                        <i class="fa fa-check-circle"></i>
                                        Select
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>