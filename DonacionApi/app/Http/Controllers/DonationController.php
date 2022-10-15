<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->response['message'] = "Se han consultado todas las donaciones";
        $this->response['data'] = Donation::orderBy('created_at', 'DESC')->get();

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
        $donation = new Donation($request->all());
        $donation->reference = Donation::makeReference();

        $this->response['status'] = $donation->save();
        $this->response['data'] = $donation;
        $this->response['message'] = $this->response['status'] ? "Se ha guardado la donación correctamente" : "Ha ocurrido un error";

        return $this->response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        $this->response['data'] = $donation;
        $this->response['message'] = "Se ha consultado la donación";

        return $this->response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donation)
    {
        if ($donation->payment_status == "STARTED") {
            $donation->amount_paid = $request->amount;
            $donation->payment_status = $donation->amount == $request->amount ? "SUCCESSFUL" : "WRONG";

            $this->response['status'] = $donation->save();
            $this->response['message'] = $this->response['status'] ? "Se ha actualizado la donación correctamente" : "Ha ocurrido un error";
            $this->response['data'] = $donation;
        } else {
            $this->response['status'] = false;
            $this->response['message'] = "La donación ya fue pagada";
        }

        return $this->response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        $this->response['status'] = $donation->delete();
        $this->response['message'] = $this->response['status'] ? "Se ha eliminado la donación correctamente" : "Ha ocurrido un error";

        return $this->response;
    }
}
