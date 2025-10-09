<?php

namespace App\Http\Controllers;

use App\Models\LandingBlogs;
use App\Models\LandingBlogsDetalles;
use Illuminate\Http\Request;

class LandingBlogsController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Blogs';
        $blog = LandingBlogs::where('estado', 1)->first();
        $tableTitle = 'Listado de Blogs';
        // $detallesBlog = LandingBlogsDetalles::where('estado', 1)->get();
        return view('backend.blogs.blogs', compact('Title','blog', 'tableTitle'));
    }
    public function crearBlog()
    {
        $Title = 'Crear Blog';
        $ruta = 'blogs_item.save';
        $boton = 'Crear Blog';
        $blog = new LandingBlogsDetalles();
        return view('backend.blogs.item_blog', compact('Title' ,'blog', 'ruta', 'boton'));
    }

    public function update(Request $request)
    {
        $blog = LandingBlogs::find($request->id);
        $blog->titulo = $request->titulo;
        $blog->subtitulo = $request->subtitulo;
        $blog->detalle = $request->detalle;
        $blog->save();
        return response()->json(['success' => true, 'imagen_path' => '']);
    }
    public function datatableBlogs(Request $request)
    {
        try {
            $about = LandingBlogsDetalles::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'subtitulo' => $item->subtitulo,
                    'fecha' => $item->fecha,
                    'autor' => $item->autor,
                    'estado' => $item->estado == 1 ? 'Activo' : 'Inactivo',
                    'actions' => '
                    <div class="d-flex align-items-center">
                        <a type="button" href="/blogs/'.$item->id.'/edit" class="btn btn-sm btn-primary me-2" >
                            <i data-feather="edit"></i>
                        </a>
                        <button type="button" onclick="deleteNavItem(' . $item->id . ')" class="btn btn-sm btn-danger me-2" >
                            <i data-feather="x-circle"></i>
                        </button>
                    </div>
                ',
                ];
            }

            return response()->json([
                'draw' => intval(request()->input('draw')), // Mismo draw que envía el datatables
                'recordsTotal' => $about->count(),
                'recordsFiltered' => $about->count(),
                'data' => $data
            ], 200);

            // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {


        try {
            $blog = new LandingBlogsDetalles();

            // Verificar si se subió una imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                // Sanitizar el nombre del archivo: quitar caracteres especiales y espacios
                $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imageDir = public_path('front/img/blogs/'); // Directorio donde guardar la imagen
                $imagePath = $imageDir . $imageName;

                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($imageDir)) {
                    mkdir($imageDir, 0775, true); // Crear directorio con permisos 775
                }

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Convertir a color verdadero si es necesario
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    // Guardar como WebP
                    if (!imagewebp($imgResource, $imagePath)) {
                        throw new \Exception('Error al guardar la imagen en formato WebP.');
                    }
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/blogs/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Imagen por defecto si no se subió ninguna imagen
                $imagenPath = 'front/img/placeholder.jpg';
            }

            // Asignar valores al modelo
            $blog->titulo = $request->titulo;
            $blog->subtitulo = $request->subtitulo;
            $blog->detalle = $request->detalle_completo;
            $blog->imagen = $imagenPath;
            $blog->fecha = $request->fecha;
            $blog->autor = $request->autor;
            $blog->tipo = $request->tipo;
            $blog->tags = $request->tags;
            $blog->estado = 1;

            // Guardar en la base de datos
            $blog->save();

            return redirect()->route('seccionBlogs')->with('success', 'Blog actualizado exitosamente.');

        } catch (\Exception $e) {
            // Manejar el error y redirigir con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar el blog: ' . $e->getMessage()]);
            //dd($e->getMessage());
        }
    }

    public function updateBlog(Request $request)
    {

        try {
            $blog = LandingBlogsDetalles::findOrFail($request->id);

            // Verificar si se subió una imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                // Sanitizar el nombre del archivo: quitar caracteres especiales y espacios
                $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imageDir = public_path('front/img/blogs/'); // Directorio donde guardar la imagen
                $imagePath = $imageDir . $imageName;

                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($imageDir)) {
                    mkdir($imageDir, 0775, true); // Crear directorio con permisos 775
                }

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Convertir a color verdadero si es necesario
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    // Guardar como WebP
                    if (!imagewebp($imgResource, $imagePath)) {
                        throw new \Exception('Error al guardar la imagen en formato WebP.');
                    }
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/blogs/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Imagen por defecto si no se subió ninguna imagen
                $imagenPath = $blog->imagen;
            }

            // Asignar valores al modelo
            $blog->titulo = $request->titulo;
            $blog->subtitulo = $request->subtitulo;
            $blog->detalle = $request->detalle_completo;
            $blog->imagen = $imagenPath;
            $blog->fecha = $request->fecha;
            $blog->autor = $request->autor;
            $blog->tipo = $request->tipo;
            $blog->tags = $request->tags;
            $blog->estado = 1;

            // Guardar en la base de datos
            $blog->save();

            return redirect()->route('seccionBlogs')->with('success', 'Blog actualizado exitosamente.');

        } catch (\Exception $e) {
            // Manejar el error y redirigir con un mensaje de error
            //return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar el blog: ' . $e->getMessage()]);
            dd($e->getMessage());
        }
    }
    public function edit($id)
    {
        $Title = 'Editar Blog';
        $ruta = 'blogs.update';
        $boton = 'Actualizar Blog';
        $blog = LandingBlogsDetalles::find($id);
        return view('backend.blogs.item_blog', compact('Title' ,'blog', 'ruta', 'boton'));
    }
    public function delete(Request $request)
    {
        try {
            // Buscar el blog por el ID
            $blog = LandingBlogsDetalles::findOrFail($request->id);

            // Eliminar la imagen si existe
            if ($blog->imagen && file_exists(public_path($blog->imagen)) && $blog->imagen !== 'front/img/placeholder.jpg') {
                unlink(public_path($blog->imagen));
            }

            // Eliminar el blog de la base de datos
            $blog->estado = 0;
            $blog->save();

            return response()->json(['success' => true, 'message' => 'Blog eliminado exitosamente.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al eliminar el blog: ' . $e->getMessage()], 500);
        }
    }


    public function verBlog($id)
    {
        $blog = LandingBlogsDetalles::find($id);
        return view('landing/components/ver_blog', compact('blog'));
    }

}
