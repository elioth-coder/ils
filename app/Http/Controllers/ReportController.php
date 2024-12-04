<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Item;
use App\Models\Program;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function patron_list(Request $request)
    {
        $user    = UserDetail::where('email', Auth::user()->email)->first();
        $library = $user->library;

        $pdo  = DB::connection()->getPdo();
        $sql  = "SELECT * FROM `user_details` WHERE `library`=:library AND role NOT IN ('admin','staff','clerk','librarian') ";
        $sql .= ($request->input('college')==null) ? "" : "AND `college`=:college ";
        $sql .= ($request->input('program')==null) ? "" : "AND `program`=:program ";
        $sql .= ($request->input('year')==null)    ? "" : "AND `year`=:year ";
        $sql .= ($request->input('section')==null) ? "" : "AND `section`=:section ";
        $sql .= ($request->input('role')==null)    ? "" : "AND `role`=:role ";
        $sql .= ($request->input('status')==null)  ? "" : "AND `status`=:status ";

        $query = $pdo->prepare($sql);
        $parameters = [];
        if($request->input('college')) $parameters['college'] = $request->input('college');
        if($request->input('program')) $parameters['program'] = $request->input('program');
        if($request->input('year'))    $parameters['year']    = $request->input('year');
        if($request->input('section')) $parameters['section'] = $request->input('section');
        if($request->input('role'))    $parameters['role']    = $request->input('role');
        if($request->input('status'))  $parameters['status']  = $request->input('status');

        $parameters['library'] = $library;

        $query->execute($parameters);
        $patrons = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $colleges = College::all();
        $colleges = $colleges->map(function($college) {
            return [
                'key'   => $college->code,
                'value' => $college->name,
            ];
        });

        $programs = Program::all();
        $programs = $programs->map(function($program) {
            return [
                'key'   => $program->code,
                'value' => $program->name,
            ];
        });

        return view('reports.patron_list', [
            'patrons'  => $patrons,
            'colleges' => $colleges,
            'programs' => $programs,
        ]);
    }

    public function item_list_print(Request $request)
    {
        $data = $this->item_list_data($request);

        return view('reports.item_list_print', $data);
    }

    public function item_list_data(Request $request)
    {
        $user    = UserDetail::where('email', Auth::user()->email)->first();
        $library = $user->library;

        $hasDateFilter = false;
        if($request->input('date_acquired_start') || $request->input('date_acquired_end')) {
            $date_acquired_start = (int) strtotime($request->input('date_acquired_start'));
            $date_acquired_end   = (int) strtotime($request->input('date_acquired_end'));

            if($date_acquired_start <= $date_acquired_end) {
                $hasDateFilter = true;
            }
        }

        $publishers =
            Item::select('publisher')
                ->distinct()
                ->where('library', $library)
                ->get();
        $publishers = $publishers->map(function($item) {
            return $item->publisher;
        });

        $hasYearFilter = false;
        if($request->input('publication_year')) {
            $years = explode('-', $request->input('publication_year'));
            $from = (int) $years[0] ?? 0;
            $to   = (int) $years[1] ?? 0;

            if($from <= $to) {
                $hasYearFilter = true;
            }
        }

        $pdo = DB::connection()->getPdo();
        $sql  = "SELECT * FROM `items` WHERE `library`=:library ";
        $sql .= ($request->input('publisher')==null) ? "" : "AND `publisher`=:publisher ";
        $sql .= ($request->input('type')==null)      ? "" : "AND `type`=:type ";
        $sql .= ($request->input('format')==null)    ? "" : "AND `format`=:format ";
        $sql .= ($request->input('genre')==null)     ? "" : "AND `genre`=:genre ";
        $sql .= ($request->input('status')==null)    ? "" : "AND `status`=:status ";
        $sql .= (!$hasYearFilter)                    ? "" : "AND (`publication_year` BETWEEN :from AND :to) ";
        $sql .= (!$hasDateFilter)                    ? "" : "AND (`date_acquired` BETWEEN :date_acquired_start AND :date_acquired_end) ";
        $sql .= "ORDER BY `date_acquired` DESC ";

        $query = $pdo->prepare($sql);
        $parameters = [];
        if($request->input('publisher')) $parameters['publisher'] = $request->input('publisher');
        if($request->input('type'))      $parameters['type']      = $request->input('type');
        if($request->input('format'))    $parameters['format']    = $request->input('format');
        if($request->input('genre'))     $parameters['genre']     = $request->input('genre');
        if($request->input('status'))    $parameters['status']    = $request->input('status');
        if($hasYearFilter) {
            $parameters['from'] = $from;
            $parameters['to']   = $to;
        }
        if($hasDateFilter) {
            $parameters['date_acquired_start'] = $request->input('date_acquired_start') ?? '0000-00-00';
            $parameters['date_acquired_end']   = $request->input('date_acquired_end') ?? date('Y-m-d');
        }

        $parameters['library'] = $library;

        $query->execute($parameters);
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return [
            'items'      => $items,
            'publishers' => $publishers,
        ];
    }

    public function item_list(Request $request)
    {
        $data = $this->item_list_data($request);

        return view('reports.item_list', $data);
    }

    public function item_count(Request $request)
    {
        $user    = UserDetail::where('email', Auth::user()->email)->first();
        $library = $user->library;

        $publishers =
            Item::select('publisher')
                ->distinct()
                ->where('library', $library)
                ->get();
        $publishers = $publishers->map(function($item) {
            return $item->publisher;
        });

        $hasYearFilter = false;
        if($request->input('publication_year')) {
            $years = explode('-', $request->input('publication_year'));
            $from = (int) $years[0] ?? 0;
            $to   = (int) $years[1] ?? 0;

            if($from <= $to) {
                $hasYearFilter = true;
            }
        }

        $pdo = DB::connection()->getPdo();
        $pdo->exec("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
        $sql = "SELECT *,
                `title` AS `_title`,
                `status` AS `_status`,
                (
                    SELECT COUNT(*) FROM items
                    WHERE `title`=`_title`
                    AND `status`=`_status`
                ) AS `count` ";
        $sql .= "FROM `items` WHERE `library`=:library ";
        $sql .= ($request->input('publisher')==null) ? "" : "AND `publisher`=:publisher ";
        $sql .= ($request->input('type')==null)      ? "" : "AND `type`=:type ";
        $sql .= ($request->input('format')==null)    ? "" : "AND `format`=:format ";
        $sql .= ($request->input('genre')==null)     ? "" : "AND `genre`=:genre ";
        $sql .= ($request->input('status')==null)    ? "" : "AND `status`=:status ";
        $sql .= (!$hasYearFilter)                    ? "" : "AND (`publication_year` BETWEEN :from AND :to) ";

        $sql .= "GROUP BY `title` ";
        $sql .= ($request->input('status')!=null) ? "" : ", `status` ";

        $query = $pdo->prepare($sql);
        $parameters = [];
        if($request->input('publisher')) $parameters['publisher'] = $request->input('publisher');
        if($request->input('type'))      $parameters['type']      = $request->input('type');
        if($request->input('format'))    $parameters['format']    = $request->input('format');
        if($request->input('genre'))     $parameters['genre']     = $request->input('genre');
        if($request->input('status'))    $parameters['status']    = $request->input('status');
        if($hasYearFilter) {
            $parameters['from'] = $from;
            $parameters['to']   = $to;
        }

        $parameters['library'] = $library;

        $query->execute($parameters);
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('reports.item_count', [
            'items'      => $items,
            'publishers' => $publishers,
        ]);
    }

    public function attendance_list(Request $request)
    {
        $user    = UserDetail::where('email', Auth::user()->email)->first();
        $library = $user->library;

        $hasDateFilter = false;
        if($request->input('from') || $request->input('to')) {
            $from = (int) strtotime($request->input('from'));
            $to   = (int) strtotime($request->input('to'));

            if($from <= $to) {
                $hasDateFilter = true;
            }
        }

        $pdo  = DB::connection()->getPdo();
        $sql  =
            "SELECT `attendances`.`created_at` AS `log_time`, `user_details`.*
            FROM `attendances`
            INNER JOIN `user_details`
            ON `attendances`.`card_number` = `user_details`.`card_number`
            WHERE `library`=:library ";
        $sql .= ($request->input('college')==null) ? "" : "AND `college`=:college ";
        $sql .= ($request->input('program')==null) ? "" : "AND `program`=:program ";
        $sql .= ($request->input('year')==null)    ? "" : "AND `year`=:year ";
        $sql .= ($request->input('role')==null)    ? "" : "AND `user_details`.`role`=:role ";
        $sql .= (!$hasDateFilter)                  ? "" : "AND (`attendances`.`created_at` BETWEEN :from AND :to) ";
        $sql .= "ORDER BY `log_time` DESC ";

        $query = $pdo->prepare($sql);
        $parameters = [];
        if($request->input('college')) $parameters['college'] = $request->input('college');
        if($request->input('program')) $parameters['program'] = $request->input('program');
        if($request->input('year'))    $parameters['year']    = $request->input('year');
        if($request->input('role'))    $parameters['role']    = $request->input('role');
        if($hasDateFilter) {
            $parameters['from'] = $request->input('from') ?? '0000-00-00';
            $parameters['to']   = $request->input('to') ?? date('Y-m-d');
        }

        $parameters['library'] = $library;

        $query->execute($parameters);
        $patrons = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $colleges = College::all();
        $colleges = $colleges->map(function($college) {
            return [
                'key'   => $college->code,
                'value' => $college->name,
            ];
        });

        $programs = Program::all();
        $programs = $programs->map(function($program) {
            return [
                'key'   => $program->code,
                'value' => $program->name,
            ];
        });

        return view('reports.attendance_list', [
            'patrons'  => $patrons,
            'colleges' => $colleges,
            'programs' => $programs,
        ]);
    }

}
