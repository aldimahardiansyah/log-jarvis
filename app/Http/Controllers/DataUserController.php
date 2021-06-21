<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Holiday;
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

    public function index()
    {
        $user = Auth::user();
        $datas = $user->datas;
            // dd($datas);
        return view('user.data', compact('datas'));
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
            'date' => $tanggal,
            "time_in" => $time,
            "user_id" => Auth::user()->id,
        ]);

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
        $tanggal = $request["date"];
        $hari = $request["day"];
        $holiday = Holiday::select('date')->get()->toArray();

        if (($hari == 'Saturday') or ($hari == 'Sunday') or (in_array($tanggal, $holiday))) {
            if ($total_menit >= 240) {
                $lembur = "weekend 1";
            } elseif ($total_menit >= 480) {
                $lembur = "weekend 2";
            }
        } else {
            if ((strtotime($time_out) >= strtotime('19:00')) and (strtotime($time_out) <= strtotime('21:00'))) {
                $lembur = "lembur 1";
            } elseif (strtotime($time_out) >= strtotime('21:00')) {
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
            'date' => 'required|date',
            'day' => 'required|max:255',
            'time_in' => 'required',
            'time_out' => 'required',
            'total_hours' => 'required',
            'activity' => 'required|max:255',
            'site_name' => 'required|max:255',
            'name' => 'required',
        ]);

        $data = Data::where('id', $id)->update([
            "date" => $request["date"],
            "day" => $request["day"],
            "time_in" => $request["time_in"],
            "time_out" => $request["time_out"],
            "total_hours" => $request["total_hours"],
            "activity" => $request["activity"],
            "site_name" => $request["site_name"],
            "user_id" => $request["name"],
            "remark" => $lembur,
            "intensive" => $intensive,
        ]);

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
}