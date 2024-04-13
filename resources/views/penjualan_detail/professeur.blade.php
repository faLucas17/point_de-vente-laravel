<div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-labelledby="modal-member">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selectionnez les professeurs/h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-member table-hover">
                    <thead>
                        <th width="5%">#</th>
                        <th>Nom</th>
                        <th>Telephone</th>
                        <th>Adresse</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($professeur as $key => $item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                        onclick="pilihMember('{{ $item->id_professeur }}', '{{ $item->kode_professeur }}')">
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
<!-- visit "codeastro" for more projects! -->