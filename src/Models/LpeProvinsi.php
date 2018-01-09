<?php
namespace Satudata\Lpeprovinsi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LpeProvinsi extends Model
{
    protected $table = 'lpeprovinsi';
    protected $primaryKey = 'lpeprovinsiid';
    public $timestamps = false;

    public static function lpeprovinsiById($id)
    {
        return DB::table('lpeprovinsi')
            ->select(DB::raw('*'))
            ->where('lpeprovinsistatus',$id)
            ->where('lpeprovinsistatus',1)
            ->where('lpeprovinsilogid')
            ->orderBy('lpeprovinsiid', 'ASC');
    }

    public static function year()
    {
        $nYear = Date('Y');
        $sYear = $nYear - 5;

        return DB::table('lpeprovinsi')
            ->select(DB::raw(' EXTRACT(YEAR FROM lpeprovinsitgl) as tahun'))
            ->whereBetween('lpeprovinsitgl', array($sYear.'-01-01', $nYear.'-12-31'))
            ->groupBy('tahun');
    }

    public static function kotakode()
    {
        return DB::table('lpeprovinsi')
            ->select(DB::raw('lpeprovinsikotakode, kota_nama'))
            ->join('master_kota','master_kota.kota_kode','=','lpeprovinsi.lpeprovinsikotakode')
            ->groupBy(array('lpeprovinsikotakode', 'kota_nama'));
    }
}
