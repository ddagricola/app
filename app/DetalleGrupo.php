<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleGrupo extends Model
{
  protected $table = 'detalle_grupo';
  public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id_grupo_intervencion',
    'id_detalle_intervencion',
    'nombre',
    'estado',
    'fecha_creacion',
    'email_creacion',
    'ip_creacion',
    'fecha_modificacion',
    'email_modificacion',
    'ip_modificacion'
  ];
}
