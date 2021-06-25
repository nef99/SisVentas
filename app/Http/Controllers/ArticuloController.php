<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\ArticuloFormRequest;
use sisVentas\Articulo;
use DB;

class ArticuloController extends Controller
{
    public function __construct(){

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $query= trim($request ->get('searchText'));
            $articulos= Articulo::join('categoria', 'categoria.idcategoria', '=','articulo.idarticulo')
            ->select('articulo.idarticulo', 'articulo.nombre', 'articulo.stock', 'categoria.nombre as categoria', 'articulo.descripcion', 'articulo.imagen', 'articulo.estado', 'articulo.codigo')
            ->where('articulo.nombre', 'LIKE', '%'.$query.'%')
            ->orwhere('articulo.codigo', 'LIKE', '%'.$query.'%')
            ->where('condicion', '=', '1')
            ->orderBy('articulo.idarticulo', 'desc')
            ->paginate(7);

            return view('almacen.articulo.index',["articulos"=>$articulos, "searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias= Categoria::where('condicion', '1')->get();
        return view('almacen.articulo.create',["categorias"=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloFormRequest $request)
    {
        $articulo= new Articulo();
        $articulo->idcategoria= $request->get('idcategoria');
        $articulo->codigo= $request->get('codigo');
        $articulo->nombre= $request->get('nombre');
        $articulo->stock= $request->get('stock');
        $articulo->descripcion= $request->get('descripcion');
        $categoria->estado='activo';

        if(Input::hasFile('imagen')){
            $file=Input::hasFile('imagen');
            $file->move(public_path().'/imagenes/articulos', $file->getClientOriginalName());
            $articulo->imagen=$file->getClientOriginalName();
            
        }
        $articulo->save();
        return redirect::to('almacen/articulo');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view ("almacen.articulo.show", ["categoria"=>Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulo=Articulo::findOrFail($id);
        $categorias=Categoria::where('condicion', '1')->get();
        return view ("almacen.articulo.edit", ["articulo"=>$articulo, "categorias"=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo= Articulo::findOrFail($id);
        $articulo->idcategoria= $request->get('idcategoria');
        $articulo->codigo= $request->get('codigo');
        $articulo->nombre= $request->get('nombre');
        $articulo->stock= $request->get('stock');
        $articulo->descripcion= $request->get('descripcion');
        

        if(Input::hasFile('imagen')){
            $file=Input::hasFile('imagen');
            $file->move(public_path().'/imagenes/articulos', $file->getClientOriginalName());
            $articulo->imagen=$file->getClientOriginalName();
            
        }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo =Articulo::findOrFail($id);
        $articulo->estado= 'Inactivo';
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
}
