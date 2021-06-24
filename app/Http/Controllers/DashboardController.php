<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->prepareRequest($request);

        $city = new City();
        $city = $this->createOrUpdate($city, $request);

        return redirect()->route('cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Ciudad creada exitosamente'
            ]
        ]);
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
        $city = City::with(['logo','icon','header'])->where('id', $id)->first();

        if (!$city)
            return redirect()->route('cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Ciudad'
                ]
            ]);

        return view('cities.edit', compact('city'));
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
        $request = $this->prepareRequest($request);

        $city = City::find($id);

        if (!$city)
            return redirect()->route('cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Ciudad'
                ]
            ]);

        $city = $this->createOrUpdate($city, $request);

        return redirect()->route('cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Ciudad actualizada exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);

        if (!$city)
            return redirect()->route('cities.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Ciudad'
                ]
            ]);

        $city->selfDeleteLogo(); 
        $city->logo()->delete();
        $city->selfDeleteIcon(); 
        $city->icon()->delete();
        $city->selfDeleteHeader(); 
        $city->header()->delete();
        $city->brochure_city()->delete();
        $city->discount_city()->delete();
        $city->delete();

        return redirect()->route('cities.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Ciudad eliminada'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $seo_title =  $request->input('seo_title') == null ?
                      $request->input('title') . " | Ofertas y Catálogos en :month :year "  :
                      $request->input('seo_title');
        
        $seo_description = $request->input('seo_description') == null ?
                           "Ahorra con más de :count folletos y catálogos :tienda en :month :year. ✓ Ofertas & Promociones 100% verificadas hoy!" :
                           $request->input('seo_description');

        $request->request->add(['seo_title' => $seo_title]);
        $request->request->add(['seo_description' => $seo_description]);

        return $request;
    }

    public function createOrUpdate(City $city, Request $request)
    {
        $city->fill($request->all());
        $city->save();

        $this->uploadImages($city, $request);

        return $city;
    }

    public function uploadImages(City $city, Request $request)
    {
        if ($request->hasFile('logo')) {

            if ($city->logo){
                $city->selfDeleteLogo(); 
                $city->logo()->delete();
            }
            
            $image_meta = handle_image_upload('cities', $request->file('logo'));
            $image = new Image;
            $image->component_id = $city->id;
            $image->component = 'cities';
            $image->filename = $image_meta['name'];
            $image->url = $image_meta['url'];
            $image->meta = 'logo';
            $image->save();
            
        }

        if ($request->hasFile('icon')) {

            if ($city->icon){
                $city->selfDeleteIcon(); 
                $city->icon()->delete();
            }
            
            $image_meta = handle_image_upload('cities', $request->file('icon'));
            $image = new Image;
            $image->component_id = $city->id;
            $image->component = 'cities';
            $image->filename = $image_meta['name'];
            $image->url = $image_meta['url'];
            $image->meta = 'icon';
            $image->save();
            
        }

        if ($request->hasFile('header')) {

            if ($city->header){
                $city->selfDeleteHeader(); 
                $city->header()->delete();
            }
            
            $image_meta = handle_image_upload('cities', $request->file('header'));
            $image = new Image;
            $image->component_id = $city->id;
            $image->component = 'cities';
            $image->filename = $image_meta['name'];
            $image->url = $image_meta['url'];
            $image->meta = 'header';
            $image->save();
            
        }

    } 

    public function uploadImage(Request $request)
    {
       foreach ($request->file() as $file) {
            $meta = ($request->logo) ? 'logo' : 
                    (($request->icon) ? 'icon' : 'header');

            $image = Image::where([['component','cities'],
                                   ['meta', $meta ],
                                   ['component_id',$request->id]])
                          ->first();
            
            $image->selfDelete();
                
            $meta = handle_image_upload('cities', $file);

            if (!$image)
                return response()->json(['error' => 'Ha ocurrido un error.'], 200);

            $image->url = $meta['url'];
            $image->filename = $meta['name'];
            $image->save();
        }

        return response()->json($image, 200);
    }

    public function deleteImage(Request $request)
    {
        $image = Image::where([['component','cities'],
                               ['meta', $request->meta],
                               ['component_id',$request->key]])
                      ->first();

        if (!$image)
            return response()->json(['error' => 'Ha ocurrido un error.'], 200);

        $image->selfDelete();
        $image->url = '';
        $image->filename = '';
        $image->save();
        
        return response()->json([], 200);
    }

}
