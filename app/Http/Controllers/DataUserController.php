<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function kirimTelegram($pesan) {
        $pesan = json_encode($pesan);
        $API = "https://api.telegram.org/bot1949808016:AAFeTd4niLCy_wCg6wG2Ds1UCocwpVLynWw/sendmessage?chat_id=-1001331458056&text=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function index()
    {
        $user = Auth::user()->id;
        // $datas = $user->data;
        $datas = Data::where('user_id', $user)->orderBy('date_in', 'DESC')->get();
        $keterangan = User::where('id', Auth::user()->id)->get();
        // dd($datas);
        return view('user.data', [
            'datas' => $datas,
            'keterangan' => $keterangan,
            'title' => 'History'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {   
        date_default_timezone_set('Asia/Jakarta');
        $time = date("H:i");
        $tanggal = date("Y-m-d");

        $data = Data::create([
            "date_in" => $tanggal,
            "time_in" => $time,
            "user_id" => Auth::user()->id,
        ]);

        $nameUser = Auth::user()->name;

        /* $this->kirimTelegram(urlencode("CHECK IN : \n\nUsername : " .$nameUser. "\nDate : " .$tanggal. "\nTime : " .$time )); */

        return redirect('/')->with('success', 'Time In Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lembur = "none";
        $total = $request["total_hours"];
        $time_out = $request["time_out"];
        // dd(strtotime($time_out) >= strtotime('21:00'));
        $total_jam = explode(':',$total, 2);
        $t_jam = intval($total_jam[0]);
        $t_menit = intval($total_jam[1]);
        $total_menit = ($t_jam * 60) + $t_menit;
        $tanggalMasuk = $request["date_in"];
        $tanggalKeluar = $request["date_out"];
        $hari = $request["day_in"];
        $holiday = Holiday::select('date')->get()->toArray();

        // function bedaHari($tanggal) {
        //     date_default_timezone_set('Asia/Jakarta');
        //     $tanggalNow = date("Y-m-d");
        //     $tanggal = $tanggal;
        //     $result = $tanggalNow != $tanggal;

        //     return $result;
        // }
        // dd(bedaHari($tanggal));

        if (($hari == 'Saturday') or ($hari == 'Sunday') or (in_array($tanggalMasuk, $holiday))) {
            if ($total_menit >= 240 && $total_menit < 480) {
                $lembur = "weekend 1";
            } elseif ($total_menit >= 480) {
                $lembur = "weekend 2";
            }
        } else {
            if (strtotime($time_out) >= strtotime('21:00')) {
                $lembur = "lembur 1";
            } elseif ($tanggalMasuk != $tanggalKeluar) {
                $lembur = "lembur 2";
            }
        }

        $intensive = 0;
        switch ($lembur) {
            case "lembur 1":
                $intensive = 25000;
                break;
            case "lembur 2":
                $intensive = 50000;
                break;
            case "weekend 1":
                $intensive = 50000;
                break;
            case "weekend 2":
                $intensive = 150000;
            break;
            default:
                $intensive = 0;
        }

        $request->validate([
            'date_in' => 'required|date',
            'day_in' => 'required|max:255',
            'time_in' => 'required',
            'date_out' => 'required|date',
            'day_out' => 'required|max:255',
            'time_out' => 'required',
            'total_hours' => 'required',
            'activity' => 'required|max:255',
            'site_name' => 'required|max:255',
            'name' => 'required',
        ]);

        $data = Data::where('id', $id)->update([
            "date_in" => $request["date_in"],
            "day_in" => $request["day_in"],
            "time_in" => $request["time_in"],
            "date_out" => $request["date_out"],
            "day_out" => $request["day_out"],
            "time_out" => $request["time_out"],
            "total_hours" => $request["total_hours"],
            "activity" => $request["activity"],
            "site_name" => $request["site_name"],
            "user_id" => $request["name"],
            "remark" => $lembur,
            "intensive" => $intensive,
        ]);

        $nameUser = Auth::user()->name;

        $this->kirimTelegram(urlencode("CHECK OUT : \n\nUsername : " .$nameUser. "\nDate In : " .$request["date_in"]. "\nDay In : " .$request["day_in"]. "\nTime In : " .$request["time_in"]. "\nDate Out : " .$request["date_out"]. "\nTime Out : " .$request["time_out"]. "\nTotal Hours : " .$request["total_hours"]. "\nActivity : " .$request["activity"]. "\nSite Name : " .$request["site_name"]));

        return redirect('/')->with('success', 'Time Out Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function past(Request $request)
    {   
        $lembur = "none";
        $total = $request["total_hours"];
        // dd($request);
        $time_out = $request["time_out"];
        // dd(strtotime($time_out) >= strtotime('21:00'));
        $total_jam = explode(':',$total, 2);
        $t_jam = intval($total_jam[0]);
        $t_menit = intval($total_jam[1]);
        $total_menit = ($t_jam * 60) + $t_menit;
        $tanggalMasuk = $request["date_in"];
        $tanggalKeluar = $request["date_out"];
        $hari = $request["day_in"];
        $holiday = Holiday::select('date')->get()->toArray();

        if (($hari == 'Saturday') or ($hari == 'Sunday') or (in_array($tanggalMasuk, $holiday))) {
            if ($total_menit >= 240 && $total_menit < 480) {
                $lembur = "weekend 1";
            } elseif ($total_menit >= 480) {
                $lembur = "weekend 2";
            }
        } else {
            if (strtotime($time_out) >= strtotime('21:00')) {
                $lembur = "lembur 1";
            } elseif ($tanggalMasuk != $tanggalKeluar) {
                $lembur = "lembur 2";
            }
        }

        $intensive = 0;
        switch ($lembur) {
            case "lembur 1":
                $intensive = 25000;
                break;
            case "lembur 2":
                $intensive = 50000;
                break;
            case "weekend 1":
                $intensive = 50000;
                break;
            case "weekend 2":
                $intensive = 150000;
            break;
            default:
                $intensive = 0;
        }

        $request->validate([
            'date_in' => 'required|date',
            'day_in' => 'required|max:255',
            'time_in' => 'required',
            'date_out' => 'required|date',
            'day_out' => 'required|max:255',
            'time_out' => 'required',
            'total_hours' => 'required',
            'activity' => 'required|max:255',
            'site_name' => 'required|max:255',
            'name' => 'required',
            'project' => 'required|numeric',
        ]);

        $data = Data::create([
            "date_in" => $request["date_in"],
            "day_in" => $request["day_in"],
            "time_in" => $request["time_in"],
            "date_out" => $request["date_out"],
            "day_out" => $request["day_out"],
            "time_out" => $request["time_out"],
            "total_hours" => $request["total_hours"],
            "activity" => $request["activity"],
            "site_name" => $request["site_name"],
            "user_id" => $request["name"],
            "project_id" => $request["project"],
            "remark" => $lembur,
            "intensive" => $intensive,
        ]);

        return redirect('/data_user')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function pastSakit($date_in, $time_in, $project)
    {
        $activity = "Izin Sakit";

        $data = Data::create([
            "date_in" => $date_in,
            "time_in" => $time_in,
            "user_id" => Auth::user()->id,
            "project_id" => $project,
            "activity" => $activity,
            "remark" => 'none',
            "intensive" => '0',
        ]);

        $nameUser = Auth::user()->name;

        /* $this->kirimTelegram(urlencode("CHECK IN : \n\nUsername : " .$nameUser. "\nDate : " .$tanggal. "\nTime : " .$time )); */

        return redirect('/data_user')->with('success', 'Data Berhasil Ditambahkan');
    }


}