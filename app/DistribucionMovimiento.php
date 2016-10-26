<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class DistribucionMovimiento extends Model
{
  protected $table = 'distribucion_movimiento';
  public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id_movimiento',
    'cantidad',
    'nbeneficiario',
    'fecha_creacion',
    'email_creacion',
    'ip_creacion',
    'fecha_modificacion',
    'email_modificacion',
    'ip_modificacion'
  ];

  public static function totalAsignacionEvento($id){
    return DB::select(DB::raw("select sum(nbeneficiario) as asignado from distribucion_movimiento where id_movimiento = $id and estado = 1"));
  }
}
