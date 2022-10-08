<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    private $response = [
        'status' => true,
        'message' => '',
        'data' => []
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->response['data'] = Worker::orderBy('created_at', 'DESC')->get();
        $this->response['message'] = 'Query completed successfully!';
        return $this->response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Worker($request->all());

        $data->category = Worker::setCategory($data->salary);
        $data->salary_taxes = Worker::calulateSalaryTaxes($data->salary);

        $data->save();

        $this->response['data'] = $data;
        $this->response['message'] = 'Worker saved successfully!';
        return $this->response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {
        $this->response['data'] = $worker;
        $this->response['message'] = 'Query completed successfully!';
        return $this->response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $worker->update($request->all());
        $this->response['data'] = $worker;
        $this->response['message'] = 'Worker updated successfully!';
        return $this->response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();
        $this->response['message'] = 'Worker deleted successfully!';
        return $this->response;
    }
}
