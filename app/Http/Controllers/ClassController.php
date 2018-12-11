<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$response = [
			'success' => false
		];

		if ($classes = \App\Classes::orderBy('class_date','asc')->with('bullet')->get())
		{
			$response = [
				'success' => true,
				'classes' => $classes
			];
		}

		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
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
    public function store(Request $request)
    {
		$response = [
			'success' => false,
			'classes' => []
		];
		$data = $request->all();

		if (isset($data['item']) && $class = \App\Classes::where('id', $data['item'])->with('bullet')->first())
		{
			$new_date = null;
			if ($data['direction'] === 1)
			{
				$new_date = (new \Carbon\Carbon($class->class_date))->subDay()->format('Y-m-d');
			}
			else
			{
				$new_date = (new \Carbon\Carbon($class->class_date))->addDay()->format('Y-m-d');
			}

			$new_col = \App\Classes::where('class_date', $new_date)->first();
			if (NULL === $new_col)
			{
				$col = new \App\Classes;
				$col->class_date = $new_date;
				$col->save();
			}
			$classes = \App\Classes::orderBy('class_date', 'asc')->with('bullet')->get();
			$response = [
				'success' => true,
				'classes' => $classes
			];
		}
		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
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
		$response = [
			'success' => false
		];
		$data = $request->all();

		if ($class = \App\Classes::where('id', $id)->first())
		{
			$class->class_date = $data['date'];
			if ($class->save())
			{
				$classes = \App\Classes::orderBy('class_date', 'asc')->with('bullet')->get();
				$response = [
					'success' => true,
					'classes' => $classes
				];

			}
		}

		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$response = [
			'success' => false,
			'classes' => []
		];

		if (is_numeric($id) && $class = \App\Classes::where('id', $id)->first())
		{
			$class->delete();
			$classes = \App\Classes::orderBy('class_date', 'asc')->with('bullet')->get();
			$response = [
				'success' => true,
				'classes' => $classes
			];

		}
		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }

	/**
	 * Updates relation goal-class.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postBullet(Request $request)
	{
		$response = [
			'success' => false,
			'classes' => []
		];
		$data = $request->all();

		$class = \App\Classes::where('id', $data['item'])->whereHas('bullet',function($query) use ($data) {
			$query->where('id',$data['goal']);
		})->first();

		if ($class !== NULL)
		{
			$class->bullet()->detach($data['goal']);
		} else {
			$bullet = \App\Classes::where('id', $data['item'])->with('bullet')->first();
			$bullet->bullet()->attach($data['goal']);
		}
		//$class->bullet()->attach($data['goal']);

		$classes = \App\Classes::orderBy('class_date', 'asc')->with('bullet')->get();
		$response = [
			'success' => true,
			'classes' => $classes
		];
		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
	}

	/**
	 * Updates relation evaluation-class.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postEvaluation(Request $request)
	{
		$response = [
			'success' => false,
			'classes' => []
		];
		$data = $request->all();

		if ($class = \App\Classes::where('id', $data['item'])->first())
		{
			if ($class->evaluation === 1)
			{
				$class->evaluation = 0;
			} else {
				$class->evaluation = 1;
			}
			$class->save();
		}

		$classes = \App\Classes::orderBy('class_date', 'asc')->with('bullet')->get();
		$response = [
			'success' => true,
			'classes' => $classes
		];
		return Response()->json($response, 200, [], JSON_NUMERIC_CHECK);
	}
}
