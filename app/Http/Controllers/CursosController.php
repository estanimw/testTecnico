<?php

namespace App\Http\Controllers;
use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('mostrarFormularioCrearCursos', 'cargarCurso', 'eliminarCurso', 'editarCurso', 'actualizarCurso', 'listarCursos', 'inscribirEnCurso');
        $this->middleware('checkDocente')->except('listarCursos', 'inscribirEnCurso', 'index', 'createCurso', 'getCursos', 'getCursoPorID', 'editCurso', 'deleteCurso', 'cursosInscriptosDelUsuario');
    }

    public function mostrarFormularioCrearCursos(){
    	return view('formCursos');
    }

    public function cargarCurso(Request $request){
        $this->createCurso($request);

    	return redirect('cursos')->with('status-ok', 'El curso se ha añadido con éxito!');
    }

    public function eliminarCurso($id){
        $this->deleteCurso($id);

        return redirect()->route('cursos')->with('status-ok', 'El curso se ha eliminado con éxito!');
    }

    public function editarCurso(Curso $curso){
        return view('editarCursos', [
            'curso' => $curso
        ]);
    }

    public function actualizarCurso(Request $request, $id){
        $this->updateCurso($request, $id);

        return redirect()->route('cursos')->with('status-ok', 'El curso se ha actualizado con éxito!');
    }

    public function listarCursos(){
        $cursos = Curso::get();
        return view('cursos', compact('cursos'));
    }

    public function inscribirEnCurso(Curso $curso){
        $user = auth()->user();
        $data = [$user->id,$user->name,$user->charge];
        $cupo = $curso->cupo;
        $inscriptos = $curso->inscriptos;
        if (is_null($inscriptos)) {
            $inscriptos = '[]';
        }

        $arreglo = json_decode($inscriptos);
        foreach ($arreglo as $key => $alumno) {
            if ($alumno['0'] == $user->id) {
                return redirect()->route('cursos')->with('status-warning', 'Ya se encuentra inscripto a este curso.');
            }
        }

        array_push($arreglo, $data);
        $arreglo = json_encode($arreglo);

        $curso->update([
            'cupo' => $cupo-1,
            'inscriptos' => $arreglo
        ]);
        return redirect()->route('cursos')->with('status-ok', 'Se ha inscripto exitosamente!');
    }


    // API REST

    // me da el token csrf
    public function index()
    {
        return csrf_token();
    }

    // Crear un curso
    public function createCurso(Request $request){
        $curso = Curso::create(['curso' => $request->curso, 'cupo' => $request->cupo, 'docente' => $request->docente]);
        if ($curso) {
            return response()->json(['status' => 'OK', 'mensaje' => 'Curso creado con exito', 'data' => $curso],200);
        }
        else {
            return response()->json(['status' => 'OK', 'mensaje' => 'Error al crear el curso', 'data' => array()],200);
        }
    }

    // Obtener todos los cursos
    public function getCursos(){
        $cursos = Curso::get();
        if (count($cursos) > 0) {
            return response()->json([ 'status' => 'OK', 'mensaje' => 'Todos los cursos', 'data' => $cursos ]);
        }
        else {
            return response()->json([ 'status' => 'OK', 'mensaje' => 'Sin cursos', 'data' => array() ]);
        }
    }

    // Obtener curso específico
    public function getCursoPorID($id){
        $curso = Curso::find($id);
        if ($curso) {
            return response()->json(['status' => 'OK', 'mensaje' => 'Curso encontrado', 'data' => $curso],200);
        }
        else {
            return response()->json(['status' => 'OK', 'mensaje' => 'Error al buscar el curso', 'data' => array()],200);
        }
    }

    // Editar curso específico
    public function updateCurso(Request $request, $id){
        $curso = Curso::find($id);
        $curso->update(['curso' => $request->curso, 'cupo' => $request->cupo, 'docente' => $request->docente]);
        if ($curso) {
            return response()->json(['status' => 'OK', 'mensaje' => 'Curso editado correctamente', 'data' => $curso],200);
        }
        else {
            return response()->json(['status' => 'OK', 'mensaje' => 'Error al editar el curso especificado', 'data' => array()],200);
        }
    }

    // Eliminar curso específico
    public function deleteCurso($id){
        $curso = Curso::find($id);
        $curso->delete();
        if ($curso) {
            return response()->json(['status' => 'OK', 'mensaje' => 'Curso eliminado correctamente', 'data' => $curso],200);
        }
        else {
            return response()->json(['status' => 'OK', 'mensaje' => 'Error al eliminar el curso especificado', 'data' => array()],200);
        }
    }

    // Cursos a los que está inscripto el usuario especificado por id
    public function cursosInscriptosDelUsuario($id){
        // $curso = DB::select('select * from cursos where inscriptos = [?,name,charge]', [$id]);
        // $curso = Curso::where('inscriptos'[0], $id);
        $cursos = Curso::get();
        $retorno = array();

        foreach ($cursos as $index=>$curso) {
            $arregloUsuariosInscriptos = $curso->inscriptos;
            if ($arregloUsuariosInscriptos!=null) { // verifico que haya usuarios inscriptos en ese curso, sino pasa al siguiente
                foreach ($arregloUsuariosInscriptos as $indice => $usuario) {
                    if ($usuario[0] == $id) {
                        array_push($retorno, $curso);
                    }
                }
            }
        }

        if ($retorno) {
            return response()->json(['status' => 'OK', 'mensaje' => 'Se encontraron cursos a los que este usuario está inscripto', 'data' => $retorno],200);
        }
        else {
            return response()->json(['status' => 'OK', 'mensaje' => 'Error al encontrar cursos a los que este usuario este inscripto', 'data' => array()],200);
        }
    }
}