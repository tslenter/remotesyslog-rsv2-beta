<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;
use Elasticsearch;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function create()
    {
        return view('searches.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'searchtext' => 'required',
            'startdatetime' => 'required',
            'enddatetime' => 'required'
        ]);

        $search = new Search;

        $search->searchtext = $request->get('searchtext');
        $search->startdatetime = $request->get('startdatetime');
        $search->enddatetime = $request->get('enddatetime');
        $search->user_id = auth()->id();

        $search->save();

        return redirect('/searches/' . $search->id);
    }

    public function show(Request $request, $id)
    {
        $search = Search::find($id);


        if($request->get('page') !== null) $page = $request->get('page');
        else $page = 1;

        $params =
        [
            'index' => 'rsx*',
            'body' =>
            [
                'from' => ($page - 1) * 10,
                'size' => '10',
                'query' =>
                [
                    'bool' =>
                    [
                        'must' =>
                        [
                            [
                                'match' =>
                                [
                                    'MESSAGE' => $search->searchtext
                                ]
                            ],
                            [
                                'range' =>
                                [
                                    'ISODATE' =>
                                    [
                                        'gte' => Carbon::createFromFormat('Y-m-d H:i:s', $search->startdatetime)->toIso8601String(),
                                        'lte' => Carbon::createFromFormat('Y-m-d H:i:s', $search->enddatetime)->toIso8601String()
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'sort' =>
                [
                    'ISODATE' =>
                    [
                        'order' => 'DESC'
                    ]
                ]
            ]
        ];


        $answer = Elasticsearch::search($params);

        if(($answer['hits']['total']['value'] % 10) > 0)
        {
            $total_pages = ($answer['hits']['total']['value'] / 10) + 1;
        }
        else $total_pages = $answer['hits']['total']['value'] / 10;

        return view('searches.show')->with([
            'search' => $search,
            'results' => $answer['hits']['hits'],
            'total_pages' => $total_pages,
        ]);
    }
}
