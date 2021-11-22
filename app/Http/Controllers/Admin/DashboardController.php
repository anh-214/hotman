<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $select = 'Dashboard';
        $active = 'dashboard';
        // lấy dữ liệu đơn hàng ngày hôm nay
        return view('backend.main.dashboard',compact('select','active'));
    }
    public function getChart(Request $request){
          // thống kê 
        $all = [];
        $result_all = [];
        $result_problems = [];
        $output_all = [];
        $output_problems = [];
        $subdays = '7';
        if ($request->has('subdays')){
            $subdays = $request->input('subdays');
        }
        $time_subdays = Carbon::now()->subDays(intval($subdays))->setTimezone('Asia/Ho_Chi_Minh');
        $time_now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        if ($subdays == '365'){
            $data_all = Order::select([
                DB::raw('count(id) as `count`'), 
                DB::raw("(DATE_FORMAT(created_at, '%m/%Y')) as month_year")
                ])
                ->where('created_at', '>=', $time_subdays)
                // ->orderBy('created_at')
                ->groupBy('month_year')
                ->get();
            foreach($data_all as $entry) {
                $output_all[$entry->month_year] = $entry->count;
            }
            $result_all = $output_all;
            $data_promblems = Order::select([
                DB::raw('count(id) as `count`'), 
                DB::raw("(DATE_FORMAT(created_at, '%m/%Y')) as month_year")
                ])
                ->where('problem','!=',null)
                ->where('created_at', '>=', $time_subdays)
                // ->orderBy('created_at')
                ->groupBy('month_year')
                ->get();
            foreach($data_promblems as $entry) {
                $output_problems[$entry->month_year] = $entry->count;
            }
            for ($i = 11; $i >= 0; $i--){
                $time = Carbon::now()->subMonths($i)->format('m/Y');
                if (array_key_exists($time,$output_problems)){
                    $result_problems[$time] = $output_problems[$time];
                } 
                // else {
                //     $result_problems[$time] = 0;
                // };
            };
            // dd($result_all);
        } else {
            $data_all = Order::select([
                DB::raw('count(id) as `count`'), 
                DB::raw("(DATE_FORMAT(created_at, '%d/%m/%Y')) as day") 
                ])
                ->where('created_at', '>=', $time_subdays)
                ->groupBy('day')
                ->get();
            foreach($data_all as $entry) {
                $output_all[$entry->day] = $entry->count;
            }
            for ($i = $subdays-1; $i >= 0; $i--){
                $time = Carbon::now()->subDays($i)->format('d/m/Y');
                if (array_key_exists($time,$output_all)){
                    $result_all[$time] = $output_all[$time];
                } else {
                    $result_all[$time] = 0;
                };
            };
            $data_problems = Order::select([
                DB::raw('count(id) as `count`'), 
                DB::raw("(DATE_FORMAT(created_at, '%d/%m/%Y')) as day") 
                ])
                ->where('problem','!=',null)
                ->where('created_at', '>=', $time_subdays)
                ->groupBy('day')
                ->get();
            foreach($data_problems as $entry) {
                $output_problems[$entry->day] = $entry->count;
            }
            for ($i = $subdays-1; $i >= 0; $i--){
                $time = Carbon::now()->subDays($i)->format('d/m/Y');
                if (array_key_exists($time,$output_problems)){
                    $result_problems[$time] = $output_problems[$time];
                } else {
                    $result_problems[$time] = 0;
                };
            };
        }
        $orders = Order::whereBetween('created_at', [$time_subdays, $time_now])->get();
        $total_all = 0;
        $total_real = 0;
        $count_orders = 0;
        $count_problems = 0;
        foreach ($orders as $order){
            $all_order = explode(',',$order->type);
            $total_one = 0;
            foreach ($all_order as $one){
                $all = explode('-',$one);
                $type_id = $all[0];
                $type_info = Type::where('id',$type_id)->with('images')->first();
                $quantity = intval($all[2]);
                $total_one += $quantity*intval($type_info->price);
            }
            
            if ($order->delivered_at != null){
                $total_real += $total_one;
            }
            if ($order->problem == null){

                $total_all += $total_one;
            } else {
                $count_problems += 1;

            }
            $count_orders += 1;

        }
        // dd($orders);
        $all['all'] = $result_all;
        $all['problems'] = $result_problems;
        $all['total_all'] = $total_all;
        $all['total_real'] = $total_real;
        $all['count_orders'] = $count_orders;
        $all['count_problems'] = $count_problems;
        return json_encode($all);
    }
}
