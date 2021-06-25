<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$art->idarticulo}}">

    {!! Form::open(array('action'=>array('ArticuloController@destroy',$art->idarticulo),'method'=>'delete')) !!}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span arial-hidden="true">X</span>
                </button>
                <h4 class="modal-title">Eliminar Articulo</h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea eliminar Articulo</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

</div>