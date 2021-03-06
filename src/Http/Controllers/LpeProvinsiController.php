<?php
namespace Satudata\Lpeprovinsi\Http\Controllers;

use Satudata\Lpeprovinsi\Models\LpeProvinsi;
use Satudata\Lpeprovinsi\Models\MasterWilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LpeProvinsiController extends Controller
{
    public function getIndex(Request $request){
        return view('main');
    }

    public function getList(Request $request)
    {
        $year = LpeProvinsi::year()->get();
        $kota = LpeProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){
                $query = DB::table('lpeprovinsi');
                $query = $query->select(DB::raw("lpeprovinsikotakode, kota_nama, SUM(lpeprovinsivalue) as lpeprovinsivalue, EXTRACT(YEAR FROM lpeprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','lpeprovinsi.lpeprovinsikotakode');
                $query = $query->whereBetween('lpeprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('lpeprovinsikotakode', $kotas->lpeprovinsikotakode);
                $query = $query->groupBy(array('lpeprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->orderBy('tahun')->get();

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
                        $datas[$a]['kode'] = $harga->lpeprovinsikotakode;
                        $datas[$a]['kota'] = $harga->kota_nama;
                        $datas[$a][$years->tahun] = $harga->lpeprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }

        return response()->json($datas);
    }

    public function createLpeProvinsi()
    {
        $header = '<div class="block-header">';
        $header .= '<h2 style="display: inline;">Laju Pertumbuhan Ekonomi (LPE) Provinsi Banten</h2>';
        $header .= '</div>';

        $provinsi = MasterWilayah::provinsi()->get();
        
        return view('backend.laporan.lpeprovinsi.create')
            ->with('header', $header)
            ->with('provinsis', $provinsi);
    }

    public function createLpeProvinsiSave(Request $request)
    {
        $lpeprovinsi = new LpeProvinsi();
        $lpeprovinsi->lpeprovinsivalue            = $request->input('lpeprovinsiValue');
        $lpeprovinsi->lpeprovinsitgl              = $request->input('lpeprovinsiTgl');
        $lpeprovinsi->lpeprovinsiprovincekode     = $request->input('lpeprovinsiProvinceKode');
        $lpeprovinsi->lpeprovinsikotakode         = $request->input('lpeprovinsiKotaKode');
        $lpeprovinsi->lpeprovinsicreatedate       = date('Y-m-d H:i:s');
        $lpeprovinsi->lpeprovinsicreateby         = 1;
        $lpeprovinsi->lpeprovinsistatus           = 1;

        if($lpeprovinsi->save())
        {
            $responses = array('message' => 'Penambahan telah disimpan.');
        }else{
            $responses = array('message' => 'Terjadi kesalaahan. Penambahan gagal disimpan.');
        }
        return response()->json($responses);
    }

    public function detailLpeProvinsi($id)
    {
        $header = '<div class="block-header">';
        $header .= '<h2 style="display: inline;">Organisasi</h2>';
        $header .= '</div>';

        $lpeprovinsi = LpeProvinsi::lpeprovinsiById($id)->get();

        return view('backend.laporan.lpeprovinsi.detail')
            ->with('header', $header)
            ->with('lpeprovinsi', $lpeprovinsi);
    }

    public function export($type){
        $year = LpeProvinsi::year()->get();
        $kota = LpeProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){
                $query = DB::table('lpeprovinsi');
                $query = $query->select(DB::raw("lpeprovinsikotakode, kota_nama, SUM(lpeprovinsivalue) as lpeprovinsivalue, EXTRACT(YEAR FROM lpeprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','lpeprovinsi.lpeprovinsikotakode');

                $query = $query->whereBetween('lpeprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('lpeprovinsikotakode', $kotas->lpeprovinsikotakode);
                $query = $query->groupBy(array('lpeprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->get();

//                foreach ($haragaberlaku as $harga){
                        $datas[$a]['Kota/Kabupaten'] = $kotas->kota_nama;
//                    $datas[$a][$years->tahun] = $harga->lpeprovinsivalue;
//                }

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
//                        $datas[$a]['kota'] = $harga->kota_nama;
                        $datas[$a][$years->tahun] = $harga->lpeprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }
        return Excel::create('Laju Pertumbuhan Ekonomi Provinsi Banten', function($excel) use ($datas) {
            $excel->sheet('mySheet', function($sheet) use ($datas)
            {
                $sheet->fromArray($datas);
            });
        })->download($type);
    }

    public function getKota($id)
    {
        $kota = MasterWilayah::kotaByKode($id)->get();
        return response()->json($kota->toArray());
    }

    public function getProvinsi(){
        $provinsi = MasterWilayah::provinsi()->get();
        return response()->json($provinsi);
    }

    public function getColumns()
    {
        $data1 = array(
            array(
                'label' => 'Kode',
                'field' => 'kode',
                'numeric' => false,
                'html' => false
            ),
            array(
                'label' => 'Kota',
                'field' => 'kota',
                'numeric' => false,
                'html' => false
            ),
        );

        $year = LpeProvinsi::year()->orderBy('tahun','ASC')->get();
        $data2 = array();
        $i=0;
        foreach($year as $y){
            $data2[$i]['label'] = $y->tahun;
            $data2[$i]['field'] = $y->tahun;
            $data2[$i]['numeric'] = true;
            $data2[$i]['html'] = false;
            $i++;
        }
        $datas = array_merge($data1, $data2);
        return response()->json($datas);
    }
}