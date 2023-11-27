<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Area;
use App\Models\Auditoria;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Evaluacione;
use App\Models\Puesto;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ColaboradoreController
 * @package App\Http\Controllers
 */
class ColaboradoreController extends GlobalController
{

    public function index()
    {


        $colab = $this->getCurrentColab();
        $acceso = $this->getAccesoColaboradores();
        $accesoModulo = $acceso->crear == 1 || $acceso->leer == 1 || $acceso->actualizar == 1 || $acceso->eliminar == 1;
        $isAccess = $colab && $colab->rol == 1 || $colab && $colab->rol == 2 || $this->getAccesoColaboradores()->crear;
        if (!$isAccess && !$accesoModulo) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este modulo, si crees que fue un error comunicate con un administrador.']);
        }
        // NULLS VARIABLES
        $id_area = request('id_area');
        $id_departamento = request('id_departamento');
        $id_cargo = request('id_cargo');
        $id_puesto = request('id_puesto');
        $search = request('search');


        $cargos = Cargo::all();
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $colaboradores = null;


        // areas
        $areas = Area::all();
        if (!$areas->isEmpty() && !$id_area) $id_area = $areas[0]->id;

        $colaborador = $this->getCurrentColab();

        // Departamentos
        if ($id_area) $departamentos = Departamento::where('id_area', $id_area)->get();
        else $departamentos = Departamento::all();

        // Cargos
        $cargos = Cargo::all();

        // Puestos
        if ($id_cargo) $puestos = Puesto::where('id_cargo', $id_cargo)->get();

        $colaboradorForm = new Colaboradore();

        $search = request('search');
        $colaboradores =  null;
        $query = Colaboradore::query();

        if (!$isAccess && $colab) {
            $query->where('id_supervisor', $colaborador->id);
        }

        if ($id_cargo) {
            $colaboradores = $query->where('colaboradores.id_cargo', $id_cargo);
        }

        if ($id_puesto) {
            $colaboradores = $query->where('colaboradores.id_puesto', $id_puesto);
        }

        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('nombres', 'like', "%$search%")
                    ->orWhere('apellidos', 'like', "%$search%")
                    ->orWhere('dni', 'like', "%$search%");
            });
        }

        $colaboradores = $query->paginate();
        // SEDES
        $sedes = Sede::all();

        return view('colaboradore.index', compact('colaboradores', 'colaboradorForm', 'puestos', 'cargos', 'areas', 'departamentos', 'id_area', 'id_departamento', 'sedes', 'id_cargo', 'id_puesto'))
            ->with('i', (request()->input('page', 1) - 1) * $colaboradores->perPage());
    }

    public function create()
    {
        $colaboradore = new Colaboradore();
        $puestos = Puesto::pluck('nombre_puesto', 'id');
        $cargos = Cargo::pluck('nombre_cargo', 'id');


        return view('colaboradore.create', compact('colaboradore', 'puestos', 'cargos'));
    }


    public function store(Request $request)
    {
        request()->validate(Colaboradore::$rules);

        $colab = $this->getCurrentColab();

        $validateUser = User::where('email', $request->input('dni'))->first();
        if ($validateUser) {
            return response()->json(['error' => 'El usuario con el DNI ingresado ya existe'], 400);
        }


        $user = User::create([
            'name' => $request->input('nombres'),
            'email' => $request->input('dni'),
            'password' => bcrypt($request->input('dni')),
        ]);


        $colaborador = Colaboradore::create([
            'dni' => $request->input('dni'),
            'apellidos' => $request->input('apellidos'),
            'nombres' => $request->input('nombres'),
            'id_cargo' => $request->input('id_cargo'),
            'id_sede' => $request->input('id_sede'),
            'id_puesto' => $request->input('id_puesto'),
            'id_usuario' => $user->id,
        ]);

        $this->createAccesByColaborador($colaborador->id);
        $this->createEdas($colaborador->id);


        Auditoria::create([
            'id_colab' => $colab->id,
            'modulo' => 'Colaborador',
            'titulo' => 'Nuevo colaborador',
            'descripcion' => 'Se creo un nuevo colaborador con el DNI: ' . $colaborador->dni,
        ]);

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore created successfully.');
    }


    public function updateSupervisor()
    {
        $colab = $this->getCurrentColab();
        $id_colab = request('id_colab');
        $id_super = request('id_super');
        $Colab = Colaboradore::find($id_colab);
        $Colab->id_supervisor = $id_super;
        $Colab->save();

        Auditoria::create([
            'id_colab' => $colab->id,
            'modulo' => 'Colaborador',
            'titulo' => 'Supervisor agregado',
            'descripcion' => 'Se le asignó un nuevo supervisor al colaborador con el DNI: ' . $Colab->dni,
        ]);

        return response()->json(['success' => 'Colaborador actualizado correctamente.'], 202);
    }

    public function createAccesByColaborador($id)
    {
        $modulos = ['colaboradores',  'accesos', 'edas', 'areas', 'departamentos', 'cargos', 'puestos', 'sedes', 'reportes', 'objetivos'];
        foreach ($modulos as $modulo) {
            Acceso::create([
                'modulo' => $modulo,
                'crear' => 1,
                'leer' => 1,
                'actualizar' => 1,
                'eliminar' => 1,
                'id_colaborador' => $id
            ]);
        }
    }


    public function createEdas($id_colab)
    {

        $eva1 = Evaluacione::create();
        $eva2 = Evaluacione::create();


        $edas = Eda::all();
        foreach ($edas as $eda) {
            EdaColab::create([
                'id_eda' => $eda->id,
                'id_colaborador' => $id_colab,
                'id_evaluacion' => $eva1->id,
                'id_evaluacion_2' => $eva2->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colaboradore = Colaboradore::find($id);

        return view('colaboradore.show', compact('colaboradore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colaboradore = Colaboradore::find($id);
        $puestos = Puesto::pluck('nombre_puesto', 'id');
        $cargos = Cargo::pluck('nombre_cargo', 'id');
        return view('colaboradore.edit', compact('colaboradore', 'puestos', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Colaboradore $colaboradore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colaboradore $colaboradore)
    {
        request()->validate(Colaboradore::$rules);

        $colaboradore->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $colaboradore = Colaboradore::find($id)->delete();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore deleted successfully');
    }

    public function searchColaboradores(Request $request)
    {
        $q = $request->input('q');
        $colaboradores = Colaboradore::where('nombres', 'LIKE', "%$q%")
            ->orWhere('apellidos', 'LIKE', "%$q%")
            ->orWhere('dni', 'LIKE', "%$q%")
            ->take(15)
            ->get();

        return response()->json($colaboradores);
    }
}
