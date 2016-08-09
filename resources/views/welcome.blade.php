@extends('layouts.app')

@section('content')
    @if(Auth::user() != null && Auth::user()->id_rol == 4)
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-folder-open"></i> Recepción</a></li>
                <li class="active">Jefaturas</li>
            </ol>
        </section><br>
        <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Recepción</h3>
                            </div>
                            <div class="box-body">
                            <?php  $jefaturas = \App\RolAcceso::RolAcceso(); ?>
                                <div class="row">
                                <?php foreach($jefaturas as $item): ?>
                                    <?php 
                                        $bg = "bg-aqua";
                                        $ion = "ion-ios-albums-outline";
                                        if(\App\Jefatura::find($item->id_jefatura)->id == 1){
                                            $bg = "bg-green";
                                            $ion = "ion-ios-paper-outline";
                                        }else if(\App\Jefatura::find($item->id_jefatura)->id == 5){
                                            $bg = "bg-yellow";
                                            $ion = "ion-ios-copy-outline";

                                        }
                                    ?>
                                        <div class="col-lg-4">

                                          <div class="small-box {{$bg}}">
                                            <div class="inner">
                                              <h3>0</h3>

                                              <p>{{ \App\Jefatura::find($item->id_jefatura)->nombre }}</p>
                                            </div>
                                            <div class="icon">
                                              <i class="ion {{$ion}}"></i>
                                            </div>
                                            <a href="javascript:loadRecepcion({{ \App\Jefatura::find($item->id_jefatura)->id }})" class="small-box-footer">Ingresar <i class="fa fa-arrow-circle-right"></i></a>
                                          </div>
                                        </div>
                                <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    @endif
<script type="text/javascript">
    function loadRecepcion(id){
        location.href = "{{ url('recepcion/jefatura/nuevo') }}/"+id;
    }
</script>
@endsection
