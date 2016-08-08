<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="javascript:history.back()" ="" class="btn btn-primary">
                            <span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
                        </a>
                    </div>
                </div>
                <div class="box-body">

                    <table id="grid-paises" class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <td>Orden</td>
                                <td>Departamento</td>
                                <td>Municipio</td>
                                <td>Beneficiarios Asignados</td>
                                <td>Insumos por beneficiario</td>
                                <td>Beneficiarios Ingresados</td>
                            </tr>
                            <tr>
                                <td>{{$detalle->orden}}</td>
                                <td>{{$detalle->departamento}}</td>
                                <td>{{$detalle->municipio}}</td>
                                <td>{{$detalle->beneficiarios}}</td>
                                <td>{{$detalle->cantidad_por_beneficiario}}</td>
                                <td>
                                    <a href="#" class="alert-link">
                                        <b>11</b>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <!--<thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>-->
                    </table>
                    <br>
                    <fieldset class="form-group">
                        <label for="cui">Ingrese número de CUI
                        </label><br>
                        <input type="f
                        orm-control" name="" id="cui">    
                    </fieldset>
                    
                </div>
            </div>
        </div>
    </div>