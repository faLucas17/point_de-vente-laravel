@extends('layouts.master')

@section('title')
Liste des salles de classes
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Liste des salles de classes</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="addForm('{{ route('salle.store') }}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle"></i> Ajouter une nouvelle salle</button>
                    <button onclick="deleteSelected('{{ route('salle.delete_selected') }}')" class="btn btn-danger  btn-flat"><i class="fa fa-trash"></i> supprimer</button>
                    <button onclick="cetakBarcode('{{ route('salle.cetak_barcode') }}')" class="btn btn-warning  btn-flat"><i class="fa fa-barcode"></i> Print Barcode</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-salle">
                    @csrf
                    <table class="table table-stiped table-bordered table-hover">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">#</th>
                            <th>Nom</th>
                            <th>Numéro</th>
                            <th>Capacité</th>
                            <th>Département</th>
                            <th>Batiment</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('salle.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('salle.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'numero'},
                {data: 'nama_salle'},
                {data: 'nama_batiment'},
                {data: 'nama_departement'},
                {data: 'capacite'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Unable to save data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Ajouter une salle de classe');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_salle]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Modifier une salle de classe');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_salle]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_salle]').val(response.nama_salle);
                $('#modal-form [name=id_batiment]').val(response.id_batiment);
                $('#modal-form [name=id_departement]').val(response.id_departement);
                $('#modal-form [name=capacite]').val(response.capacite);
            })
            .fail((errors) => {
                alert('Impossible d afficher les données');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Êtes-vous sûr de vouloir supprimer les données sélectionnées ?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Impossible de supprimer ces données');
                    return;
                });
        }
    }

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Voulez-vous vraiment supprimer la salle de classe sélectionnée ?')) {
                $.post(url, $('.form-salle').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Impossible de supprimer cette salle de classe');
                        return;
                    });
            }
        } else {
            alert('selectionner la salle que vous voulez supprimer');
            return;
        }
    }

    //function cetakBarcode(url) {
        //if ($('input:checked').length < 1) {
            //alert('Sélectionnez les données à imprimer');
            //return;
        //} else if ($('input:checked').length < 3) {
           // alert('Sélectionnez au moins 3 données à imprimer.');
            //return;
        //} else {
            //$('.form-salle')
                //.attr('target', '_blank')
                //.attr('action', url)
                //.submit();
        //}
    //}
</script>
@endpush